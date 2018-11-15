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
class CartsController extends AppController
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
        $cart = $this->Carts->find('all')->where(['user_id'=>$user_id])->contain('Menus');
        if($cart){
            $response['status']=true;
            $response['data']=$cart;
        }else{
            $response['status']=false;
            $response['msg']='No item find in the cart!';
            $response['msg_p']='Nenhum item encontrado no carrinho!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Add method
     * @param user_id,restaurant_id,product_id,quantity,comment,refill
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Carts->deleteAll(['user_id'=>$this->request->getData('user_id'),'restaurant_id !='=>$this->request->getData('restaurant_id')]);
            $cart = $this->Carts->find('all')->where(['user_id'=>$this->request->getData('user_id'),'restaurant_id'=>$this->request->getData('restaurant_id'),'product_id'=>$this->request->getData('product_id'),'refill'=>$this->request->getData('refill')])->first();
            if($cart){
                $quantity = $cart->quantity;
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());
                $cart->quantity=$quantity+($this->request->getData('quantity'));
            }else{
                $cart = $this->Carts->newEntity();
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            }
            if ($this->Carts->save($cart)) {
                $response['status']=true;
                $response['msg']='Item has been added in cart.';
                $response['msg_p']='Item foi adicionado no carrinho.';
            }else{
                $response['status']=false;
                $response['msg']='Item could not be saved. Please, try again.';
                $response['msg_p']='Item não pôde ser salvo. Por favor, tente novamente.';
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
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            if ($this->Carts->save($cart)) {
                $response['status']=true;
                $response['msg']='The cart has been updated successfully.';
                $response['msg_p']='O carrinho foi atualizado com sucesso.';
            }else{
                $response['status']=false;
                $response['msg']='The cart could not be saved. Please, try again.';
                $response['msg_p']='O carrinho não pôde ser salvo. Por favor, tente novamente.';
            }
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
        $cart = $this->Carts->get($id);
        if ($this->Carts->delete($cart)) {
            $response['status']=true;
            $response['msg']='Item has been deleted';
            $response['msg_p']='Item foi eliminado';
        } else {
            $response['status']=false;
            $response['msg']='The cart could not be deleted. Please, try again.';
            $response['msg_p']='O carrinho não pôde ser excluído. Por favor, tente novamente.';
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
