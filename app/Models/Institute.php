<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
    use
        HasFactory,
        AttributesModifier;

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    public function departments() : HasMany
    {
        return $this->hasMany(Department::class);
    }
}
