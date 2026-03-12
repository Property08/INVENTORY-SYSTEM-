<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
USE App\Models\PPERecap;

class Record extends Model
{
    use HasFactory;

    protected $table = 'records';

    protected $fillable = [
        'year',
        'title',
        'pdf_path',
        'excel_path',
    ];

    public function recaps()
    {
        return $this->hasMany(PPERecap::class);
        
    }
    protected $casts = [
    'date_acquired' => 'date:m-d-Y',
];
}


