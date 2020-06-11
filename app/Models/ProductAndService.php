<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAndService extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'cost_price',
        'minimum_price',
        'description',
        'position',
        'proportion_per_person',
        'multiplying_graduates',
        'multiplied_invitations',
        'extras_invitations',
        'extras_tables',
        'alias',
        'comments',
    ];

    public static function getProductsArray()
    {
        $ret = [];
        $cats = Category::all();
        $prods = self::where('alias', 0)->orderBy('name')->get()->toArray();
        foreach ($prods as $p){
            $cat = $cats->find($p['category_id']);
            $ret[$p['id']] = $p['name'].' - '.$cat->name.' - '.$cat->eventType->name;
        }
        return $ret;
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'id','category_id');
    }
}
