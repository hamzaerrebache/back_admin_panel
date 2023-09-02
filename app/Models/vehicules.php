<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicules extends Model
{
    use HasFactory;
    protected $fillable =[
        'images',
        'model',
        'year',
        'color',
        'mileage',
        'fuel_type',
        'daily_price',
        'weekly_price',
        'monthly_price',
        'availabilty',
        'agency_id'
    ];
}
