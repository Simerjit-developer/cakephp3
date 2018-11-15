<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class PushComponent extends Component
{
    
    public function AndroidPush($android_users,$sender_id,$job_id,$type,$notification_msg){
        //Default result
        $result = -1;
        //$keys=array('eP80CtG9BmQ:APA91bE7LcAJdg3Ja1-jecyC4zBaTvow5X_ecEjlaBrNr7Sk3iIAg7J49T8FEpPZsLOCnEwcyaa0u4q-G5Ot3UNspio7VdDkg-hWsVOnQMoG4LA7cjFGqtDbaBdvGu9vhCQlNUh8y1O6','cOa0UvMw7SI:APA91bEp1N006Wg0p9aWg5BXUa2Re4AU48L6N9Q5t5lLxdUfpfXhMAHKz2zgiuAFP76g1XsZlazxdDeMGXgbrKV3PczALMK8Kq8gHXZVqE7G5SavNzUCv5F5UClJljPz3BSBiWfprxp9','dcu3Fi7SigE:APA91bFo1oyIImE2LjX9fxJmUKBpjoisu0Y2wYmID7r5z2E0Dd0oBxmfbf5821VXSWIcLIB0okPXmXJ9TJ90mQI3_FvDFkGF8Lf3xsTQGQj4HwZbB0HpteZx-VuiB5hksiusUVJR_eq6',);
        //$user_device_key = "cOa0UvMw7SI:APA91bEp1N006Wg0p9aWg5BXUa2Re4AU48L6N9Q5t5lLxdUfpfXhMAHKz2zgiuAFP76g1XsZlazxdDeMGXgbrKV3PczALMK8Kq8gHXZVqE7G5SavNzUCv5F5UClJljPz3BSBiWfprxp9";
        // API access key from Google API's Console
        define('API_ACCESS_KEY_ANDROID', 'AIzaSyCna9lSoy6x41EgjNDE0XdKV64NENepGfY');
        // prep the bundle
        $msg = array
        (
            'message' => $notification_msg,
            'title' => 'Notification Alert!',
            'vibrate' => 1,
            'sound' => 'default',
            'badge'=>1,
            'job_id' => $job_id,
            'notification_type' => $type
        );
        $fields = array
        (
            'registration_ids'=>$android_users,
            'notification' => array(
                'title' => 'Notification Alert!',
                'body' =>  $notification_msg ,
                'sound'=>'Default'
            ),
            //'registration_ids' => array($user_device_key),
            'data' => $msg
        );
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY_ANDROID,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result > 0;
    }
    
    public function IOSPush($ios_users,$sender_id,$order_id,$type,$notification_msg) {
        define('API_ACCESS_KEY', 'AIzaSyDCoOI7wHsObA_i9EV0qXlhDSqfLfhU5Lg');
       // $token=array('fR1MJ1n0pCQ:APA91bEtjLhvLuHpc4sER24eVTN7TmnK_bHfN5nTAJZe66Bna1nb7yYekPP0xOSzNN6SYd0x0G-VMRFgwrMDpHTi0I7T4rN-yD-ukDssnuRtL0giqfti6VJUL_SxxKv9RDfwJREoLKFw');
       // $path_to_firebase_cm = '<a class="vglnk" href="https://fcm.googleapis.com/fcm/send" rel="nofollow"><span>https</span><span>://</span><span>fcm</span><span>.</span><span>googleapis</span><span>.</span><span>com</span><span>/</span><span>fcm</span><span>/</span><span>send</span></a>';
 
        $fields = array(
            'registration_ids' => $ios_users,
            'priority' => 10,
            'notification' => array(
                'title' => 'Notification Alert!',
                'body' =>  $notification_msg ,
                'sound'=>'Default'
                ),
            'data'=>array(
                'message' => $notification_msg,
                'body'=>$notification_msg,
                'order_id' => $order_id,
                'notification_type' => $type,
            )
        );
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type:application/json'
        );  
         
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' ); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
        return $result;
    }
    
    public function IOSRewardPush($ios_users,$notification_msg) {
        define('API_ACCESS_KEY', 'AIzaSyDCoOI7wHsObA_i9EV0qXlhDSqfLfhU5Lg');
       // $token=array('fR1MJ1n0pCQ:APA91bEtjLhvLuHpc4sER24eVTN7TmnK_bHfN5nTAJZe66Bna1nb7yYekPP0xOSzNN6SYd0x0G-VMRFgwrMDpHTi0I7T4rN-yD-ukDssnuRtL0giqfti6VJUL_SxxKv9RDfwJREoLKFw');
       // $path_to_firebase_cm = '<a class="vglnk" href="https://fcm.googleapis.com/fcm/send" rel="nofollow"><span>https</span><span>://</span><span>fcm</span><span>.</span><span>googleapis</span><span>.</span><span>com</span><span>/</span><span>fcm</span><span>/</span><span>send</span></a>';
 
        $fields = array(
            'registration_ids' => $ios_users,
            'priority' => 10,
            'notification' => array(
                'title' => 'Congratulations!',
                'body' =>  $notification_msg ,
                'sound'=>'Default'
                ),
            'data'=>array(
                'message' => $notification_msg,
                'body'=>$notification_msg,
                'notification_type' => 'rewards',
            )
        );
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type:application/json'
        );  
         
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' ); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
        return $result;
    }
    public function AndroidRewardPush($android_users,$notification_msg){
        //Default result
        $result = -1;
        // API access key from Google API's Console
        define('API_ANDROID_ACCESS_KEY', 'AIzaSyCna9lSoy6x41EgjNDE0XdKV64NENepGfY');
        // prep the bundle
        $msg = array
        (
            'message' => $notification_msg,
            'title' => 'Congratulations!',
            'vibrate' => 1,
            'sound' => 'default',
            'badge'=>1,
            'notification_type' => 'rewards'
        );
        $fields = array
        (
            'registration_ids'=>$android_users,
            'notification' => array(
                'title' => 'Congratulations!',
                'body' =>  $notification_msg ,
                'sound'=>'Default'
            ),
            //'registration_ids' => array($user_device_key),
            'data' => $msg
        );
        $headers = array
        (
            'Authorization: key=' . API_ANDROID_ACCESS_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result > 0;
    }
}
