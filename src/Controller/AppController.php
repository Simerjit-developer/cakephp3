<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /*
     * Allow all controllers if there is 'API' prefix
     */
    public function beforeFilter(Event $event){
        
        
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Restaurants = TableRegistry::get('Restaurants');
        $this->HelpRequests = TableRegistry::get('HelpRequests');
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
        'loginAction' => [
            'controller' => 'Users',
            'action' => 'login',
          //  'plugin' => 'Users'
        ],
        'authError' => 'Did you really think you are allowed to see that?',
        'storage' => 'Session'
        ]);
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        /*
         * Manage Routing for Different User Roles
         */
        if ($this->request->getParam('prefix') === 'api') {
            $this->Auth->allow();
        }else if ($this->request->getParam('prefix') === 'restaurantowner') {
            if($this->Auth->user() && $this->Auth->user('role')!='RestaurantOwner'){
                return $this->redirect(['controller'=>'users','action' => 'unauthorized','prefix'=>false]);
            }
        }else if ($this->request->getParam('prefix') != 'restaurantowner') {
            //echo 'no prefix';
            if($this->Auth->user() && $this->Auth->user('role')=='RestaurantOwner'){
                return $this->redirect(['controller'=>'restaurants','action' => 'index','prefix'=>'restaurantowner']);
            }
        }
        if($this->Auth->user() && $this->Auth->user('role')=='User'){
            return $this->redirect(['controller'=>'users','action' => 'unauthorized','prefix'=>false]);
        }
        // user Notifications
        if($this->Auth->user() && $this->Auth->user('role')=='RestaurantOwner'){
           $restaurants = $this->Restaurants->find('list')->where(['user_id' => $this->Auth->user('id')])->toArray();
           $ids = array_keys($restaurants);
           $notifications=$this->HelpRequests->find('all')
                   ->contain(['Restaurants', 'Users', 'Orders', 'Waiters', 'Tables'])
                   ->where(['HelpRequests.restaurant_id IN' => $ids, 'HelpRequests.visited'=>0]);
           $notifications=$notifications->toArray();
           $not_data['notifications']=$notifications;
           $this->set('notifications',$not_data);
        }
        
        // set global variable $authUser if user is logged in
        if($this->Auth->user()){
            $this->set('authUser',$this->Auth->user());
        }
        
        //Check for language section
        $session = $this->getRequest()->getSession();
        if($session->check('language')){
            if(isset($_GET['lang']) && $_GET['lang']=='english'){
                $session->write('language', 'english');
            }else if(isset($_GET['lang']) && $_GET['lang']=='portuguese'){
                $session->write('language', 'portuguese');
            }else{
                
            }
            $lang = $session->read('language');
        }else{
            if(isset($_GET['lang']) && $_GET['lang']=='english'){
                $session->write('language', 'english');
            }else if(isset($_GET['lang']) && $_GET['lang']=='portuguese'){
                $session->write('language', 'portuguese');
            }else{
                $session->write('language', 'english');
            }
            $lang = $session->read('language');
        }
        $this->set('lang',$lang);
    }
    
    
}
