<?php
namespace App\Controller;

use App\Controller\AppController;

// To generate and read files
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TablesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($restaurant_id = null)
    {
        if($restaurant_id){
            $this->paginate = [
                'contain' => ['Restaurants','Waiters'],
                'conditions'=>['Tables.restaurant_id'=>$restaurant_id]
            ];
        }else{
            $this->paginate = [
                'contain' => ['Restaurants','Waiters'],
                'limit'=>100
            ];
        }
        
        $tables = $this->paginate($this->Tables);
        $this->set(compact('tables'));
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
        $table = $this->Tables->get($id, [
            'contain' => ['Restaurants','Waiters']
        ]);

        $this->set('table', $table);
    }


    public function printt($id = null){
        $table = $this->Tables->get($id, [
            'contain' => ['Restaurants','Waiters']
        ]);

        $this->set('table', $table);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $table = $this->Tables->newEntity();
        if ($this->request->is('post')) {
            $table = $this->Tables->patchEntity($table, $this->request->getData());
            if ($this->Tables->save($table)) {
                $this->Flash->success(__('The table has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The table could not be saved. Please, try again.'));
        }
        $restaurants = $this->Tables->Restaurants->find('list', ['limit' => 200]);
        $this->set(compact('table', 'restaurants'));
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
        $table = $this->Tables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $table = $this->Tables->patchEntity($table, $this->request->getData());
            if ($this->Tables->save($table)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $restaurants = $this->Tables->Restaurants->find('list', ['limit' => 200]);
        $waiters = $this->Tables->Waiters->find('list', ['conditions'=>['restaurant_id'=>$table->restaurant_id],'limit' => 200]);
        $this->set(compact('table', 'restaurants','waiters'));
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
        $table = $this->Tables->get($id);
        unlink(WWW_ROOT.$table->barcode_image);
        if ($this->Tables->delete($table)) {
            $this->Flash->success(__('The table has been deleted.'));
        } else {
            $this->Flash->error(__('The table could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
     * Generate 3 digit code 
     */
    private function getRandomCode(){
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }
    /*
     * Generate barcodes for each restaurant 
     */
    public function generatebarcodes($restaurant_id=null){
        $this->loadModel('Restaurants');
        $restaurant = $this->Restaurants->get($restaurant_id, [
            'contain' => []
        ]);
        $table_count = $restaurant->total_tables;
        for($i=1;$i<=$table_count;$i++){
            $image_name = $restaurant_id.'r_t'.$i.'.jpg';
            $restaurant_substr = substr(preg_replace("/\s+/","",$restaurant->name),0,3);
            $unique_number = $restaurant_substr.$this->getRandomCode();
            $exist = $this->Tables->find('all')->where(['barcode_digits'=>$unique_number])->count();
//            if($exist>0){
//                $restaurant_substr = substr(preg_replace("/\s+/","",$restaurant->name),0,3);
//                $unique_number = $restaurant_substr.$this->getRandomCode();
//            }
            $qrCodeGenerated = $this->generate_qr_code($unique_number,$image_name);
            if($qrCodeGenerated){
                // save to db
                $table = $this->Tables->find('all')->where(['table_number'=>$i,'restaurant_id'=>$restaurant_id])->first();
                if(!$table){
                    $table = $this->Tables->newEntity();
                }
                $table = $this->Tables->patchEntity($table, $this->request->getData());
                $table->barcode_image='barcodes/'.$image_name;
                $table->table_number=$i;
                $table->barcode_digits=$unique_number;
                $table->restaurant_id=$restaurant_id;
//                echo $unique_number;
//                exit;
                if ($this->Tables->save($table)) {
                    if($i==$table_count){
                        $this->Flash->success(__('The table has been saved.'));
                        return $this->redirect(['controller'=>'Restaurants','action' => 'index']);
                    }
                }
            }
        }
    }
}
