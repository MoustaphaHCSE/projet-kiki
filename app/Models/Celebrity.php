<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

/**
 * - Attributes.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $description
 * @property string $image
 * @property Date $created_at
 * @property Date $updated_at
 * @property Date $deleted_at used when soft-delete
 * - Relations.
 * @property Collection<int, Movie> $movies
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
