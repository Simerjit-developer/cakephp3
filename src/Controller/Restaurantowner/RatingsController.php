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
class RatingsController extends AppController
{
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
        $ratings = $this->Ratings->find('all',['contain' => ['Orders','Restaurants','Users']])->where(['Ratings.restaurant_id IN'=>$ids])->order(["Ratings.$sortby"=>"$order"]);
       // $ratings =  $ratings->all();
        $this->set(compact('ratings'));
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
        $rating = $this->Ratings->get($id);
        if ($this->Ratings->delete($rating)) {
            $this->Flash->success(__('The rating has been deleted.'));
        } else {
            $this->Flash->error(__('The rating could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
