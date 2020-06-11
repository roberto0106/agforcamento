<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetProductAndServices extends Model
{
    protected $fillable = [
        'name',
        'client_id',
        'original_id',
        'budget_id',
        'category_id',
        'price',
        'cost_price',
        'minimum_price',
        'description',
        'position',
        'amount',
        'proportion_per_person',
        'multiplying_graduates',
        'multiplied_invitations',
        'extras_invitations',
        'extras_tables',
        'alias',
        'comments',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
