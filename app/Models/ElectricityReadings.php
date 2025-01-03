<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricityReadings extends Model
{
    use HasFactory;

    static $tableName = 'electricity_readings';
}
