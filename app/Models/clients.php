<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    use HasFactory;
    protected $fillable =[
        'mail',
        'first_name_client',
        'last_name_client',  
        'password_client',
        'adress_client',
        'code_postal_client',
        'city_client',
        'country_client',
        'pays_client'
    ];
}
