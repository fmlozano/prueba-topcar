<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    public string $brand;
    public string $model;
    public string $plate_number;
    public string $chassis_number;
    public string $color;
    public int $km;

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
