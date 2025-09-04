<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = true;

    // Quan hệ: Một role có nhiều user
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
