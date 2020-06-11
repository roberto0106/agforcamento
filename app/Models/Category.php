<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'event_type_id',
        'name',
        'status',
        'position',
        'image',
    ];
    public static function status()
    {
        return [
            0 => 'Inativo',
            1 => 'Ativo'
        ];
    }

    public static function getCategoryEventTypeArray()
    {
        $cats = self::where('status', 1)->orderBy('event_type_id')->get();

        if ($cats->count()>0){
            foreach ($cats as $o){
                $return[$o->id] = $o->name.' / '.$o->eventType->name;
            }
        }else{
            $return=null;
        }

            return $return;
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
