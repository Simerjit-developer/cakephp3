<?php
namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AmenitiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $amenities = $this->paginate($this->Amenities);

        if($amenities){
            $response['status']=true;
            $response['data']=$amenities;
        }else{
            $response['status']=false;
            $response['msg']='No item find in the cart!';
            $response['msg_p']='Nenhum item encontrado no carrinho';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
  
}
