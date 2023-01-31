<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

class Customer extends Model
{
    use HasFactory;

    public string $first_name;
    public string $last_name;
    public string $identification;
    public Date $birth_date;
    public string $phone;
    public string $email;

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
