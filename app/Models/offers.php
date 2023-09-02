<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offers extends Model
{
    use HasFactory;
    protected $fillable =[
        'offre_name',
        'Offre_description',
        'offre_dscount',
        'start_date',
        'end_date',
        'agency_id',
    ];
}
