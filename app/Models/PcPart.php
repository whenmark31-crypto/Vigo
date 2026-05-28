<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcPart extends Model
{
    protected $fillable = ['user_id', 'name', 'category', 'brand', 'price', 'quantity', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
