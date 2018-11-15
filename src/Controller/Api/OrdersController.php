<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
//use Omnipay\Omnipay;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController {
    
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Push');
    }

    /**
     * View method
     *
     * @param string|null $user_id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
//    public function view($order_id = null)
//    {
//        $order = $this->Orders->find('all')->where(['Orders.id'=>$order_id])->contain(['Users','Waiters','Tables','Restaurants','OrderItems'=>['Menus'=>['Categories']]])->toArray();
//        if($order){
//            $response['status']=true;
//            $response['data']=$order;
//        }else{
//            $response['status']=false;
//            $response['msg']='Unable to fetch data!';
//        }
//        $this->set('response', $response);
//        $this->set('_serialize', 'response');
//    }

    public function view($order_id = null) {
        $discount_ids = [];
        $order = $this->Orders->get($order_id, [
                    'contain' => [
                        'Users',
                        'Waiters',
                        'Tables',
                        'Discounts'=>function($q){
                            return $q->where(['valid_till'>date('Y/m/d h:i:s')]);
                        },
                        'Restaurants' => ['Discounts'=>'Menus'],
                        'OrderItems' => ['Menus' => ['Categories']]
                    ]
                ])->toArray();

        if (!empty($order)) {
            $query = $this->Orders->find()->where(['user_id'=>$order['user_id'],'restaurant_id'=>$order['restaurant_id']])
                    ->select([
                        'restaurant_id',
                        'count' => "COUNT(DISTINCT `id`)"
                    ])
                    ->group(['restaurant_id'])->toArray();
    //print_r($query); exit;
            $exist_orders = $this->Orders->find()->where(['user_id'=>$order['user_id'],'discount_id IS NOT'=>null,'restaurant_id'=>$order['restaurant_id']]);
            foreach ($exist_orders as $key => $value) {
                array_push($discount_ids, $value->discount_id);
            }
            if (!empty($order['restaurant']['discounts'])) {
                if (!empty($discount_ids)) {
                    foreach ($discount_ids as $discounts) {
                        $key = array_search($discounts, array_column($order['restaurant']['discounts'], 'id'));
                        if (is_numeric($key)) {
                            array_splice($order['restaurant']['discounts'], $key, 1);
//                            unset($order['restaurant']['discounts'][$key]);
                        }
                    }
                }
               // echo $query[0]->count; echo 'fg';
                
                if (!empty($order['restaurant']['discounts'])) {
                    foreach ($order['restaurant']['discounts'] as $keys => $rsdiscount) {
                        if(strtotime($rsdiscount['valid_till'])< strtotime(date('m/d/Y h:i A'))){
                            unset($order['restaurant']['discounts'][$keys]);
                          //  array_splice($order['restaurant']['discounts'], $keys, 1);
                          }else if ($rsdiscount['type'] == "visits") {
                            if ($query[0]->count < $rsdiscount['discount_after']) {
                               // echo $rsdiscount['discount_after']; 
                                unset($order['restaurant']['discounts'][$keys]);
//                                array_splice($order['restaurant']['discounts'], $keys, 1);
                            } elseif ($rsdiscount['type'] == "amount") {
                                if ($order['totalamount'] < $rsdiscount['discount_after']) {
                                    unset($order['restaurant']['discounts'][$keys]);
//                                    array_splice($order['restaurant']['discounts'], $keys, 1);
                                }
                            }
                        }else if($rsdiscount['type'] == "amount"){
                            if($order['subtotal'] < $rsdiscount['discount_after']){
                                unset($order['restaurant']['discounts'][$keys]);
//                                array_splice($order['restaurant']['discounts'], $keys, 1);
                            }
                        }
                    }
                }
            }
        }

        if ($order) {
            $response['status'] = true;
            $response['data'] = $order;
            //Send tax data with order
           $response['tax']=$order['restaurant']['tax'];
        } else {
            $response['status'] = false;
            $response['msg'] = 'Unable to fetch data!';
            $response['msg_p'] = 'Não é possível buscar dados!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function applydiscount() {
        $this->loadModel('Discounts');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order_id = $this->request->getData('order_id');
            $discount_id = $this->request->getData('discount_id');
            $order = $this->Orders->get($order_id,['contain'=>['OrderItems']]);
            $orderdata = $order->toArray();
            $user_id = $orderdata['user_id'];
            $restaurant_id = $orderdata['restaurant_id'];
            $exist = $this->Orders->find()->where(['restaurant_id'=>$restaurant_id,'user_id'=>$user_id,'discount_id'=>$discount_id])->first();
            if($exist){
                $response['status']=false;
                $response['msg']='Offer already used!';
                $response['msg_p']='Oferta já usada!';
            }else{
                $discount = $this->Discounts->get($discount_id,['contain'=>['Menus']])->toArray();
                if ((!empty($discount)) && (!empty($orderdata))) {
                if ($discount['discount_unit'] == "percentage") {
                    if($discount['menu_id'] !=NULL){
                        $quantity=1;
                        foreach($order['order_items'] as $orderitem){
                            if($orderitem['product_id']==$discount['menu']['id']){
                                $quantity = $orderitem['quantity'];
                            }
                        }
                        
                        $percentage = ($discount['discount_of'] / 100) * ($quantity * $discount['menu']['price']);
                        $order->orderdiscount = $percentage;
                        $order->totalamount = $orderdata['subtotal'] - $percentage;
                        $order->discount_id = $discount['id'];
                    }else{
                        $percentage = ($discount['discount_of'] / 100) * $orderdata['totalamount'];
                        $order->orderdiscount = $percentage;
                        $order->totalamount = $orderdata['subtotal'] - $percentage;
                        $order->discount_id = $discount['id'];
                    }
                    
                } elseif ($discount['discount_unit'] == "amount") {
                    if($discount['menu_id'] !=NULL){
                        $quantity=1;
                        foreach($order['order_items'] as $orderitem){
                            if($orderitem['product_id']==$discount['menu']['id']){
                                $quantity = $orderitem['quantity'];
                            }
                        }
                        if($discount['discount_of'] > ($quantity*$discount['menu']['price'])){
                            $order->orderdiscount = $quantity*$discount['menu']['price'];
                            $order->totalamount = $orderdata['subtotal'] - ($quantity*$discount['menu']['price'])+$orderdata['gratuity'];
                        }else{
                            $order->orderdiscount = $discount['discount_of'];
                            $order->totalamount = $orderdata['subtotal'] - $discount['discount_of']+$orderdata['gratuity'];
                        }
                        $order->discount_id = $discount['id'];
                    }else{
                        $order->orderdiscount = $discount['discount_of'];
                        $order->totalamount = $orderdata['subtotal'] - $discount['discount_of']+$orderdata['gratuity'];
                        $order->discount_id = $discount['id'];
                    }
                    
                }
                $responsedata['orderdiscount']=$order->orderdiscount;
                $responsedata['totalamount']=$order->totalamount;
                $responsedata['discount_id']=$order->discount_id;
                $responsedata['order_id']=$orderdata['id'];
                $response['status'] = true;
                $response['data'] = $responsedata;

//                if ($this->Orders->save($order)) {
//                    $this->view($orderdata['id']);
////                    $user_discount = $this->UserDiscounts->newEntity();
////                    $user_discount->user_id = $orderdata['user_id'];
////                    $user_discount->discount_id = $discount['id'];
////                    if ($this->UserDiscounts->save($user_discount)) {
////                        //echo "nitin";
////                        $this->view($orderdata['id']);
////                    }
//                } else {
//                    $response['status'] = false;
//                    $response['msg'] = 'unable to apply discount.';
//                }
            } else {
                $response['status'] = false;
                $response['msg'] = 'Invalid discount or order id';
                $response['msg_p'] = 'Desconto ou ID do pedido inválido';
            }
            }
            
        } else {
            $response['status'] = false;
            $response['msg'] = 'Invalid post method';
            $response['msg'] = 'Método de post inválido';
        }
        if(isset($response)){
            $this->set('response', $response);
            $this->set('_serialize', 'response');
        }
    }

    /**
     * View method
     *
     * @param string|null $user_id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewbyuser($user_id = null) {
        $order = $this->Orders->find('all')->where(['Orders.user_id' => $user_id])->contain(['Users', 'Tables', 'Waiters', 'Restaurants', 'OrderItems' => ['Menus']]);
        if ($order) {
            $response['status'] = true;
            $response['data'] = $order;
        } else {
            $response['status'] = false;
            $response['msg'] = 'No item find in the cart!';
            $response['msg_p'] = 'Nenhum item encontrado no carrinho!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Add method
     * @param user_id,product_id,quantity,comment,refill
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {

        if ($this->request->is('post')) {
            $this->loadModel('Carts');
            $items = $this->Carts->find('all')->where(['user_id' => $this->request->getData('user_id')])->contain('Menus')->toArray();
            $order = $this->request->getData();
            $quantity = 0;
            $total = 0;
            $orderItems = [];
            $itemdata = [];
            foreach ($items as $item) {
                $order['restaurant_id'] = $item->restaurant_id;
                $order['table_id'] = $this->request->getData('table_id');

                if ($item->refill == 1) {
                    if ($item->menu->freeavailable != 1) {
                        $total = $total + ($item->menu->price * $item->quantity);
                    }
                } else {
                    $total = $total + ($item->menu->price * $item->quantity);
                }
                if (in_array($item->product_id, $itemdata)) {
                    $key = array_search($item->product_id, array_column($order['order_items'], 'product_id'));
                    $order['order_items'][$key]['quantity'] = $order['order_items'][$key]['quantity'] + $item->quantity;
                    $order['order_items'][$key]['role'] = "abc";
                } else {
                    array_push($itemdata, $item->product_id);
                    $quantity = $quantity + $item->quantity;
                    $orderItems['user_id'] = $item->user_id;
                    $orderItems['restaurant_id'] = $item->restaurant_id;
                    $orderItems['product_id'] = $item->product_id;
                    $orderItems['quantity'] = $item->quantity;
                    $orderItems['comment'] = $item->comment;
                    $orderItems['refill'] = $item->refill;
                    $order['order_items'][] = $orderItems;
                }
            }
            $order['subtotal'] = $total;
            $order['user_id'] = $this->request->getData('user_id');
            $order['waiter_id'] = $this->request->getData('waiter_id');
            $order['gratuity'] = $this->request->getData('gratuity');
            $order['totalamount'] = $total + $this->request->getData('gratuity');
            $order['tax'] = 0;
            // Create Order Number for Today's order based on restaurant_id
            $orders_today = $this->Orders->find('all')->where(['DATE(Orders.created)' => date('Y-m-d'), 'restaurant_id' => $order['restaurant_id']])->toArray();
            $order['order_number'] = count($orders_today) + 1;


            $order_new = $this->Orders->newEntity($order, ['associated' => ['OrderItems']]);
            //debug($order_new); exit;
            if ($result = $this->Orders->save($order_new)) {
                $this->Carts->deleteAll(['user_id' => $this->request->getData('user_id')]);
                $response['status'] = true;
                $response['msg'] = 'The order has been saved.';
                $response['msg_p'] = 'O pedido foi salvo.';
                $order_id = $result->id;
                $response['data'] = $this->Orders->find('all')->where(['Orders.id' => $order_id])->contain(['Users', 'Tables', 'Waiters', 'Restaurants', 'OrderItems' => ['Menus']]);
            } else {
                $response['status'] = false;
                $response['msg'] = 'The order could not be saved. Please, try again.';
                $response['msg_p'] = 'O pedido não pôde ser salvo. Por favor, tente novamente.';
            }
        } else {
            $response['status'] = false;
            $response['msg'] = 'Post Method Required!';
            $response['msg'] = 'Método de postagem obrigatório!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderItems' => 'Menus', 'Restaurants','Tables','Users']
        ]);
        // debug($order); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if($this->request->getData('type')=='swap'){
                $order['table_id']=$this->request->getData('table_id');
                if ($this->Orders->save($order)) {
                    $response['status']=true;
                    $response['msg']='Table has been swapped successfully';
                    $response['msg_p']='Tabela foi trocada com sucesso';
                } else {
                    $response['status'] = false;
                    $response['msg'] = 'The order could not be saved. Please, try again.';
                    $response['msg_p'] = 'O pedido não pôde ser salvo. Por favor, tente novamente.';
                }
            }else{
                $order['gratuity'] = $this->request->getData('gratuity');
                $order['payment_method'] = $this->request->getData('payment_method');
                $order['totalamount'] = $this->request->getData('totalamount');
                $order['orderdiscount']=$this->request->getData('orderdiscount');
                $order['discount_id']=$this->request->getData('discount_id');
                $order['card_id']=$this->request->getData('card_id');
                $order['payment_token']=$this->request->getData('payment_token');
                $order['tax']=$this->request->getData('tax');

                if($order['waiter_id']==NULL){
                    $order['waiter_id']=$order['tables']['waiter_id'];
                }
                
                $commission = ($order->restaurant->commision / 100) * $order['subtotal'];
                $order['commission'] = $commission;
                if ($this->Orders->save($order)) {
                    if ($this->request->getData('payment_method') == 'cash') {
                        $email = new Email();
                        if($this->request->getData('current_language')=='portuguese'){
                            $email->setTemplate('invoice_portuguese');
                            $email->setSubject('Fatura Supperout');
                        }else{
                            $email->setTemplate('invoice');
                            $email->setSubject('Supperout Invoice');
                        }
                        
                        $email->setEmailFormat('html');
                        $email->setFrom('no-reply@simerjit.gangtask.com');
                        $email->setTo($this->request->getData('email'));
                        
                        $email->setViewVars(['orderdata' => $order]);
                        $email->send();
                        $response['status'] = true;
                        $response['msg'] = 'The order has been updated successfully.';
                        $response['msg_p'] = 'O pedido foi atualizado com sucesso.';
                    }else if ($this->request->getData('payment_method') == 'card'){
                        // Through Stripe
                        \Stripe\Stripe::setApiKey(\Cake\Core\Configure::read('Stripe.secret_key'));
                        // Create token using card
                        $token = \Stripe\Token::create(array(
                        "card" => array(
                          "number" => $this->request->getData('card_number'),
                          "exp_month" => $this->request->getData('card_expmonth'),
                          "exp_year" => $this->request->getData('card_year'),
                          "cvc" => $this->request->getData('card_cvc')
                        )
                      ));
                        /*$token = \Stripe\Token::create(array(
                        "card" => array(
                          "number" => "4242424242424242",
                          "exp_month" => 10,
                          "exp_year" => 2019,
                          "cvc" => "314"
                        )
                      ));*/
                        $token_id=$token->id;
                        //echo "<pre>";
                        //debug($token);
                        //$token_id = $this->request->getData('payment_token');
                        $products = [];
                        foreach($order->order_items as $item){
                            //create product
                            $product = \Stripe\Product::create(array(
                                "name" => $item->menu->name,
                                "type" => "good",
                                "description" => $item->menu->description,
                                'shippable'=>false
                              ));
                            // create sku
                            $sku = \Stripe\SKU::create(array(
                            "product" => $product->id,
                            "price" => $item->menu->price *100,
                            "currency" => "usd",
                            //"quantity"=>$item->quantity,
                            "inventory" => array(
                              "type" => "finite",
                              "quantity" => 500
                            )
                          ));
                            $sku_arr=[];
                            $sku_arr['type']='sku';
                            $sku_arr['parent']=$sku->id;
                            $sku_arr['quantity']=$item->quantity;
                            $products[]=$sku_arr;
                        }
                        /*
                         * Create Product for Gratuity
                         */
                        //create product
                        $product = \Stripe\Product::create(array(
                            "name" => "Gratuity",
                            "type" => "good",
                            "description" => "Gratuity",
                            'shippable'=>false
                          ));
                        // create sku
                        $sku = \Stripe\SKU::create(array(
                            "product" => $product->id,
                            "price" => $order->gratuity *100,
                            "currency" => "usd",
                            "inventory" => array(
                              "type" => "finite",
                              "quantity" => 500
                            )
                          ));
                        $sku_arr=[];
                        $sku_arr['type']='sku';
                        $sku_arr['parent']=$sku->id;
                        $products[]=$sku_arr;
                        /*
                         * Gratuity Product ends here
                         */
                        /*
                         * Create Product for Tax
                         */
                        //create product
                        $product1 = \Stripe\Product::create(array(
                            "name" => "Tax",
                            "type" => "good",
                            "description" => "Tax",
                            'shippable'=>false
                          ));
                        // create sku
                        $sku1 = \Stripe\SKU::create(array(
                            "product" => $product1->id,
                            "price" => $order->tax *100,
                            "currency" => "usd",
                            "inventory" => array(
                              "type" => "finite",
                              "quantity" => 500
                            )
                          ));
                        $sku_arr1=[];
                        $sku_arr1['type']='sku';
                        $sku_arr1['parent']=$sku1->id;
                        $products[]=$sku_arr1;
                        /*
                         * Gratuity Product ends here
                         */
                        if($products){
                            $new_order = \Stripe\Order::create(array(
                                "items" => $products,
                                "currency" => "usd",
                                "email" => $order->user->email
                              ));
                        if($order['orderdiscount']>0){
                            //Create a Coupon for discount
                            $discount = \Stripe\Coupon::create(array(
                                "amount_off" => $order['orderdiscount']*100,
                                "currency"=>'usd',
                                "duration" => "once"
                                )
                              );
                            $new_order->coupon=$discount->id;
                            $new_order->save();
                        }
                        //debug($new_order); //order id: or_1DLmVzAA6I2p7CBaIg1sVl4M
                        $payment = $new_order->pay(array('source'=>$token_id));
                        $my_order = $this->Orders->get($id, [
                'contain' => []
            ]);
                        $my_order->stripe_orderid=$payment->id;
                        $saved = $this->Orders->save($my_order);
                        if($payment->status =='paid'){
                            $response['status'] = true;
                            $response['msg'] = 'Payment has been completed successfully.';
                            $response['msg_p'] = 'O pagamento foi concluído com sucesso.';
                            $response['$saved']=$saved;
                        }else{
                            $response['status'] = true;
                            $response['msg'] = 'Payment status:'.$payment->status;
                            $response['msg_p'] = 'Status do pagamento:'.$payment->status;
                            $response['$saved']=$saved;
                        }
                        }else{
                            $response['status'] = false;
                            $response['msg'] = 'Error occured during payment! Please try again later!';
                            $response['msg_p'] = 'Erro ocorrido durante o pagamento! Por favor, tente novamente mais tarde!';
                        }
                    }

                } else {
                    $response['status'] = false;
                    $response['msg'] = 'The order could not be saved. Please, try again.';
                    $response['msg_p'] = 'O pedido não pôde ser salvo. Por favor, tente novamente.';
                }
            }
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /*
     * Add more items to an order
     * @param: order_id, user_id, product_id, quantity, comment, refill, restaurant_id
     */

    public function addmore($order_id = null) {
        $order = $this->Orders->get($order_id, [
            'contain' => []
        ]);
        $this->loadModel('OrderItems');
        // If Ordered item is for refill
        if($this->request->getData('refill') && $this->request->getData('refill')==1){
            $price = 0;
            $cart_item['order_id'] = $order_id;
            $cart_item['user_id'] = $this->request->getData('user_id');
            $cart_item['product_id'] = $this->request->getData('product_id');
            $cart_item['quantity'] = $this->request->getData('quantity');
            $cart_item['comment'] = $this->request->getData('comment');
            $cart_item['refill'] = $this->request->getData('refill');
            // If same item has been ordered then increase quantity
            $exist = $this->OrderItems->find('all')->where([
                'OrderItems.order_id' => $order_id,
                'OrderItems.user_id'=>$this->request->getData('user_id'),
                'OrderItems.product_id'=>$this->request->getData('product_id'),
                'OrderItems.comment'=>$this->request->getData('comment'),
                'OrderItems.refill'=>$this->request->getData('refill'),
                    ])->first();
            if(count($exist)>0){
                $orderitem = $this->OrderItems->patchEntity($exist, $cart_item);
                $orderitem->quantity = $exist->quantity + $this->request->getData('quantity');
            }else{
                $orderitem = $this->OrderItems->newEntity();
                $orderitem = $this->OrderItems->patchEntity($orderitem, $cart_item);
            }
            if ($this->OrderItems->save($orderitem)) {
                $product = $this->OrderItems->Menus->get($this->request->getData('product_id'), [
                    'contain' => []
                ]);
                $price += $product->price;
            }
        }else{
            $this->loadModel('Carts');
            $cartItems = $this->Carts->find('all')->where(['user_id' => $this->request->getData('user_id'), 'restaurant_id' => $this->request->getData('restaurant_id')]);
            $this->loadModel('OrderItems');
            $price = 0;
            foreach ($cartItems as $item) {
                $cart_item['order_id'] = $this->request->getData('order_id');
                $cart_item['user_id'] = $this->request->getData('user_id');
                $cart_item['product_id'] = $item->product_id;
                $cart_item['quantity'] = $item->quantity;
                $cart_item['comment'] = $item->comment;
                $cart_item['refill'] = $item->refill;
                // If same item has been ordered then increase quantity
                $exist = $this->OrderItems->find('all')->where([
                    'OrderItems.order_id' => $order_id,
                    'OrderItems.user_id'=>$this->request->getData('user_id'),
                    'OrderItems.product_id'=>$item->product_id,
                    'OrderItems.comment'=>$item->comment,
                    'OrderItems.refill'=>$item->refill,
                        ])->first();
                if(count($exist)>0){
                    $orderitem = $this->OrderItems->patchEntity($exist, $cart_item);
                    $orderitem->quantity = $exist->quantity +$item->quantity;
                }else{
                    $orderitem = $this->OrderItems->newEntity();
                    $orderitem = $this->OrderItems->patchEntity($orderitem, $cart_item);
                }

                if ($this->OrderItems->save($orderitem)) {
                    $product = $this->OrderItems->Menus->get($item->product_id, [
                        'contain' => []
                    ]);
                    $price += $product->price;
                }
            }
        }

        
        // Fetch all order items
        $all_items = $this->OrderItems->find('all')->where(['OrderItems.order_id' => $order_id])->contain(['Menus']);
        $subtotal = 0;
        foreach ($all_items as $value) {
            $quantity = $value->quantity;
            $product_price = $value->menu->price;
            if ($value->refill == 1) {
                if ($value->menu->freeavailable != 1) {
                    $updated_one = $quantity * $product_price;
                } else {
                    $updated_one = 0;
                }
            } else {
                $updated_one = $quantity * $product_price;
            }
            $subtotal +=$updated_one;
        }

        $order['subtotal'] = $subtotal;
        $order['totalamount'] = $subtotal;

        if ($this->Orders->save($order)) {
            if(isset($cartItems)){
                $this->Carts->deleteAll(['user_id' => $this->request->getData('user_id')]);
            }
            $response['status'] = true;
            $response['msg'] = 'The order has been updated successfully.';
            $response['msg_p'] = 'O pedido foi atualizado com sucesso.';
            //$response['$exist']=$exist;
        } else {
            $response['status'] = false;
            $response['msg'] = 'The order could not be saved. Please, try again.';
            $response['msg_p'] = 'O pedido não pôde ser salvo. Por favor, tente novamente.';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    /*
     * Fetch rewards for particular user
     * @params: user_id
     * @table: Orders, discounts, restaurants
     */
    public function myrewards($user_id = null){
        $myorders = $this->Orders->find()->where(['user_id'=>$user_id])
                    ->select([
                        'restaurant_id',
                        'count' => "COUNT(DISTINCT `id`)"
                    ])
                    ->group(['restaurant_id'])->toArray();
        $restaurants = [];
        if(count($myorders)>0){
            $this->loadModel('Restaurants');
            
            foreach ($myorders as $order) {
                $restaurant = $this->Restaurants->find()->where(['Restaurants.id'=>$order->restaurant_id])->contain(['Discounts'=>'Menus','Cuisines'])->first();
                $exist_orders = $this->Orders->find()->where(['user_id'=>$user_id,'discount_id IS NOT'=>null,'restaurant_id'=>$order->restaurant_id]);
                $used_discounts = [];
                foreach ($exist_orders as $key => $value) {
                    array_push($used_discounts, $value->discount_id);
                }
                //debug($restaurant);
                if($restaurant){
                if($restaurant->discounts){
                    $new_arr = [];
                    $new_arr['id']=$restaurant->id;
                    $new_arr['name']=$restaurant->name;
                    $new_arr['image']=$restaurant->image;
                    $new_arr['avg_rating']=$restaurant->avg_rating;
                    $new_arr['cuisines']=$restaurant->cuisine;
                    foreach ($restaurant->discounts as $discount) {
                        $current_date=strtotime(date('Y/m/d h:i A'));
                        $valid_till=strtotime($discount->valid_till);
                        if($current_date <= $valid_till && !in_array($discount->id, $used_discounts)){
                            $new_arr['discounts'][]=$discount;
                        }
                    }
                    array_push($restaurants, $new_arr);
                }
                }
            }
        }
        if(count($restaurants)>0){
            $response['status']=true;
            $response['data']=$restaurants;
        }else{
            $response['status']=false;
            $response['msg']='No Rewards yet!';
            $response['msg_p']='Ainda não há recompensas!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    /*
     * Send Push Notification for rewards
     */
    public function myrewardspush($user_id = null,$restaurant_id=null){
        $myorders = $this->Orders->find()->where(['user_id'=>$user_id,'restaurant_id'=>$restaurant_id])
                    ->select([
                        'restaurant_id',
                        'count' => "COUNT(DISTINCT `id`)"
                    ])
                    ->group(['restaurant_id'])->toArray();
        //print_r($myorders); exit;
        if(count($myorders)>0){
            $this->loadModel('Restaurants');
            $restaurants = [];
            foreach ($myorders as $order) {
                $restaurant = $this->Restaurants->find()->where(['Restaurants.id'=>$order->restaurant_id])->contain(['Discounts'=>'Menus','Cuisines'])->first();
                $exist_orders = $this->Orders->find()->where(['user_id'=>$user_id,'discount_id IS NOT'=>null,'restaurant_id'=>$order->restaurant_id]);
                $used_discounts = [];
                foreach ($exist_orders as $key => $value) {
                    array_push($used_discounts, $value->discount_id);
                }
                if($restaurant->discounts){
                    foreach ($restaurant->discounts as $discount) {
                        $current_date=strtotime(date('Y/m/d h:i A'));
                        $valid_till=strtotime($discount->valid_till);
                        if($current_date <= $valid_till && !in_array($discount->id, $used_discounts)){
                            $new_arr = [];
                            $new_arr['id']=$restaurant->id;
                            $new_arr['name']=$restaurant->name;
                            $new_arr['image']=$restaurant->image;
                            $new_arr['avg_rating']=$restaurant->avg_rating;
                            $new_arr['cuisines']=$restaurant->cuisine;
                            $new_arr['discounts'][]=$discount;
                            array_push($restaurants, $new_arr);
                        }
                    }
                }
            }
        }
        if(count($restaurants)>0){
            $response['status']=true;
            $response['data']=$restaurants;
            
            
            // Send notification to user
                $this->loadModel('Devices');
                $devices = $this->Devices->find('all')->where(['user_id'=>$user_id])->toArray();
                $ios_users = [];
                $android_users = [];
                foreach ($devices as $key => $device) {
                    if($device->device_type=='android'){
                        array_push($android_users, $device->device_token);
                    }elseif($device->device_type=='ios'){
                        array_push($ios_users, $device->device_token);
                    }
                }
                $msg = 'You have rewards that you can use while placing order and get discounts.';
                if(count($ios_users)>0){
                    $this->Push->IOSRewardPush($ios_users,$msg);
                }
                if(count($android_users)>0){
                    $this->Push->AndroidRewardPush($ios_users,$msg);
                }
        }else{
            $response['status']=false;
            $response['msg']='No Rewards yet!';
            $response['msg_p']='Ainda não há recompensas!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /*
     * Payment through stripe using stripe token
     * tok_1DGsEwAJ5T7d81q3gaUzXMqy
     */
    public function pay(){
        $order_id = 150;
        $order = $this->Orders->get($order_id,[
            'contain' => ['OrderItems' => 'Menus', 'Restaurants','Users']
        ]);
        debug($order); 
       // exit;
        \Stripe\Stripe::setApiKey(\Cake\Core\Configure::read('Stripe.secret_key'));
        // Create token using card
        $token = \Stripe\Token::create(array(
        "card" => array(
          "number" => "4242424242424242",
          "exp_month" => 10,
          "exp_year" => 2019,
          "cvc" => "314"
        )
      ));
        //echo "<pre>";
        debug($token);
        $products = [];
        foreach($order->order_items as $item){
            //create product
            $product = \Stripe\Product::create(array(
                "name" => $item->menu->name,
                "type" => "good",
                "description" => $item->menu->description,
                'shippable'=>false
              ));
            // create sku
            $sku = \Stripe\SKU::create(array(
            "product" => $product->id,
            "price" => $item->menu->price *100,
            "currency" => "usd",
            //"quantity"=>$item->quantity,
            "inventory" => array(
              "type" => "finite",
              "quantity" => 500
            )
          ));
            $sku_arr=[];
            $sku_arr['type']='sku';
            $sku_arr['parent']=$sku->id;
            $sku_arr['quantity']=$item->quantity;
            $products[]=$sku_arr;
        }
        //create product
        $product = \Stripe\Product::create(array(
            "name" => "Gratuity",
            "type" => "good",
            "description" => "Gratuity",
            'shippable'=>false
          ));
        // create sku
        $sku = \Stripe\SKU::create(array(
            "product" => $product->id,
            "price" => $order->gratuity *100,
            "currency" => "usd",
            "inventory" => array(
              "type" => "finite",
              "quantity" => 500
            )
          ));
        $sku_arr=[];
        $sku_arr['type']='sku';
        $sku_arr['parent']=$sku->id;
        $products[]=$sku_arr;
        if($products){
            $new_order = \Stripe\Order::create(array(
                "items" => $products,
                "currency" => "usd",
                "email" => $order->user->email
              ));
            
            //Create a Coupon for discount
            $discount = \Stripe\Coupon::create(array(
                "amount_off" => 25,
                "currency"=>'usd',
                "duration" => "once"
                )
              );
            $new_order->coupon=$discount->id;
            $new_order->save();
        debug($new_order); //order id: or_1DLmVzAA6I2p7CBaIg1sVl4M
        $payment = $new_order->pay(array('source'=>$token->id));
        if($payment->status =='paid'){
            
        }
        debug($payment);
        }
        echo 'fdh';
       // exit;
        
        exit;
        
    } 

}
