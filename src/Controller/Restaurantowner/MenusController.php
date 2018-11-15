<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
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
        $this->paginate = [
            'contain' => ['Restaurants', 'Categories'],
            'conditions'=>['restaurant_id IN'=>$ids]
        ];
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['Restaurants', 'Categories']
        ]);

        $this->set('menu', $menu);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->getData()); exit;
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            $uploadPath = 'files/menus/';
            $supported_file_types = array('image/png','image/jpeg');
            $filedata = $this->request->getData('image');
            $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
            if($filedata_response['status']!=false){
                $menu->image=$filedata_response['image'];
            }else{
                $menu->image='';
            }
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $restaurants = $this->Menus->Restaurants->find('list', ['limit' => 200,'conditions'=>['user_id'=>$this->Auth->user('id')]]);
        $categories = $this->Menus->Categories->find('list', ['limit' => 200]);
        $this->set(compact('menu', 'restaurants', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $posted_data=$this->request->getData();
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            $supported_file_types = array('image/png','image/jpeg');
            $uploadPath = 'files/menus/';
            $filedata = $this->request->getData('image');
            if($filedata['error']==4){
                 $restaurant->image=$posted_data['old_image'];
            }else{
                $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
                if($filedata_response['status']==true){
                    $menu->image=$filedata_response['image'];
                }else if($filedata_response['status']==false){
                    die($filedata_response['msg']);
                }else{
                     $menu->image='';
                }
            }
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $restaurants = $this->Menus->Restaurants->find('list', ['limit' => 200]);
        $categories = $this->Menus->Categories->find('list', ['limit' => 200]);
        $this->set(compact('menu', 'restaurants', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
