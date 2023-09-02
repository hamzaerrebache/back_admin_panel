<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{
    use HasFactory;
    protected $fillable =[
        'pickup_date',
        'pickup_location',
        'return_location',
        'return_date',
        'total_price',
        'vehicule_id',
        'agency_id',
        'client_id'
    ];

}
