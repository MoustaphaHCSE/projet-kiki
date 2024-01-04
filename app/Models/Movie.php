<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property Celebrity $celebrity
 */
class Movie extends Model
{
    use HasFactory;

    public function celebrities()
    {
        return $this->belongsToMany(Celebrity::class);
    }
}
