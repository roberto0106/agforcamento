<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'institution',
        'courses',
        'month_conclusion',
        'year_conclusion',
        'comments',
    ];



    public static function ClientToSelect(){

        if(auth()->user()->level > 5){
            $data = static::where('user_id', auth()->user()->id)->get()->toArray();
        }else{
            $data = static::all()->toArray();
        }

        $ret = [];
        foreach($data as $rs){
            $name = $rs['name']." / ".$rs['institution']." - ".$rs['courses']." - ".$rs['month_conclusion']." / ".$rs['year_conclusion'];
            $ret[$rs['id']] = $name;
        }
        return $ret;
    }
}

