<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurWorks extends Model
{
    protected $fillable = ['name', 'cover', 'description', 'year', 'what_we_do'];

    use HasFactory;

    public function OWMedia() {
        return $this->hasMany(OurWorksMedia::class, 'work_id');
    }
}
