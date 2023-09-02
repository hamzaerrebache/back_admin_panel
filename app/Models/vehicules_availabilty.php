<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicules_availabilty extends Model
{
    use HasFactory;
    protected $fillable =['avaible_date','vehicule_id','location_id'];
}
