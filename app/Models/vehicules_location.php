<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicules_location extends Model
{
    use HasFactory;
    protected $fillable =[
        'location_name','location_address','city_id'
    ];
}
