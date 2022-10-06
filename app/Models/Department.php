<?php

namespace App\Models;

use App\Models\Traits\AttributesModifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use
        HasFactory,
        AttributesModifier;

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];
}
