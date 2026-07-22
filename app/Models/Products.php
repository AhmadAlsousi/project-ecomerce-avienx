<?php

namespace App\Models;

use App\Enum\Product\ProductImageEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Products extends Model implements HasMedia
{
     use InteractsWithMedia;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'price',
        'status'
    ];
     public function registerMediaCollections(): void
    {
        $this->addMediaCollection(ProductImageEnum::MAIN->value)->useDisk(ProductImageEnum::MAIN->value);
        $this->addMediaCollection(ProductImageEnum::GALLARY->value)->useDisk(ProductImageEnum::GALLARY->value);
        $this->addMediaCollection(ProductImageEnum::GALLARY_COLOR->value)->useDisk(ProductImageEnum::GALLARY_COLOR->value);


    }
    public function user() {
        return $this->hasMany(User::class);
    }
      public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }
       
      public function category() {
        return $this->belongsTo(Category::class);
    }
}
