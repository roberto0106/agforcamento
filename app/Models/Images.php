<?php

namespace App\Models;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = [
        'image_address','cor','image_logo','text_color'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

}
