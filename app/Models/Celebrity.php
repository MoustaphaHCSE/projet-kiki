<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Celebrity extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'description', 'image'];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
