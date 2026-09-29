<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RpcppeRegistry;

class Disposable extends Model
{
    protected $fillable = [
        'rpcppe_id',
        'article',
        'name',
        'quantity',
        'unit_value',
        'property_number',
        'description',
        'place',
        'DateAcquired',
        'year',
        'WMR_num',
        'scanned_photos',
    ];

    protected $casts = [
        'scanned_photos' => 'array',
    ];

    public function rpcppe()
    {
        return $this->belongsTo(RpcppeRegistry::class, 'rpcppe_id');
    }
}