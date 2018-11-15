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
class HelpRequestsController extends AppController
{

    /**
     * Add method
     * @param user_id,restaurant_id,order_id,waiter_id,table_id,type = refill/help
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $request = $this->HelpRequests->newEntity();
            $request = $this->HelpRequests->patchEntity($request, $this->request->getData());
            if ($this->HelpRequests->save($request)) {
                $response['status']=true;
                $response['msg']='Request has been submitted.';
                $response['msg_p']='Solicitação foi enviada.';
            }else{
                $response['status']=false;
                $response['msg']='Unable to save request. Please, try again.';
                $response['msg_p']='Não é possível salvar o pedido. Por favor, tente novamente.';
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
