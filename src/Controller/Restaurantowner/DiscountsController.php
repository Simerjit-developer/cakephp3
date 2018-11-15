<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiscountsController extends AppController
{

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
        $restaurants = $this->Discounts->Restaurants->find('list', ['conditions'=>['id IN'=>$ids],'limit' => 200]);
        
        $discounts = $this->Discounts->find('all',['conditions'=>['Discounts.restaurant_id IN'=>$ids],'contain' => ['Restaurants','Menus']]);
        $discounts =  $discounts->all();
        $this->set(compact('discounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => ['Menus','Restaurants']
        ]);

        $this->set('discount', $discount);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discount = $this->Discounts->newEntity();
        if ($this->request->is('post')) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        //$this->set(compact('discount'));
        
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $restaurants = $this->Discounts->Restaurants->find('list', ['conditions'=>['id IN'=>$ids],'limit' => 200]);
        $menus = $this->Discounts->Menus->find('list', ['conditions'=>['restaurant_id IN'=>$ids],'limit' => 200]);
        $this->set(compact('discount', 'restaurants','menus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        $this->loadModel('Restaurants');
        $restaurants = $this->Restaurants->find('list')->where(['user_id'=>$this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $restaurants = $this->Discounts->Restaurants->find('list', ['conditions'=>['id IN'=>$ids],'limit' => 200]);
        $menus = $this->Discounts->Menus->find('list', ['conditions'=>['restaurant_id'=>$discount['restaurant_id']],'limit' => 200]);
        $this->set(compact('discount', 'restaurants','menus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discount = $this->Discounts->get($id);
        if ($this->Discounts->delete($discount)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
}
