<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Merchant extends Model
{
    use HasFactory;

    public function doLogin($username,$password){
        $member = Member::where('email',$username)->where('password', $password)->get();
        if($member->isEmpty()){
           return FALSE;
        }else{
            return $member;
        }
    }
    
    public static function sendSMS($to,$message) {
        
        $host='https://www.firetext.co.uk/api/sendsms?username=info@uaduk.com&password=UTlWTjdXc1RNWmVn&from=FireText&';
        $user='info@uaduk.com';
        $password='UTlWTjdXc1RNWmVn';	
        $is_curl=true;
        $to=trim($to);
        $sender='Firetext';
        $sms_type='normal';
        $priority='dnd';
        $params="to={phone}&message={text}";
        $params=str_replace("{text}",urlencode($message),$params);
        $params=str_replace("{phone}",urlencode($to),$params);
        $data = array(
            'to' => $to,
            'message' => $message
            );
        $error_no='';
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close ($ch);
       
        return "Success";
    }
    public function makeCall($data) {
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        */
    }
    public function rejectOrder($data) {
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/orderreject");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        */
    }
}
