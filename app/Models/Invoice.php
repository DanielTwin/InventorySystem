<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
         return $this->belongsTo('App\User');
    }

    public function products()
    {
         return $this->belongsToMany('App\Product');
    }
}
