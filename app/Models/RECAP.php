<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RECAP extends Model
{
    protected $table = 'recaps';
    protected $fillable = [
        'acct_code_old',
        'acct_code_new',
        'classification_code',
        'classification_name',//delete if not needed
        'beginning_balance',
        'purchase_2024',
        'reclassified_from_other',
        'reclassified_to_other',
        'disposed',
        'donated',
        'cancelled_adjustment',
        'total_2024',
    ];
}