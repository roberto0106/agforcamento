<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //

    public static function getCategoryArray(){
        $eTypes = \App\Models\Category::where('status', 1)->select('id', 'name')->get()->toArray();

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
