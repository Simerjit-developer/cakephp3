<?php
namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Cuisines Controller
 *
 * @property \App\Model\Table\CuisinesTable $Cuisines
 *
 * @method \App\Model\Entity\Cuisine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $device = $this->Devices->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->getData()); exit;
            $exist = $this->Devices->find('all')->where(['user_id'=>$this->request->getData('user_id'),'device_token'=>$this->request->getData('device_token'),'device_type'=>$this->request->getData('device_type')])->toArray();
            if(count($exist)>0){
                $response['status']=true;
                $response['msg']='Already Saved';
                $response['msg_p']='Já salvo';
            }else{
                $device = $this->Devices->patchEntity($device, $this->request->getData());
                if ($this->Devices->save($device)) {
                    $response['status']=true;
                    $response['msg']='Saved Successfully';
                    $response['msg']='Salvo com sucesso';
                }else{
                    $response['status']=false;
                    $response['msg']='Unable to Save';
                    $response['msg']='Incapaz de salvar';
                }
            }
        }else{
            $response['status']=false;
            $response['msg']='POST method required';
            $response['msg']='Método POST requerido';
        }
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
