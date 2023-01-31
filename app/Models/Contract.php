<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    public string $number;
    public DateTime $date_start;
    public DateTime $date_end;
    public string $office_pickup;
    public string $office_return;
    public int $km_pickup;
    public int $km_return;

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
