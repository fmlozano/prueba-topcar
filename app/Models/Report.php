<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public string $file;
    public TimestampType $date_start;
    public TimestampType $date_end;

    protected $fillable = ['file', 'date_start', 'date_end'];
    protected $hidden = ['created_at', 'updated_at'];
}
