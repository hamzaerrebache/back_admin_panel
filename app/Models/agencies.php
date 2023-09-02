<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agencies extends Model
{
    use HasFactory;
    protected $fillable =[
        'agency_name',
        'logo_agence',
        'description',
        'latitude_location',
        'longitude_location',
        "user_id"
    ];
}
