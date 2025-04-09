<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'state',
        'city'
    ];

    #[Scope]
    protected function filters(Builder $query, array $filters): void
    {
        foreach ($filters as $key => $value) {
            $query->where($key, 'ILIKE', "%{$value}%");
        }
    }
}
