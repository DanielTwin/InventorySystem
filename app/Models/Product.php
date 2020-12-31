<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name','category_id','stock','price'
    ];

    protected $hidden = [
        'category_id'
    ];

    public function categorie()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoice');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
