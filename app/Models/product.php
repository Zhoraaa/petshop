<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'descripton', 'parameters', 'advantages', 'usability', 'cost', 'type'];

    public function category()
    {
        return $this->belongsTo(ProductType::class, 'type');
    }
    public function __get($key)
    {
        switch ($key) {
            case 'category':
                return $this->category()->first()->name;

            case 'cover':
                return $this->productMedia()->first()->image;
        }

        return parent::__get($key);
    }

    public function productMedia()
    {
        return $this->hasMany(ProductMedia::class);
    }
}
