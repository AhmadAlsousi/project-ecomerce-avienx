<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
        use SoftDeletes;
 protected $fillable = [
       
        'name',
        'slug',
        'description',
        'status',
        'parent_id'
    ];
     public function products()
    {
        return $this->hasMany(Products::class);
    }
    public function subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }
    //   public function products() {
    //     return $this->belongsToMany(Pr::class);
    // }
   
}
