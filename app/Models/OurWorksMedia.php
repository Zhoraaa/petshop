<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurWorksMedia extends Model
{
    protected $fillable = ['work_id', 'image'];

    public $timestamps = false;

    use HasFactory;

    public function owork() {
        return $this->belongsTo(OurWorks::class, 'work_id');
    }
}
