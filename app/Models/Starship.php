<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Starship extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'model'];
    
    /**
     * The people that belong to the starship.
     *
     * @return BelongsToMany
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
