<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planet extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'terrain'];

    /**
     * Get the persons who was born on the planet
     *
     * @return HasMany
     */
    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
