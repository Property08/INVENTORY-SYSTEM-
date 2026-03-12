<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpcppe extends Model
{
    use HasFactory;

    // Stop Eloquent from expecting created_at and updated_at
    public $timestamps = false;

    // Ang eksaktong pangalan ng table sa MySQL
    protected $table = 'rpcppe';

    protected $fillable = [
        'article',
        'classification',
        'description',
        'property_no',
        'unit_value',
        'unit_of_measure',
        'quantity_per_property_card',
        'quantity_per_physical_count',
        'remarks',
        'date_acquired',
        'accountable_person',
        'location',
        'ptsd',
        'division',
        'section_unit',
        'transfer_to',
        'shortage_overage_qty',
        'shortage_overage_value',
    ];

}