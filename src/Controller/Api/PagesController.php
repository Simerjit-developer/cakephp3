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
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /*
     * Get Page By slug
     */
    public function page($slug=null){
        $page = $this->Pages->find('all')->where(['slug'=>$slug])->limit(1)->toArray();
        if($page){
            $response['status']=true;
            $response['data']=$page;
        }else{
            $response['status']=false;
            $response['msg']='Invalid Slug!';
            $response['msg_p']='Slug inválido!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
