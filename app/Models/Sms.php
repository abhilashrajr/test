<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function send($to,$message) {
        
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
}
