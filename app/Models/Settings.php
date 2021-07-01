<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hours;

class Settings extends Model
{
    use HasFactory;
    
    public $fillable = ['test_mode','delivery','collection','pre_order' ,'reject_order','booking','dinein','paynow','voucher','coupon','active'];

    public  function isClosed($restaurant){
        $hours = Hours::where('day',date('w'))->first();
        $cur_time   =   strtotime(date("H:i:s"));
        $open = false;
        $start1    =   strtotime($hours->start1);
        $end1   =   strtotime($hours->end1);
        $start2    =   strtotime($hours->start2);
        $end2   =   strtotime($hours->end2);
        $pre_order_time = strtotime($restaurant->preorder_start);

        if(!$restaurant->test_mode){
            if($restaurant->active==0){
                $msg = "Restaurant is closed now";
            }else if($hours->active == 0){
                $msg = "Restaurant is closed for today";
            }else if($restaurant->pre_order && !empty($pre_order_time) && ($cur_time < $pre_order_time))
            {
                $msg = "Restaurant is closed now, Pre order starts at ".$restaurant->preorder_start;
            }else if(!$restaurant->pre_order && !empty($start1) && ($cur_time < $start1))
            {
                $msg = "Restaurant is closed now, Will open at ".$hours->start1;
            }else if(!$restaurant->pre_order && !empty($start2) && ($cur_time > $end1) && ($cur_time < $start2)){
                $msg = "Restaurant is closed now, Will open at ".$hours->start2;
            }else if(!empty($end2) && ($cur_time > $end2)){
                $msg = "Restaurant is closed now"; //start3
            }else{
                $open = true;
                $msg = "";
            }
           
        }else{
            $open = true;
        }       
         return !$open;
    }
}
