<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Resturants Controller
 *
 *
 * @method \App\Model\Entity\Resturant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RestaurantsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index_old()
    {
        $resturants = $this->Restaurants->find('all')->contain(['Cuisines','Users'=>function($q){
            return $q->where(['Users.status'=>true]);
        }])->where(['Restaurants.status' => 1]);
        $resturants=$this->paginate($resturants);
        if($resturants){
            $response['status']=true;
            $response['data']=$resturants;
        }else{
            $response['status']=false;
            $response['msg']='No Data Found!';
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /*
     * Default distance is 16km i.e. 10 miles
     */
    public function index()
    {
        if($this->request->is('post')){
            $latitiude = $this->request->getData('latitude');
            $longitude = $this->request->getData('longitude');

             $distanceField = '(3959 * acos (cos ( radians(:latitude) )
        * cos( radians( Restaurants.latitude ) )
        * cos( radians( Restaurants.longitude )
        - radians(:longitude) )
        + sin ( radians(:latitude) )
        * sin( radians( Restaurants.latitude ) )))'; // in miles
             $restaurants = $this->Restaurants->find()
        ->select(['Restaurants.id','Restaurants.name','Restaurants.name_p','Restaurants.latitude','Restaurants.longitude','Restaurants.image','Restaurants.avg_rating','Restaurants.starting_price','Cuisines.name','Cuisines.name_p',
            'distance' => $distanceField
        ])
                     //->having(["distance < " => 10])
        ->bind(':latitude', $latitiude, 'float')
        ->bind(':longitude', $longitude, 'float')->contain(['Cuisines','Users'=>function($q){
                return $q->where(['Users.status'=>true]);
            }])->where(['Restaurants.status' => 1])->toArray();
    //        $resturants = $this->Restaurants->find('all')->contain(['Cuisines','Users'=>function($q){
    //            return $q->where(['Users.status'=>true]);
    //        }])->where(['Restaurants.status' => 1]);
            //$resturants=$this->paginate($restaurants);
            if($restaurants){
                $response['status']=true;
                $response['data']=$restaurants;
            }else{
                $response['status']=false;
                $response['msg']='No Data Found!';
                $response['msg_p']='Nenhum dado encontrado!';
            }
        }else{
            $response['status']=false;
            $response['msg']='Unable to fetch your location!';
            $response['msg_p']='Não é possível buscar sua localização!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    /**
     * View method
     *
     * @param string|null $id Resturant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $restaurant = $this->Restaurants->get($id, [
            'contain' => ['Cuisines','Ratings'=>'Users','RestaurantAmenities']
        ]);
        if($restaurant){
            $response['status']=true;
            $response['data']=$restaurant;
        }else{
            $response['status']=false;
            $response['msg']='Invalid Restaurant!';
            $response['msg_p']='Restaurante inválido!';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    /*
     * Search Restaurant By name
     * @params: name
     */
    public function searchByName(){
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            $latitiude = $this->request->getData('latitude');
            $longitude = $this->request->getData('longitude');

             $distanceField = '(3959 * acos (cos ( radians(:latitude) )
                * cos( radians( Restaurants.latitude ) )
                * cos( radians( Restaurants.longitude )
                - radians(:longitude) )
                + sin ( radians(:latitude) )
                * sin( radians( Restaurants.latitude ) )))'; // in miles
             $query = $this->Restaurants->find()
                ->select(['Restaurants.id','Restaurants.name','Restaurants.image','Restaurants.latitude','Restaurants.longitude','Restaurants.avg_rating','Restaurants.starting_price','Cuisines.name',
                    'distance' => $distanceField
                ]) ->having(["distance < " => 10])
                ->bind(':latitude', $latitiude, 'float')
                ->bind(':longitude', $longitude, 'float')->contain(['Cuisines','Users'=>function($q){
                        return $q->where(['Users.status'=>true]);
                    }])->where(function ($exp, $q) use ($name) {
                            return $exp->like('Restaurants.name', "%$name%");
                    })->toArray();
            if(count($query)>0){
                $response['status']=true;
                $response['data']=$query;
            }else{
                $this->loadModel('Cuisines');
                $cuisines = $this->Cuisines->find('all')
                ->where(function ($exp, $q) use ($name) {
                    return $exp->like('name', "%$name%");
                });
                if(count($cuisines)>0){
                    $cuisine_ids=[];
                    foreach ($cuisines as $key => $value) {
                        array_push($cuisine_ids, $value->id);
                    }
                    if(count($cuisine_ids)>0){
                        $restaurants = $this->Restaurants->find('all') ->select(['Restaurants.id','Restaurants.name','Restaurants.latitude','Restaurants.longitude','Restaurants.image','Restaurants.avg_rating','Restaurants.starting_price','Cuisines.name',
                            'distance' => $distanceField
                        ]) ->having(["distance < " => 10])
                        ->bind(':latitude', $latitiude, 'float')
                        ->bind(':longitude', $longitude, 'float')->contain(['Cuisines','Users'=>function($q){
                                return $q->where(['Users.status'=>true]);
                            }])->where(['Restaurants.cuisine_id IN'=>$cuisine_ids])->toArray();
                        if(count($restaurants)>0){
                            $response['status']=true;
                            $response['data']=$restaurants;
                        }else{
                            $response['status']=false;
                            $response['msg']='No result found!';
                            $response['msg_p']='Nenhum resultado encontrado!';
                        }
                    }else{
                        $response['status']=false;
                        $response['msg']='No result found!';
                        $response['msg_p']='Nenhum resultado encontrado!';
                    }
                }else{
                    $response['status']=false;
                    $response['msg']='No data found! Try using another keyword!';
                    $response['msg_p']='Nenhum dado encontrado! Tente usar outra palavra-chave!';
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
    /*
     * Search Restaurants using various filters
     * @param: name, cuisine_id, min_price, max_price, distance
     */
    public function filter(){
        if($this->request->is('post')){
            $latitiude = $this->request->getData('latitude');
            $longitude = $this->request->getData('longitude');
            $conditions=['Restaurants.status' => 1];
            if($this->request->getData('cuisine_id') && is_array($this->request->getData('cuisine_id'))){
                $conditions['Restaurants.cuisine_id IN']=$this->request->getData('cuisine_id');
            }
            if($this->request->getData('min_price') && strlen($this->request->getData('min_price'))>0){
                $conditions['Restaurants.starting_price >=']=$this->request->getData('min_price');
            }
            if($this->request->getData('max_price') && strlen($this->request->getData('max_price'))>0){
                $conditions['Restaurants.starting_price <=']=$this->request->getData('max_price');
            }
            if($this->request->getData('name')  && strlen($this->request->getData('name'))>0){
                $conditions['Restaurants.name LIKE']="%".$this->request->getData('name')."%";
            }
            //$amenities = [1];
            if($this->request->getData('amenities') && is_array($this->request->getData('amenities'))){
                $amenities = $this->request->getData('amenities');
                //$conditions['RestaurantAmenities.amenity_id IN']= [2,3];
            }
            //debug($amenities);
           // $restaurants = $this->Restaurants->find('all')->where($conditions)->contain(['Cuisines']);
            // Distance in km, convert it to miles
            if($this->request->getData('distance') && strlen($this->request->getData('distance')>0)){
                $distance = 0.621371 * $this->request->getData('distance'); // km to miles
            }else{
                $distance = 10;
            }
            //echo $distance;
            $distanceField = '(3959 * acos (cos ( radians(:latitude) )
                    * cos( radians( Restaurants.latitude ) )
                    * cos( radians( Restaurants.longitude )
                    - radians(:longitude) )
                    + sin ( radians(:latitude) )
                    * sin( radians( Restaurants.latitude ) )))'; //* 1.60934
            if(isset($amenities)){
                $restaurants = $this->Restaurants->find()
                    ->select(['Restaurants.id','Restaurants.name','Restaurants.image','Restaurants.avg_rating','Restaurants.starting_price','Restaurants.latitude','Restaurants.longitude','Cuisines.name',
                        'distance' => $distanceField
                    ]) ->having(["distance < " => $distance])
                    ->bind(':latitude', $latitiude, 'float')
                    ->bind(':longitude', $longitude, 'float')
                    ->contain(['Cuisines',
                        //'RestaurantAmenities',
                        'RestaurantAmenities'=>function($query) use($amenities){
                            return $query->select(['amenity_id','restaurant_id'])
                           ->where(['RestaurantAmenities.amenity_id IN' => $amenities]);    
                        },
                        'Users'=>function($q){
                            return $q->where(['Users.status'=>true]);
                        }])
                    ->where($conditions)->toArray();
            }else{
//                print_r($conditions); exit;
                $restaurants = $this->Restaurants->find()
                    ->select(['Restaurants.id','Restaurants.name','Restaurants.image','Restaurants.avg_rating','Restaurants.starting_price','Restaurants.latitude','Restaurants.longitude','Cuisines.name',
                        'distance' => $distanceField
                    ]) ->having(["distance < " => $distance])
                    ->bind(':latitude', $latitiude, 'float')
                    ->bind(':longitude', $longitude, 'float')
                    ->contain(['Cuisines',
                        //'RestaurantAmenities',
                        'RestaurantAmenities',
                        'Users'=>function($q){
                            return $q->where(['Users.status'=>true]);
                        }])
                    ->where($conditions)->toArray();
            }
            
           // debug($restaurants); exit;
            if($restaurants){
                $response['status']=true;
                $response['miles']=$distance;
                $response['data']=$restaurants;
            }else{
                $response['status']=false;
                $response['miles']=$distance;
                $response['msg']='No data found!';
                $response['msg_p']='Nenhum resultado encontrado!';
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
