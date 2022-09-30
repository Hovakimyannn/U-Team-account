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

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string[]
     */
    protected $fillable = [
       'name',
   ];

    /**
     * @return HasMany
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getRoleByName(string $name)
    {
        return $this->where('name', $name)->first();
    }
}
