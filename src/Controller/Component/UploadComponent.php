<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class UploadComponent extends Component
{
    public function uploadFile($filedata, $uploadPath,$supported_file_types){
        if($filedata['error']>0){
            $response['status']=false;
            $response['msg']='An error ocurred when uploading.';
        }
        else if(!in_array($filedata['type'],$supported_file_types)){
            $response['status']=false;
            $response['msg']='Unsupported filetype uploaded.';
        }
        else if($filedata['size'] > 500000){
            $response['status']=false;
            $response['msg']='File uploaded exceeds maximum upload size.';
        }else{
            $fileName = $filedata['name'];
            $fileName = str_replace(' ', '_', $fileName);
            $fileName = date('mdYhis').$fileName;
            $uploadFile = $uploadPath.$fileName;
            if(move_uploaded_file($filedata['tmp_name'],$uploadFile))
            {
                $response['status']=true;
                $response['image']=$uploadFile;
            }else{
                $response['status']=false;
                $response['msg']='Unsufficient permissions to the folder';
            }
        }
        return $response;
    }
    function base64_to_jpeg($base64_string, $uploadPath) {
	$img = $base64_string;
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = $uploadPath . uniqid() . '.png';
	$success = file_put_contents($file, $data);
        if($success){
            $response['status']=true;
            $response['image']=$file;
        }else{
            $response['status']=false;
            $response['msg']='Unable to save the file.';
        }
        return $response;
    }
}