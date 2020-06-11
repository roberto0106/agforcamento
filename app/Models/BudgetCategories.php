<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategories extends Model
{
    protected $fillable = [
        'budget_id',
        'category_id',
        'number_forming',
        'invitations_by_forming',
        'extra_invitations',
        'extra_invitations_value',
        'extra_tables',
        'extra_tables_value'
    ];
}










