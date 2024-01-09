<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * - Attributes.
 *
 * @property int $id
 * @property string $title
 * @property Date $created_at
 * @property Date $updated_at
 * - Relations.
 * @property Collection<int, Celebrity> $celebrities
 */
class Movie extends Model
{
    public function celebrities()
    {
        return $this->belongsToMany(Celebrity::class);
    }
}
