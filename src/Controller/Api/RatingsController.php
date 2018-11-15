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
class RatingsController extends AppController
{
    /**
     * Add method
     * @param user_id,restaurant_id,order_id,service,quality,ambiance, comment
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $rating = $this->Ratings->newEntity();
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());
            $sum = $this->request->getData('service')+$this->request->getData('quality')+$this->request->getData('ambiance');
            $rating->avg_rating=$sum/3;
            $rating->reason = serialize($this->request->getData('reason'));
//            debug($rating); exit;
            if ($this->Ratings->save($rating)) {
                $this->loadModel('Restaurants');
                
                $all_ratings = $this->Ratings->find('all')->where(['restaurant_id'=>$this->request->getData('restaurant_id')])->toArray();
                $total_avg_rating=0;
                foreach ($all_ratings as $key => $value) {
                    $total_avg_rating+=$value->avg_rating;
                }
                $avg = $total_avg_rating/count($all_ratings);
                $restaurant = $this->Restaurants->get($this->request->getData('restaurant_id'));
                $restaurant->avg_rating =$avg;
                if($this->Restaurants->save($restaurant)){
                    $response['status']=true;
                    $response['msg']='Rating has been submitted.';
                    $response['msg_p']='Avaliação foi submetida.';
                }else{
                    $response['status']=false;
                    $response['msg']='Unable to save average rating.';
                    $response['msg_p']='Não é possível salvar a classificação média.';
                }
            }else{
                $response['status']=false;
                $response['msg']='Unable to save. Please, try again.';
                $response['msg_p']='Incapaz de salvar. Por favor, tente novamente.';
            }
        }else{
            $response['status']=false;
            $response['msg']='Post Method Required!';
            $response['msg_p']='Método de postagem obrigatório!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
