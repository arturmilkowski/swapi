<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Person extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'planet_id',
        'name',
        'height',
        'mass',
        'hair_color',
        'gender',
        'homeworld',
    ];

    /**
     * Get the planet associated with the person.
     *
     * @return BelongsTo
     */
    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planet::class);
    }

    // public function persons(): HasMany
    // {
    //     return $this->hasMany(Person::class);
    // }
    
    /**
     * The starshis that belong to the person.
     */
    public function starships(): BelongsToMany
    {
        return $this->belongsToMany(Starship::class);
    }
}
