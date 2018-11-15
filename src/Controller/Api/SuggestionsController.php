<?php
namespace App\Controller\Api;

use App\Controller\AppController;

use Cake\Routing\Router;
use Cake\Mailer\Email;
/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuggestionsController extends AppController
{

    /**
     * Add method
     * @param user_id,cardnumber,expiry_date,cardholder_name
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $suggestion = $this->Suggestions->newEntity();
        if ($this->request->is('post')) {
            $suggestion = $this->Suggestions->patchEntity($suggestion, $this->request->getData());
            if ($this->Suggestions->save($suggestion)) {
                $email = new Email();
                if($this->request->getData('current_language')=='portuguese'){
                    $email->setTemplate('enquiry_portuguese');
                    $email->setSubject('Sugestão Supperout');
                }else{
                    $email->setTemplate('enquiry');
                    $email->setSubject('Supperout  Suggestion');
                }
                
                $email->setEmailFormat('html');
                $email->setFrom('no-reply@simerjit.gangtask.com');
                $email->setTo('simerjit@avainfotech.com', 'Simerjit');
                
                $email->setViewVars(['restaurant_name' => $this->request->getData('restaurant_name'), 'location' => $this->request->getData('location'),'content'=>$this->request->getData('content')]);
                $email->send();
                $response['status']=true;
                $response['msg']='Thanks for the suggestion.We will work on this.';
                $response['msg_p']='Obrigado pela sugestão. Vamos trabalhar nisso.';
            }else{
                $response['status']=false;
                $response['msg']='Please, try again.';
                $response['msg_p']='Por favor, tente novamente.';
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
