<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPERecap extends Model
{
    use HasFactory;

    protected $table = 'ppe_recaps';

    protected $fillable = [
        'record_id', 'acct_code_new', 'acct_code_old', 'classification',
        'year', 'beginning_balance', 'purchases', 'reclass_from',
        'reclass_to', 'disposed', 'donated', 'adjustments', 'total'
    ];

    protected $casts = [
        'beginning_balance' => 'decimal:2',
        'purchases' => 'decimal:2',
        'reclass_from' => 'decimal:2',
        'reclass_to' => 'decimal:2',
        'disposed' => 'decimal:2',
        'donated' => 'decimal:2',
        'adjustments' => 'decimal:2',
        'total' => 'decimal:2',
    ];
}
