<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;

use Cake\Routing\Router;
use Cake\Mailer\Email;
/**
 * Enqueries Controller
 *
 */
class EnqueriesController extends AppController
{
    /*
     * Send Enquiry email to admin
     */
    public function add(){
        if ($this->request->is('post')) {
            //debug($this->request->getData()); exit;
            $email = new Email();
            $email->setTemplate('enquiry');
            $email->setEmailFormat('html');
            $email->setFrom('no-reply@simerjit.gangtask.com');
            $email->setTo('simerjit@avainfotech.com', 'Simerjit');
            $email->setSubject('Supperout  Enquiry: '.$this->request->getData('subject'));
            $email->setViewVars(['name' => $this->request->getData('name'), 'subject' => $this->request->getData('subject'),'email'=>$this->request->getData('email'),'message'=>$this->request->getData('message')]);
            if ($email->send()) {
                $this->Flash->success(__('Message has been sent to administrator.He will revert you soon.'));

                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('Unable to send,Please try again!'));
                //$email->smtpError
            }
        }
    }
}

