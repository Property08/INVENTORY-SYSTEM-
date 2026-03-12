<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposable extends Model
{
    use HasFactory;

    protected $fillable = [
  'article',           // Added
    'name',
    'quantity',
    'unit_value',        // Added
    'property_number',
    'description',
    'DateAcquired',
    'year', 
    'WMR_num',
];
}
