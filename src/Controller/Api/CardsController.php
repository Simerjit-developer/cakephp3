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
class CardsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $user_id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($user_id = null)
    {
        $cards = $this->Cards->find('all')->where(['user_id'=>$user_id]);
        if($cards){
            $response['status']=true;
            $response['data']=$cards;
        }else{
            $response['status']=false;
            $response['msg']='No card has been saved!';
            $response['msg_p']='Nenhum cartão foi salvo!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Add method
     * @param user_id,cardnumber,expiry_date,cardholder_name
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $card = $this->Cards->newEntity();
        if ($this->request->is('post')) {
            $card = $this->Cards->patchEntity($card, $this->request->getData());
            $exist = $this->Cards->find('all')->where(['user_id'=>$this->request->getData('user_id'),'cardnumber'=>$this->request->getData('cardnumber')])->toArray();
            if(count($exist)>0){
                $response['status']=false;
                $response['msg']='Card already added.';
                $response['msg_p']='Cartão já adicionado.';
            }else{
                if ($this->Cards->save($card)) {
                    $response['status']=true;
                    $response['msg']='The card has been saved.';
                    $response['msg_p']='O cartão foi salvo.';
                }else{
                    $response['status']=false;
                    $response['msg']='The card could not be saved. Please, try again.';
                    $response['msg_p']='O cartão não pôde ser salvo. Por favor, tente novamente.';
                }
            }
            
        }else{
            $response['status']=false;
            $response['msg']='Post Method Required!';
            $response['msg_p']='Método de postagem obrigatório!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
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
        $cart = $this->Cards->get($id);
        if ($this->Cards->delete($cart)) {
            $response['status']=true;
            $response['msg']='Card has been deleted';
            $response['msg_p']='Cartão foi deletado';
        } else {
            $response['status']=false;
            $response['msg']='The card could not be deleted. Please, try again.';
            $response['msg_p']='O cartão não pôde ser excluído. Por favor, tente novamente.';
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
