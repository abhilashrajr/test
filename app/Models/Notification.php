<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Notification extends Model
{
    use HasFactory;

    public function send($title,$message) {
        $merchant = Member::first();
        $device_id = $merchant->device_id;

        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "c81a5971-02a1-4c7f-8b7f-2e3200a7234f",
            'include_player_ids' => array($device_id),
            'data' => array("title" => $title),
            'android_sound' => "ring",
            'contents' => $content
        );
        $fields = json_encode($fields);
        //do {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
       // } while ($response['recipients'] >= 1);

      
    }
}
