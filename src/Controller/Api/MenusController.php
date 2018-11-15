<?php
namespace App\Controller\Api;

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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Restaurants', 'Categories']
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

        if($menu){
            $response['status']=true;
            $response['data']=$menu;
        }else{
            $response['status']=false;
            $response['msg']='Invalid Menu!';
            $response['msg_p']='Menu inválido!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
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
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
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
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
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
    /*
     * Get Categories of a Restaurant based on the menus
     */
    public function getCategories($restaurant_id){
        $menus = $this->Menus->find('all')->where(['restaurant_id'=>$restaurant_id])
                ->select(['category_id'])
                ->distinct()
                ->toArray();
        if($menus){
            $cat_id=[];
            foreach($menus as $menu){
                array_push($cat_id, $menu['category_id']);
            }
            $this->loadModel('Categories');
            $menu_categories = $this->Categories->find('all')->where(['id IN'=>$cat_id]);
            $categories = [];
            foreach ($menu_categories as $category){
                $dishes = $this->Menus->find('all')->where(['category_id'=>$category['id'],'restaurant_id'=>$restaurant_id]);
                $all['Category']=$category;
                $all['Dishes']=$dishes;
                $categories[]=$all;
            }
            $response['status']=true;
            $response['data']=$categories;
        }else{
            $response['status']=false;
            $response['msg']='No items found!';
            $response['msg_p']='Nenhum item encontrado!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /*
     * Fetch Menu's of a restaurant
     */
    public function fetchmenu($restaurant_id = null) {
        $menus = $this->Menus->find('list', ['conditions'=>['restaurant_id'=>$restaurant_id],'limit' => 200]);
        if($menus){
            $response['status']=true;
            $response['data']=$menus;
        }else{
            $response['status']=false;
            $response['msg']='No menu found';
            $response['msg_p']='Nenhum item encontrado!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
}
