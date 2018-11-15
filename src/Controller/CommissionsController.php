<?php
namespace App\Controller;

use App\Controller\AppController;

// To generate and read files
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use App\Database\Expression\BetweenComparison;
use Cake\Database\Expression\IdentifierExpression;

class CommissionsController extends AppController
{
    
    public function initialize(){
        parent::initialize();
        $this->loadComponent('Upload');
    }
    
    
       public function commissionbyres()
    {

echo "commissionbyres";
exit;
      
    }
    
      public function commissionbydate()
    {

echo "commissionbydate";
exit;
      
    }
    
    
    public function admincommission() {
        $this->Restaurants = TableRegistry::get('Restaurants');
        $this->Orders = TableRegistry::get('Orders');
        $data['Restaurants'] = $this->Restaurants->find('all')->all();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rest_id = $this->request->getData('restaurant_id');
            $startdate = $this->request->getData('startdate');
            $enddate = $this->request->getData('enddate');
            $mysqlstartdate = date('Y-m-d 00:00:00', strtotime($startdate));
            $mysqlenddate = date('Y-m-d 23:59:59', strtotime($enddate));
            $condition = [];
            $restaurent_detail="";
            if ($rest_id != "") {
                $condition['Orders.restaurant_id'] = $rest_id;
                $restaurent_detail=$restaurant = $this->Restaurants->get($rest_id, [
            'contain' => []
        ]);
            }


            $results = $this->Orders->find();
               $results->select(['sum' => $results->func()->sum('Orders.commission')])  
                    ->where([
                        'created BETWEEN :start AND :end'
                    ])
                    ->bind(':start', $mysqlstartdate, 'date')
                    ->bind(':end', $mysqlenddate, 'date')
                    ->where($condition);
               $output=[];
               $output['restaurant']=$restaurent_detail;
               $output['start']=$mysqlstartdate;
               $output['end']=$mysqlenddate;
               $output['result']=$results->toArray();
               $this->set(compact('output'));

        }



        $this->set(compact('data'));
//       echo "<pre>"; print_r($data); echo "</pre>";
//       exit;
    }

}

?>