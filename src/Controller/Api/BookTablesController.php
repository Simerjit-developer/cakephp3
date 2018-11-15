<?php
namespace App\Controller\Api;

use App\Controller\AppController;
/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BookTablesController extends AppController
{
    
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Push');
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //$demo = $this->BookTables->get(23,['contain'=>['Users','Restaurants','Tables']]);
       // debug($demo); exit;
        $this->loadModel('Tables');
        $table = $this->Tables->find('all')->where(['barcode_digits'=>$this->request->getData('bar_code')])->first();
        if(count($table)>0){
            $booktable = $this->BookTables->newEntity();
            if ($this->request->is('post')) {
                $user_id = $this->request->getData('user_id');
                $booktable = $this->BookTables->patchEntity($booktable, $this->request->getData());
                $booktable->table_id=$table->id;
                $booktable->restaurant_id = $table->restaurant_id;
                $booktable->booking_time=date('Y-m-d h:i:s');
                $saved = $this->BookTables->save($booktable);
                if ($saved) {
                    $booktable_id = $saved->id;
                    // Send notification to user for rewards
                    $this->loadModel('Orders');
                    $myorders = $this->Orders->find()->where(['user_id'=>$user_id,'restaurant_id'=>$table->restaurant_id])
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
                    }
                    $response['status']=true;
                    $response['msg']='Table has been booked';
                    $response['msg_p']='Tabela foi reservada';
                    $response['data']=$this->BookTables->get($booktable_id,['contain'=>['Users','Restaurants','Tables']]);
                }else{
                    $response['status']=false;
                    $response['msg']='Error while saving data.';
                    $response['msg_p']='Erro ao salvar dados.';
                }
            }
        }else{
            $response['status']=false;
            $response['msg']='Unable to fetch table.';
            $response['msg_p']='Não é possível buscar a tabela.';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /* gets the data from a URL */
    function get_data($url) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
    }
    private function generate_qr_code($unique_no,$image_name){
        $url = "https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=".$unique_no;
        $returned_content = $this->get_data($url);
       // $qrData = file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='+$unique_number);
        $file = new File(WWW_ROOT.'barcodes/'.$image_name, true);
        $file->write($returned_content);
        if($returned_content){
            return true;
        }else{
            return false;
        }
    }
    /*
     * 
     */
    public function generatebarcodes($restaurant_id=null){
        $this->loadModel('Restaurants');
        $restaurant = $this->Restaurants->get($restaurant_id, [
            'contain' => []
        ]);
        $table_count = $restaurant->total_tables;
        for($i=1;$i<=$table_count;$i++){
            $image_name = $restaurant_id.'r_t'.$i.'.jpg';
            $unique_number = mt_rand(10000, 99999);
            $qrCodeGenerated = $this->generate_qr_code($unique_number,$image_name);
            if($qrCodeGenerated){
                // save to db
                $table = $this->Tables->find('all')->where(['table_number'=>$i,'restaurant_id'=>$restaurant_id])->first();
                //print_r($table); exit;
                if(!$table){
                    $table = $this->Tables->newEntity();
                }
                $table = $this->Tables->patchEntity($table, $this->request->getData());
                $table->barcode_image='barcodes/'.$image_name;
                $table->table_number=$i;
                $table->barcode_digits=$unique_number;
                $table->restaurant_id=$restaurant_id;
                if ($this->Tables->save($table)) {
                    if($i==$table_count){
                        $this->Flash->success(__('The table has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
        }
    }
}
