<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Push');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->getQuery('sort')){
            $sortby = $this->request->getQuery('sort');
        }else{
            $sortby = 'created';
        }
        if($this->request->getQuery('direction')){
            $order = $this->request->getQuery('direction');
        }else{
            $order='DESC';
        }
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $orders = $this->Orders->find('all')->where(['Orders.restaurant_id IN'=>$ids])->contain(['Users', 'Restaurants','Waiters'])->order(["Orders.$sortby"=>"$order"]);
        $orders =  $orders->all();
       
        if($this->request->is(['patch', 'post', 'put'])) {
            $startdate = $this->request->getData('startdate');
            $enddate = $this->request->getData('enddate');
            $mysqlstartdate = date('Y-m-d 00:00:00', strtotime($startdate));
            $mysqlenddate = date('Y-m-d 23:59:59', strtotime($enddate));
             $orders = $this->Orders->find(); 
                   $orders ->where([
                        'Orders.created BETWEEN :start AND :end'
                    ])
                    ->bind(':start', $mysqlstartdate, 'date')
                    ->bind(':end', $mysqlenddate, 'date')
                    ->where(['Orders.restaurant_id IN'=>$ids])
                    ->contain(['Users', 'Restaurants','Waiters']);
                    $orders =  $orders->all();
             }
            $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Restaurants','Waiters','OrderItems'=>'Menus']
        ]);

        $this->set('order', $order);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200]);
        $products = $this->Carts->Products->find('list', ['limit' => 200]);
        $this->set(compact('cart', 'users', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The Order has been deleted.'));
        } else {
            $this->Flash->error(__('The Order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /*
     * Assign Order to waiter
     */
    public function assign($id = null,$restaurant_id=null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                // Send notification to user
                $this->loadModel('Devices');
                $devices = $this->Devices->find('all')->where(['user_id'=>$order->user_id])->toArray();
                $ios_users = [];
                $android_users = [];
                foreach ($devices as $key => $device) {
                    if($device->device_type=='android'){
                        array_push($android_users, $device->device_token);
                    }elseif($device->device_type=='ios'){
                        array_push($ios_users, $device->device_token);
                    }
                }
                if(count($ios_users)>0){
                    $this->Push->IOSPush($ios_users,'Admin',$order->id,'Account','Waiter has been assigned to you!');
                }
                if(count($android_users)>0){
                    $this->Push->AndroidPush($ios_users,'Admin',$order->id,'Account','Waiter has been assigned to you!');
                }
                
                $this->Flash->success(__('Waiter has been assigned successfully.'));

                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to assign. Please, try again.'));
            }
        }
        
        $this->loadModel('Waiters');
        $waiters = $this->Waiters->find('list')->where(['restaurant_id'=>$restaurant_id]);
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Restaurants','Waiters']
        ]);

        $this->set(compact('waiters', 'order'));
    }
}
