<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpcppe extends Model
{
    // Add this is to stop Eloquent from expecting created_at and updated_at
    public $timestamps = false;
    use HasFactory;

    // tell laravel the exact table name 
    protected $table = 'rpcppe';
    protected $fillable = [
       // 'rpcppe_id', // --- IGNORE ---
        'article',
        'description',
        'property_no',
        'unit_value',
        'unit_of_measure',
        'quantity_per_property_card',
        'quantity_per_physical_count',
       // 'acc_code_new',// --- IGNORE ---
       // 'acc_code_old',// --- IGNORE ---
       // 'classcode',// ✅ Removed
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

    protected $dates = [
        'date_acquired',
    ];
}