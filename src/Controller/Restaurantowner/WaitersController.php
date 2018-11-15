<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;

/**
 * Restaurants Controller
 *
 * @property \App\Model\Table\RestaurantsTable $Restaurants
 *
 * @method \App\Model\Entity\Restaurant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WaitersController extends AppController
{
    
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Upload');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $waiters = $this->Waiters->find('all',['conditions'=>['Waiters.restaurant_id IN'=>$ids],'contain' => ['Restaurants']]);
        $waiters =  $waiters->all();
        $this->set(compact('waiters'));
    }

    /**
     * View method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $waiter = $this->Waiters->get($id, [
            'contain' => ['Restaurants']
        ]);

        $this->set('waiter', $waiter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $waiter = $this->Waiters->newEntity();
        if ($this->request->is('post')) {
            $waiter = $this->Waiters->patchEntity($waiter, $this->request->getData());
            $uploadPath = 'files/waiters/';
            $supported_file_types = array('image/png','image/jpeg');
            $filedata = $this->request->getData('image');
            $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
            if($filedata_response['status']!=false){
                $waiter->image=$filedata_response['image'];
            }else{
                $waiter->image='';
            }
            if ($this->Waiters->save($waiter)) {
                $this->Flash->success(__('The waiter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The waiter could not be saved. Please, try again.'));
        }
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $restaurants = $this->Waiters->Restaurants->find('list', ['conditions'=>['id IN'=>$ids],'limit' => 200]);
        $this->set(compact('waiter', 'restaurants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $waiter = $this->Waiters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $posted_data =$this->request->getData();
            $waiter = $this->Waiters->patchEntity($waiter, $this->request->getData());
            $supported_file_types = array('image/png','image/jpeg');
            $uploadPath = 'files/restaurants/';
            $filedata = $this->request->getData('image');
            if($filedata['error']==4){
                 $waiter->image=$posted_data['old_image'];
            }else{
                $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
                if($filedata_response['status']==true){
                    $waiter->image=$filedata_response['image'];
                }else if($filedata_response['status']==false){
                    die($filedata_response['msg']);
                }else{
                     $waiter->image='';
                }
            }
            if ($this->Waiters->save($waiter)) {
                $this->Flash->success(__('The waiter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The waiter could not be saved. Please, try again.'));
        }
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $restaurants = $this->Waiters->Restaurants->find('list', ['conditions'=>['id IN'=>$ids],'limit' => 200]);
        $this->set(compact('waiter', 'restaurants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $waiter = $this->Waiters->get($id);
        if ($this->Waiters->delete($waiter)) {
            $this->Flash->success(__('The waiter has been deleted.'));
        } else {
            $this->Flash->error(__('The waiter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
