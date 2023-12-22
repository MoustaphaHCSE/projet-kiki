<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'description', 'image'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
