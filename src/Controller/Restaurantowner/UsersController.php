<?php
namespace App\Controller\RestaurantOwner;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event){
        $this->Auth->allow(['forgotPassword','reset','login']);
    }
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Upload');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
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

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
            if($this->request->getData('status')){
               $user->status = $this->request->getData('status');
            }else{
                $user->status = false;
            }
            // upload image
            $posted_data=$this->request->getData();
            $supported_file_types = array('image/png','image/jpeg');
            $uploadPath = 'files/userUploads/';
            $filedata = $this->request->getData('image');
            if($filedata['error']==4){
                 $user->image=$posted_data['old_image'];
            }else{
                $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
                if($filedata_response['status']==true){
                    $user->image=$filedata_response['image'];
                }else if($filedata_response['status']==false){
                    die($filedata_response['msg']);
                }else{
                     $user->image='';
                }
            }
            if ($this->Users->save($user)) {
                if($this->Auth->user('id')==$id){
                    $this->Auth->setUser($user);
                }
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /*
     * If role is not RestaurantOwner, navigate to unauthorized screen
     */
    public function unauthorized() {
        $this->viewBuilder()->setLayout('login');
    }
    /*
     * check Authorization
     */
    
    public function isAuthorized($user)
{
    // Admin can access every action
    if (isset($user['role']) && $user['role'] === 'RestaurantOwner') {
        return true;
    }

    // Default deny
    return false;
}
    
    
    /*
     * Login
     */
    public function login(){
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect((['action'=>'dashboard']));
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }
    /*
     * Logout User
     */
    public function logout(){
        return $this->redirect($this->Auth->logout());
    }
    /*
     * Change Password
     * @params: old_password, new_password, confirm_password
     */
    public function changePassword(){
        $user = $this->Users->get($this->Auth->user('id'));
        if(!empty($this->request->getData()))
        {
            $user = $this->Users->patchEntity($user, [
                    'old_password'      => $this->request->getData('old_password'),
                    'password'          => $this->request->getData('new_password'),
                    'new_password'      => $this->request->getData('new_password'),
                    'confirm_password'  => $this->request->getData('confirm_password')
                ],
                    ['validate' => 'password']
            );
            
            if($this->Users->save($user))
            {
                $this->Flash->success('Your password has been changed successfully');
                $this->redirect(['action'=>'changepassword']);
            }
            else
            {
                $this->Flash->error('Error changing password. Please try again!');
            }
            
        }
        $this->set('user',$user);
    }
    /*
     * Forgot Password
     * @params: email
     */
    public function forgotPassword(){
        $this->viewBuilder()->setLayout('login');
         if ($this->request->is('post')) {
            $query = $this->Users->findByEmail($this->request->getData('email'));
            $user = $query->first();
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset','prefix'=>false], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $this->sendResetEmail($url, $user);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }
    /*
     * Private function to send email
     */
    private function sendResetEmail($url, $user) {
        $email = new Email();
        $email->setTemplate('resetpw');
        $email->setEmailFormat('both');
        $email->setFrom('no-reply@simerjit.gangtask.com');
        $email->setTo($user->email, $user->firstname);
        $email->setSubject('Reset your password');
        $email->setViewVars(['url' => $url, 'username' => $user->firstname]);
        if ($email->send()) {
            $this->Flash->success(__('Check your email for your reset password link'));
        } else {
            $this->Flash->error(__('Error sending email: ') . $email->smtpError);
        }
    }
    /*
     * Reset Password using link
     */
    public function reset($passkey = null) {
        $this->viewBuilder()->setLayout('login');
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            if ($user) {
                if (!empty($this->request->getData())) {
                    // Clear passkey and timeout
                    $user->passkey = null;
                    $user->timeout = null;
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    if ($this->Users->save($user)) {
                        $this->Flash->set(__('Your password has been updated.'));
                        return $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Flash->error(__('The password could not be updated. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error('Invalid or expired passkey. Please check your email or try again');
                $this->redirect(['action' => 'password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }
    /**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
public function getDatesFromRange($sStartDate, $sEndDate) {
        // Firstly, format the provided dates.  
        // This function works best with YYYY-MM-DD  
        // but other date formats will work thanks  
        // to strtotime().  
        $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
        $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

        // Start the variable off with the start date  
        $aDays[] = $sStartDate;

        // Set a 'temp' variable, sCurrentDate, with  
        // the start date - before beginning the loop  
        $sCurrentDate = $sStartDate;

        // While the current date is less than the end date  
        while ($sCurrentDate < $sEndDate) {
            // Add a day to the current date  
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

            // Add this new day to the aDays array  
            $aDays[] = $sCurrentDate;
        }

        // Once the loop has finished, return the  
        // array of days.  
        return $aDays;
    }

    /*
     * Dashboard
     */

    public function dashboard() {
        $this->Restaurants = TableRegistry::get('Restaurants');
        $this->Orders = TableRegistry::get('Orders');
        $this->Waiters = TableRegistry::get('Waiters');
        $this->Tables = TableRegistry::get('Tables');
        $this->Menus = TableRegistry::get('Menus');
        $data['months'] = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $data['order_lg'] = [];
        $data['revenue_lg'] = [];
        $data['weekdata'] = [];
        $data['year'] = date("Y");

        $monday = strtotime("last monday");
        $monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;

        $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");

// $this_week_sd = date("Y-m-d",strtotime('2018-09-11'));
// $this_week_ed = date("Y-m-d",strtotime('2018-09-18'));
        $this_week_sd = date("Y-m-d", $monday);
        $this_week_ed = date("Y-m-d", $sunday);

        $period = $this->getDatesFromRange($this_week_sd, $this_week_ed);
        $restaurants = $this->Restaurants->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
        $ids = array_keys($restaurants);
        $data['restaurants'] = $restaurants;
        $weeklyorders = $this->Orders->find();
        $weeklyorders->select(['count' => $weeklyorders->func()->count('Orders.id'),
                    'day' => 'DAY(created)'])
                ->where([
                    'Orders.created BETWEEN :start AND :end'
                ])
                ->bind(':start', $this_week_sd, 'date')
                ->bind(':end', $this_week_ed, 'date')
                ->where(['Orders.restaurant_id IN' => $ids])
                ->group(['EXTRACT(DAY FROM Orders.created)']);
        $weeklyorders = $weeklyorders->toArray();

        $totalweekorders = $this->Orders->find();
        $totalweekorders->select(['sum' => $totalweekorders->func()->count('Orders.id')])
                ->where([
                    'Orders.created BETWEEN :start AND :end'
                ])
                ->bind(':start', $this_week_sd, 'date')
                ->bind(':end', $this_week_ed, 'date')
                ->where(['Orders.restaurant_id IN' => $ids]);
        $totalweekorders = $totalweekorders->toArray();
        $total = $totalweekorders[0]->sum;

        foreach ($period as $dateindex => $date_val) {
            $day = date("d", strtotime($date_val));
            $weeklyorderskey = array_search($day, array_column($weeklyorders, 'day'));
            if (is_numeric($weeklyorderskey)) {
                $data['weekdata'][$dateindex]['day'] = $date_val;
                $data['weekdata'][$dateindex]['orders'] = $weeklyorders[$weeklyorderskey]['count'];
                $data['weekdata'][$dateindex]['percentage'] = number_format((float) ($weeklyorders[$weeklyorderskey]['count'] * 100) / $total, 2, '.', '');
            } else {
                $data['weekdata'][$dateindex]['day'] = $date_val;
                $data['weekdata'][$dateindex]['orders'] = 0;
                $data['weekdata'][$dateindex]['percentage'] = 0;
            }
        }


        if ($this->request->is(['patch', 'post', 'put'])) {
            $res_id = [];
            $data['weekdata'] = [];
            if ($this->request->getData('restaurant_id')) {
                array_push($res_id, $this->request->getData('restaurant_id'));
                $weeklyorders = $this->Orders->find();
                $weeklyorders->select(['count' => $weeklyorders->func()->count('Orders.id'),
                            'day' => 'DAY(created)'])
                        ->where([
                            'Orders.created BETWEEN :start AND :end'
                        ])
                        ->bind(':start', $this_week_sd, 'date')
                        ->bind(':end', $this_week_ed, 'date')
                        ->where(['Orders.restaurant_id IN' => $res_id])
                        ->group(['EXTRACT(DAY FROM Orders.created)']);
                $weeklyorders = $weeklyorders->toArray();

                $totalweekorders = $this->Orders->find();
                $totalweekorders->select(['sum' => $totalweekorders->func()->count('Orders.id')])
                        ->where([
                            'Orders.created BETWEEN :start AND :end'
                        ])
                        ->bind(':start', $this_week_sd, 'date')
                        ->bind(':end', $this_week_ed, 'date')
                        ->where(['Orders.restaurant_id IN' => $ids]);
                $totalweekorders = $totalweekorders->toArray();
                $total = $totalweekorders[0]->sum;

                foreach ($period as $dateindex => $date_val) {
                    $day = date("d", strtotime($date_val));
                    $weeklyorderskey = array_search($day, array_column($weeklyorders, 'day'));
                    if (is_numeric($weeklyorderskey)) {
                        $data['weekdata'][$dateindex]['day'] = $date_val;
                        $data['weekdata'][$dateindex]['orders'] = $weeklyorders[$weeklyorderskey]['count'];
                        $data['weekdata'][$dateindex]['percentage'] = number_format((float) ($weeklyorders[$weeklyorderskey]['count'] * 100) / $total, 2, '.', '');
                    } else {
                        $data['weekdata'][$dateindex]['day'] = $date_val;
                        $data['weekdata'][$dateindex]['orders'] = 0;
                        $data['weekdata'][$dateindex]['percentage'] = 0;
                    }
                }
            }
        }
        
        $tables = $this->Tables->find();
        $tables->select(['count' => $tables->func()->count('Tables.id')])
                ->where(['Tables.restaurant_id IN' => $ids]);
        $data['tables'] = $tables->toArray();

        $menus = $this->Menus->find();
        $menus->select(['count' => $menus->func()->count('Menus.id')])
                ->where(['Menus.restaurant_id IN' => $ids]);
        $data['menu'] = $menus->toArray();
        
        $waiters = $this->Waiters->find();
        $waiters->select(['count' => $waiters->func()->count('Waiters.id')])
                ->where(['Waiters.restaurant_id IN' => $ids]);
        $data['waiters'] = $waiters->toArray();
        
        

        $order = $this->Orders->find();
        $order->select(['count' => $order->func()->count('Orders.id'),
                    'revenue' => $order->func()->sum('Orders.totalamount'),
                    'month' => 'MONTH(created)',
                    'year' => 'YEAR(created)'])
                ->where(['Orders.restaurant_id IN' => $ids])
                ->group(['EXTRACT(YEAR_MONTH FROM Orders.created)']);
        $order = $order->toArray();
        foreach ($data['months'] as $index => $month) {
            $key = array_search($index + 1, array_column($order, 'month'));
            if (is_numeric($key) && $index + 1 == $order[$key]->month && $data['year'] == $order[$key]->year) {
                array_push($data['order_lg'], $order[$key]->count);
                array_push($data['revenue_lg'], number_format((float) $order[$key]->revenue, 2, '.', ''));
            } else {
                array_push($data['order_lg'], 0);
                array_push($data['revenue_lg'], number_format((float) 0, 2, '.', ''));
            }
        }
//        echo "<pre>"; print_r($data); echo "</pre>";
//        exit;
        $this->set(compact('data'));
    }
    public function settings() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $session = $this->getRequest()->getSession();
            if($this->request->getData('sel_lang')=='english'){
                $session->write('language', 'english');
            }else if($this->request->getData('sel_lang')=='portuguese'){
                $session->write('language', 'portuguese');
            }else{
                $session->write('language', 'english');
            }
            $lang = $session->read('language');
            $this->set('lang',$lang);
        }
//        $lang = $session->read('language');
//        $this->set('lang',$lang);
    }
}
