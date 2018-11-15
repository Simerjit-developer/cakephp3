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
class FaqsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $faqs = $this->Faqs->find('all');
        if(count($faqs)>0){
            $response['status']=true;
            $response['data']=$faqs;
        }else{
            $response['status']=false;
            $response['msg']='No Data Found';
            $response['msg_p']='Nenhum dado encontrado';
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
