<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $name
 * @method where(string $string, string $name)
 */
class Role extends Model
{
    use HasFactory;

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getRoleByName(string $name)
    {
        return $this->where('name', $name)->first();
    }
}
