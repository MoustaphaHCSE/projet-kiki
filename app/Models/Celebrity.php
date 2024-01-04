<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * - Attributes.
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $description
 * @property string $image
 * - Relations.
 * @property Movie $movie
 */
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
