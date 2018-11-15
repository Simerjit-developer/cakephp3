<?php
namespace App\Controller;

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
//        $this->paginate = [
//            'contain' => ['Restaurants', 'Categories']
//        ];
        $menus = $this->Menus->find('all', ['contain'=>['Restaurants', 'Categories']]); // $this->paginate($this->Menus);
        $menus= $menus->all();
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
            
            if($this->request->getData('freefill')!=null){
                $menu->freeavailable=1;
            }else{
                $menu->freeavailable=0;
            }
           
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
        $restaurants = $this->Menus->Restaurants->find('list', ['limit' => 200]);
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
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $posted_data = $this->request->getData();
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            $supported_file_types = array('image/png','image/jpeg');
            $uploadPath = 'files/menus/';
            $filedata = $this->request->getData('image');
            if($filedata['error']==4){
                 $menu->image=$posted_data['old_image'];
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
