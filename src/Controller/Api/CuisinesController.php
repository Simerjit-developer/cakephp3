<?php
namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Cuisines Controller
 *
 * @property \App\Model\Table\CuisinesTable $Cuisines
 *
 * @method \App\Model\Entity\Cuisine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CuisinesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //$cuisines = $this->Cuisines->find('list');
        $cuisines = $this->Cuisines->find('all');
        if(count($cuisines)>0){
            $response['status']=true;
            $response['data']=$cuisines;
        }else{
            $response['status']=false;
            $response['msg']='No Data Found';
            $response['msg_p']='Nenhum dado encontrado';
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
