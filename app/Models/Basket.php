<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'orderer_id',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function orderer()
    {
        return $this->belongsTo(User::class, 'orderer_id');
    }
    public function __get($key)
    {
        switch ($key) {
            default:
                return parent::__get($key);
            case 'product':
                return $this->product()->first();
            case 'orderer':
                return $this->orderer()->first();
        }
    }
}
