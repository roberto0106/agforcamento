<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'number_of_installments',
        'fee',
        'photo_exclusivity',
        'shelf_life',
        'paying_commission',
        'internal_comment',
        'external_comment',
        'status',
        'token_access',
    ];

    public static function status(){
        return [
            1 => 'Iniciado',
            2 => 'Concluído',
            3 => 'Bloqueado',
            4 => 'Cancelado',
            5 => 'Perdido',
            6 => 'Fechado',
        ];
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function eventTypes(){
        return $this->hasMany(BudgetCategories::class, 'budget_id', 'id');
    }
}
