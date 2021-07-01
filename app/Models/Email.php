<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Mailjet\Resources;

class Email extends Model
{
    use HasFactory;

    public static function send($to,$rest,$cname,$subject,$mail){
        
        require app_path().'/../vendor/autoload.php';
        
        include(app_path() . '/Mailjet/src/Mailjet/Client.php');
        include(app_path() . '/Mailjet/src/Mailjet/Config.php');
        include(app_path() . '/Mailjet/src/Mailjet/Resources.php');
        include(app_path() . '/Mailjet/src/Mailjet/Request.php');
        include(app_path() . '/Mailjet/src/Mailjet/Response.php');

        $mj = new \Mailjet\Client('cf7605a32717d7b016f974a988aaf71a','cf416e1237e4703a5c8d51b6a9176147',true,['version' => 'v3.1']);
        $body = [
        'Messages' => [
        [
        'From' => [
        'Email' => "info@ijoo.co.uk",
        'Name' => $rest
        ],
        'To' => [
        [
        'Email' => $to,
        'Name' => $cname
        ]
        ],
        'Subject' => $subject,
        'TextPart' => "email",
        'HTMLPart' => $mail,
        'CustomID' => "AppGettingStartedTest"
        ]
        ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        return $response->success();



    }
}
