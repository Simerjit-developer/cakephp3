<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;

use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;

use Cake\Filesystem\Folder;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Upload');
    }
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Carts', 'Restaurants']
        ]);
        if($user){
            $response['status']=true;
            $response['data']=$user;
        }else{
            $response['status']=false;
            $response['msg']='User not found!';
            $response['msg_p']='Usuário não encontrado!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Add method
     *@params: firstname,lastname,username,email, password, facebook_token, twitter_token, instagram_token, google_token
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->find('all')->where(['email'=>$this->request->getData('email')])->first();
            if($this->request->getData('account_type')=='normal'){
                if($user){
                    $response['status']=false;
                    $response['msg']="Email already exists!";
                }else{
                    $user = $this->Users->newEntity();
                }
            }else{
                if(!$user){
                    $user = $this->Users->newEntity();
                }
            }
//            if(!$user){
//                $user = $this->Users->newEntity();
//            }
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role="User";
//            $user->status=true;
            if($user->status==false){
                $unique_number = mt_rand(10000, 99999);
                $user->otp =$unique_number;
            }
            //debug($user); exit;
            if ($result = $this->Users->save($user)) {
                $user_id = $result->id;
                if($user->status==false){
                    $email = new Email();
                    if($this->request->getData('current_language')=='portuguese'){
                        $email->setTemplate('otp_portuguese');
                        $email->setSubject('Código Otp');
                    }else{
                        $email->setTemplate('otp');
                        $email->setSubject('Otp Code');
                    }
                    $email->setEmailFormat('html');
                    $email->setFrom('no-reply@simerjit.gangtask.com');
                    $email->setTo($user->email, $user->firstname);
                    
                    $email->setViewVars(['otp' => $user->otp, 'username' => $user->firstname]);
                    if ($email->send()) {
                        $response['status']=true;
                        $response['data']=$user;
                        $response['data']['id']=$user_id;
                        $response['msg']='Check your email to verify your email address';
                        $response['msg_p']='Verifique seu e-mail para confirmar seu endereço de e-mail';
                    } else {
                        $response['status']=false;
                        $response['msg']='Error sending email:'. $email->smtpError;
                        $response['msg_p']='Erro ao enviar email:'. $email->smtpError;
                    }
                }else{
                    $response['status']=true;
                    $response['data']=$user;
                    $response['data']['id']=$user_id;
                    $response['msg']="Your account has been created successfully";
                    $response['msg_p']="Sua conta foi criada com sucesso";
                }
                
            }else{
                $response['status']=false;
                $response['msg']="The user could not be saved. Please, try again.";
                $response['msg_p']="O usuário não pôde ser salvo. Por favor, tente novamente.";
            }
        }else{
            $response['status']=false;
            $response['msg']="Post method required!";
            $response['msg_p']="Post método requerido!";
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    public function add_old()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role="User";
            $user->status=true;
            //debug($user); exit;
            if ($this->Users->save($user)) {
                $response['status']=true;
                $response['data']=$user;
                $response['msg']="Your account has been created successfully";
            }else{
                $response['status']=false;
                $response['msg']="The user could not be saved. Please, try again.";
            }
        }else{
            $response['status']=false;
            $response['msg']="Post method required!";
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $response['status']=true;
                $response['msg']='The user has been saved.';
                $response['msg_p']='O usuário foi salvo.';
                $response['data']=$this->Users->get($id, [
                    'contain' => []
                ]);
            }else{
                $response['status']=false;
                $response['msg']="The user could not be saved. Please, try again.";
                $response['msg_p']="O usuário não pôde ser salvo. Por favor, tente novamente.";
            }
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /*
     * Get List of API's
     */
    public function allapi(){
        $this->viewBuilder()->setLayout('ajax');
    }
    /*
     * Login
     * @params: username, password
     */
    public function login(){
        if ($this->request->is('post')) {
            $username=$this->request->getData('username');
            $user_password = $this->request->getData('password');
            $user = $this->Users->find('all')->where(['Users.username'=>$username])->first();
            if($user !=null){
                $user->toArray();
                if ((new DefaultPasswordHasher)->check($user_password, $user['password'])) {
                    $response['status']=true;
                    $response['data']=$user;
                } else {
                    $response['status']=false;
                    $response['msg']="Invalid User Credentials";
                    $response['msg_p']="Credenciais do usuário inválidas";
                }
            }else{
                $response['status']=false;
                $response['msg']="Invalid User Credentials";
                $response['msg_p']="Credenciais do usuário inválidas";
            }
        }else{
            $response['status']=false;
            $response['msg']="Post Method Required";
            $response['msg_p']="Método de postagem obrigatório";
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']); 
    }
    /*
     * @params: old_password,new_password,confirm_password, id
     */
    public function changePassword(){
        if ($this->request->is('post')) {
            $userdata = $this->request->getData();
            $user = $this->Users->get($this->request->getData('id'));
            if(!empty($user)){
                if(!empty($this->request->getData())){
                    $user = $this->Users->patchEntity($user, [
                            'id'                =>$userdata['id'],
                            'old_password'      => $userdata['old_password'],
                            'password'          => $userdata['new_password'],
                            'new_password'      => $userdata['new_password'],
                            'confirm_password'  => $userdata['confirm_password']
                        ],
                        ['validate' => 'password']
                    );
                  //  debug($user); exit;
                   if($this->Users->save($user)){
                        $response['status']=true;
                        $response['msg']='Your password has been changed successfully';
                        $response['msg_p']='Sua senha foi alterada com sucesso';
                    }else{   
                        if($user->getErrors()){
                            $error_msg = [];
                            foreach( $user->getErrors() as $errors){
                                if(is_array($errors)){
                                    foreach($errors as $error){
                                        $error_msg[]    =   $error;
                                    }
                                }else{
                                    $error_msg[]    =   $errors;
                                }
                            }  
                            if(!empty($error_msg)){
                                $response['msg']=$error_msg[0];
                                $response['msg_p']=$error_msg[0];
                            }else{
                                $response['msg']='Error changing password. Please try again!';
                                $response['msg_p']='Erro ao alterar a senha. Por favor, tente novamente!';
                            }
                        }else{
                            $response['msg']='Error changing password. Please try again!';
                            $response['msg_p']='Erro ao alterar a senha. Por favor, tente novamente!';
                        }
                        $response['status']=false;
                    }
                }else{
                    $response['status']=false;
                    $response['msg']='No data posted!';
                    $response['msg_p']='Nenhum dado publicado!';
                }
            }else{
                $response['status']=false;
                $response['msg']='No User exists with this id!';
                $response['msg_p']='Nenhum usuário existe com este id!';
            }
        }else{
            $response['status']=false;
            $response['msg']="Post Method Required";
            $response['msg_p']="Método de postagem obrigatório";
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
    public function forgotPassword(){
         if ($this->request->is('post')) {
            $query = $this->Users->findByEmail($this->request->getData('email'));
            $user = $query->first();
            if (is_null($user)) {
                $response['status']=false;
                $response['msg']='Email address does not exist. Please try again';
                $response['msg_p']='Endereço de email não existe. Por favor, tente novamente';
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset','prefix'=>false], true) . '/' . $passkey;
                $timeout = time() + DAY;
                if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $current_language = $this->request->getData('current_language');
                    $mail_response = $this->sendResetEmail($url, $user,$current_language);
                    $response=$mail_response;
                } else {
                    $response['status']=false;
                    $response['msg']='Error saving reset passkey/timeout';
                    $response['msg_p']='Erro ao salvar senha / tempo de reset redefinido';
                }
            }
        }else{
            $response['status']=false;
            $response['msg']='Post method required!';
            $response['msg_p']='Método de postagem obrigatório!';
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
    private function sendResetEmail($url, $user,$current_language) {
        $email = new Email();
        if($current_language=='portuguese'){
            $email->setTemplate('resetpw_portuguese');
            $email->setSubject('Redefinir sua senha');
        }else{
            $email->setTemplate('resetpw');
            $email->setSubject('Reset your password');
        }
        $email->setEmailFormat('both');
        $email->setFrom('no-reply@simerjit.gangtask.com');
        $email->setTo($user->email, $user->firstname);
        $email->setViewVars(['url' => $url, 'username' => $user->firstname]);
        if ($email->send()) {
            $response['status']=true;
            $response['msg']='Check your email for your reset password link';
            $response['msg']='Verifique o seu email para o seu link de redefinição de senha';
        } else {
            $response['status']=false;
            $response['msg']='Error sending email:'. $email->smtpError;
            $response['msg_p']='Erro ao enviar email:'. $email->smtpError;
        }
        return $response;
    }
    /*
     * Upload Profile Image
     */
    public function uploadImage($id=null){
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $posted_data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->request->getData('image')==''){
                $user->image='';
            }else{
                $supported_file_types = array('image/png','image/jpeg');
                $uploadPath = 'files/userUploads/';
                $filedata = $this->request->getData('image');
                if($filedata==''){
                     $user->image=$user['image'];
                }else{
                    $filedata_response = $this->Upload->base64_to_jpeg($filedata, $uploadPath);
                    if($filedata_response['status']==true){
                        $user->image=$filedata_response['image'];
                    }else if($filedata_response['status']==false){
                        die($filedata_response['msg']);
                    }else{
                         $user->image='';
                    }
                }
            }
            
            if ($this->Users->save($user)) {
                $response['status']=true;
                $response['msg']='User has been updated.';
                $response['msg_p']='Usuário foi atualizado.';
                $response['data']=$this->Users->get($id);
            }else{
                $response['status']=false;
                $response['msg']='The user could not be saved. Please, try again.';
                $response['msg_p']='O usuário não pôde ser salvo. Por favor, tente novamente.';
            }
        }
        
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
    /*
     * restaurantid_$tableid
     */
    public function barcodes(){
        $this->loadModel('Tables');
        $files=$this->Tables->find('all')->contain(['Restaurants'])->toArray();
        $this->viewBuilder()->setLayout('ajax');
//        $dir = new Folder(WWW_ROOT.'barcodes');
//        $files = $dir->find('.*\.jpg');
        $this->set('barcodes',$files);
    }
    /*
     * Search for user using email/username
     */
    public function userExist(){
        $email = $this->request->getData('email');
        if($this->request->getData('social')){
            $social = $this->request->getData('social')."_token";
            $token = $this->request->getData('token');
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //$user = $this->Users->find('all')->where(['email'=>$email,"$social"=>$token])->first();
            $user = $this->Users->find('all')->where(['email'=>$email])->first();
            if(count($user)>0){
                $response['status']=true;
                $response['data']=$user;
            }else{
                $response['status']=false;
                $response['msg']='No user exists with this email';
                $response['msg_p']='Nenhum usuário existe com este email';
            }
        } else {
            //$user = $this->Users->find('all')->where(['username'=>$email,"$social"=>$token])->first();
            $user = $this->Users->find('all')->where(['username'=>$email])->first();
            if(count($user)>0){
                $response['status']=true;
                $response['data']=$user;
            }else{
                $response['status']=false;
                $response['msg']='No user exists with this username';
                $response['msg_p']='Nenhum usuário existe com este nome de usuário';
            }
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
    /*
     * Verify OTP
     * @params user_id, otp
     */
    public function verifyOtp(){
        if ($this->request->is('post')) {
           // debug($this->request->getData()); exit;
            $user = $this->Users->find('all')->where(['id'=>$this->request->getData('user_id'),'otp'=>$this->request->getData('otp')])->first();
            if(count($user)>0){
                if($user->status==true){
                    $response['status']=true;
                    $response['msg']='Your email is already verified!';
                    $response['msg_p']='Seu email já está confirmado!';
                }else{
                    $user = $this->Users->get($user->id); // Return article with id = $id (primary_key of row which need to get updated)
                    $user->status = true;
                    if($this->Users->save($user)){
                        $response['status']=true;
                        $response['msg']='Email verified successfully!';
                        $response['msg_p']='Email verificado com sucesso!';
                        $response['data']=$this->Users->get($user->id);
                    } else {
                        $response['status']=true;
                        $response['msg']='Unable to update!Please try again later';
                        $response['msg_p']='Não é possível atualizar! Por favor, tente novamente mais tarde';
                    }
                }
            }else{
                $response['status']=false;
                $response['msg']='Invalid Otp!';
                $response['msg_p']='Otp inválido!';
            }
        }else{
            $response['status']=false;
            $response['msg']='POST method required!';
            $response['msg_p']='Método POST requerido!';
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
    
    
}
