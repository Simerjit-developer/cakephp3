<?php
namespace App\Controller;

use App\Controller\AppController;

// To generate and read files
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Restaurants Controller
 *
 * @property \App\Model\Table\RestaurantsTable $Restaurants
 *
 * @method \App\Model\Entity\Restaurant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RestaurantsController extends AppController
{
    
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


        $restaurants = $this->Restaurants->find('all',['contain' => ['Users', 'Cuisines']]);

         $restaurants =  $restaurants->all();
       
        //$restaurants = $this->paginate($this->Restaurants);

        $this->set(compact('restaurants'));
    }

    /**
     * View method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Amenities');
        $restaurant = $this->Restaurants->get($id, [
            'contain' => ['Users', 'Cuisines', 'Menus','RestaurantAmenities']
        ]);

        $my_amenities = [];
        if(count($restaurant->restaurant_amenities)>0){
            foreach ($restaurant->restaurant_amenities as $value) {
                array_push($my_amenities, $value['amenity_id']);
            }
        }
        $amenities = $this->Amenities->find('list', ['limit' => 200]);
        $this->set('restaurant', $restaurant);
        $this->set('amenities', $amenities);
        $this->set('my_amenities', $my_amenities);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $restaurant = $this->Restaurants->newEntity();
        if ($this->request->is('post')) {
            $restaurant = $this->Restaurants->patchEntity($restaurant, $this->request->getData());
            $uploadPath = 'files/restaurants/';
            $supported_file_types = array('image/png','image/jpeg');
            $filedata = $this->request->getData('image');
            $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
            if($filedata_response['status']!=false){
                $restaurant->image=$filedata_response['image'];
            }else{
                $restaurant->image='';
            }
            $restaurant->total_tables = $this->request->getData('total_tables');
            $savenew = $this->Restaurants->save($restaurant);
            if ($savenew) {

                 /************amenities*************/
                  // Delete amenity if not exists in the new array
            $new_items = $this->request->getData('amenities');
            if(!empty($new_items)){
            $this->loadModel('RestaurantAmenities');
            $old_items_list = $this->RestaurantAmenities
                            ->find('list', [
                                'keyField' => 'id',
                                'valueField' => 'amenity_id'
                            ])
                            ->where(['restaurant_id =' => $savenew['id']])
                            ->toArray();
            //debug($old_items_list); exit;
            if(count($old_items_list)>0){
                $old_items=array_values($old_items_list);
                $items_to_delete=[];
                foreach($old_items as $key => $item){
                   if(!in_array($item, $new_items)){
                       array_push($items_to_delete, $item);
                   }
                }
                if(count($items_to_delete)>0){
                    $this->RestaurantAmenities->deleteAll(['RestaurantAmenities.restaurant_id'=>$savenew['id'],'RestaurantAmenities.amenity_id IN' => $items_to_delete]);
                }
                
            }
            $amenities = [];
            foreach ($this->request->getData('amenities') as $value){
                $newval=[];
                $newval['amenity_id']=$value;
                $newval['restaurant_id']=$savenew['id'];
                
                $exist = $this->RestaurantAmenities->find('all')->where($newval)->first();
                // Exist 
                if(count($exist) && $exist->amenity_id){
                    $exist = $this->RestaurantAmenities->patchEntity($exist, $this->request->getData());
                    $this->RestaurantAmenities->save($exist);
                }else{
                    array_push($amenities,$newval);
                }
            }
            $entities = $this->RestaurantAmenities->newEntities($amenities);
            if($this->RestaurantAmenities->saveMany($entities)){
               // save 
            }else{  
              // not save
            }    

            } 



                $this->Flash->success(__('The restaurant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The restaurant could not be saved. Please, try again.'));
        }
        $users = $this->Restaurants->Users->find('list', ['limit' => 200]);
        $cuisines = $this->Restaurants->Cuisines->find('list', ['limit' => 200]);
        $this->loadModel('Amenities');
        $amenities = $this->Amenities->find('list', ['limit' => 200]);
        $this->set(compact('restaurant', 'users', 'cuisines','amenities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $restaurant = $this->Restaurants->get($id, [
            'contain' => ['RestaurantAmenities']
        ]);
        $my_amenities = [];
        if(count($restaurant->restaurant_amenities)>0){
            foreach ($restaurant->restaurant_amenities as $value) {
                array_push($my_amenities, $value['amenity_id']);
            }
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $posted_data =$this->request->getData();

            $restaurant = $this->Restaurants->patchEntity($restaurant, $this->request->getData());
            
            if($this->request->getData('status') ==0){
                $restaurant->status = 0;
            }else{
                $restaurant->status = 1;
            }
       
    
            $supported_file_types = array('image/png','image/jpeg');
            $uploadPath = 'files/restaurants/';
            $filedata = $this->request->getData('image');
            if($filedata['error']==4){
                 $restaurant->image=$posted_data['old_image'];
            }else{
                $filedata_response = $this->Upload->uploadFile($filedata, $uploadPath,$supported_file_types);
                if($filedata_response['status']==true){
                    $restaurant->image=$filedata_response['image'];
                }else if($filedata_response['status']==false){
                    die($filedata_response['msg']);
                }else{
                     $restaurant->image='';
                }
            }
            $restaurant->total_tables = $this->request->getData('total_tables');
     
       
            if ($this->Restaurants->save($restaurant)) {
                $this->loadModel('Tables');
                $tables = $this->Tables->find('all')->where(['restaurant_id'=>$id])->toArray();
                if(count($tables)>$restaurant->total_tables){
                    // Remove extra tables and their bar code images
                    foreach($tables as $table){
                        if($table->table_number > $restaurant->total_tables){
                            // Unlink Image
                            if(unlink(WWW_ROOT.$table->barcode_image)){
                                $entity = $this->Tables->get($table->id);
                                $result = $this->Tables->delete($entity);
                            }
                        }
                    }
                }


                /************amenities*************/
                  // Delete amenity if not exists in the new array
            $new_items = $this->request->getData('amenities');
            if(!empty($new_items)){
            $this->loadModel('RestaurantAmenities');
            $old_items_list = $this->RestaurantAmenities
                            ->find('list', [
                                'keyField' => 'id',
                                'valueField' => 'amenity_id'
                            ])
                            ->where(['restaurant_id =' => $restaurant['id']])
                            ->toArray();
            //debug($old_items_list); exit;
            if(count($old_items_list)>0){
                $old_items=array_values($old_items_list);
                $items_to_delete=[];
                foreach($old_items as $key => $item){
                   if(!in_array($item, $new_items)){
                       array_push($items_to_delete, $item);
                   }
                }
                if(count($items_to_delete)>0){
                    $this->RestaurantAmenities->deleteAll(['RestaurantAmenities.restaurant_id'=>$restaurant['id'],'RestaurantAmenities.amenity_id IN' => $items_to_delete]);
                }
                
            }
            $amenities = [];
            foreach ($this->request->getData('amenities') as $value){
                $newval=[];
                $newval['amenity_id']=$value;
                $newval['restaurant_id']=$restaurant['id'];
                
                $exist = $this->RestaurantAmenities->find('all')->where($newval)->first();
                // Exist 
                if(count($exist) && $exist->amenity_id){
                    $exist = $this->RestaurantAmenities->patchEntity($exist, $this->request->getData());
                    $this->RestaurantAmenities->save($exist);
                }else{
                    array_push($amenities,$newval);
                }
            }
            $entities = $this->RestaurantAmenities->newEntities($amenities);
            if($this->RestaurantAmenities->saveMany($entities)){
               // save 
            }else{
              // not save
            }    

            } 



                $this->Flash->success(__('The restaurant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The restaurant could not be saved. Please, try again.'));
        }
        $users = $this->Restaurants->Users->find('list', ['limit' => 200]);
        $cuisines = $this->Restaurants->Cuisines->find('list', ['limit' => 200]);
        $this->loadModel('Amenities'); 
        $amenities = $this->Amenities->find('list', ['limit' => 200]);
        $this->set(compact('restaurant', 'users', 'cuisines','amenities','my_amenities'));
    }
    /*
     * Add Amenities
     */
    public function addAmenities($restaurant_id = null){
        $restaurant = $this->Restaurants->get($restaurant_id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Delete amenity if not exists in the new array
            $new_items = $this->request->getData('amenities');
            $this->loadModel('RestaurantAmenities');
            $old_items_list = $this->RestaurantAmenities
                            ->find('list', [
                                'keyField' => 'id',
                                'valueField' => 'amenity_id'
                            ])
                            ->where(['restaurant_id =' => $restaurant_id])
                            ->toArray();
            //debug($old_items_list); exit;
            if(count($old_items_list)>0){
                $old_items=array_values($old_items_list);
                $items_to_delete=[];
                foreach($old_items as $key => $item){
                   if(!in_array($item, $new_items)){
                       array_push($items_to_delete, $item);
                   }
                }
                if(count($items_to_delete)>0){
                    $this->RestaurantAmenities->deleteAll(['RestaurantAmenities.restaurant_id'=>$restaurant_id,'RestaurantAmenities.amenity_id IN' => $items_to_delete]);
                }
                
            }
            $amenities = [];
            foreach ($this->request->getData('amenities') as $value){
                $newval=[];
                $newval['amenity_id']=$value;
                $newval['restaurant_id']=$restaurant_id;
                
                $exist = $this->RestaurantAmenities->find('all')->where($newval)->first();
                // Exist 
                if(count($exist) && $exist->amenity_id){
                    $exist = $this->RestaurantAmenities->patchEntity($exist, $this->request->getData());
                    $this->RestaurantAmenities->save($exist);
                }else{
                    array_push($amenities,$newval);
                }
            }
            $entities = $this->RestaurantAmenities->newEntities($amenities);
            if($this->RestaurantAmenities->saveMany($entities)){
                $this->Flash->success(__('The amenities has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('The amenities could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Restaurant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $restaurant = $this->Restaurants->get($id);
        if ($this->Restaurants->delete($restaurant)) {
            $this->Flash->success(__('The restaurant has been deleted.'));
        } else {
            $this->Flash->error(__('The restaurant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function generate($restaurant_id=null){
        $restaurant = $this->Restaurants->get($restaurant_id, [
            'contain' => []
        ]);
        if($restaurant){
            $total_tables = $restaurant['total_tables'];
            $unique_number = mt_rand(10000, 99999);
        }
    }
    
    public function testdata(){
        $distanceField = '(3959 * acos (cos ( radians(:latitude) )
    * cos( radians( Restaurants.latitude ) )
    * cos( radians( Restaurants.longitude )
    - radians(:longitude) )
    + sin ( radians(:latitude) )
    * sin( radians( Restaurants.latitude ) )))';
      //   $distanceField = 'get_distance_in_miles_between_geo_locations("30.733315", "76.779419", "Restaurants.latitude", "Restaurants.longitude")';
        
       
        $sightings = $this->Restaurants->find()
    ->select(['Restaurants.id','Restaurants.name','Restaurants.image','Restaurants.avg_rating','Cuisines.name',
        'distance' => $distanceField
    ]) ->having(["distance < " => 10])
    ->bind(':latitude', 30.733315, 'float')
    ->bind(':longitude', 76.779419, 'float')->contain(['Cuisines','Users'=>function($q){
            return $q->where(['Users.status'=>true]);
        }])->where(['Restaurants.status' => 1])->toArray();
        debug($sightings); exit;
        echo "nitin";
     echo "<pre>";   print_r($sightings); echo "</pre>";
        exit;
    }
}
