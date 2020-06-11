<?php

namespace App\Models    ;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{


    protected $fillable=['name','status','position'];

    public static function getEventTypesArray(){
        $eTypes = \App\Models\EventType::where('status', 1)->select('id', 'name')->get()->toArray();

        if($eTypes){
            foreach ($eTypes as $obj){
                $return[$obj['id']] = $obj['name'];
            }
            return $return;
        }else{
            $return = null;
            return $return;
        }
    }
}
