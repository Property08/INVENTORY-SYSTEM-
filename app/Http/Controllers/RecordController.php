<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    // Show all records
    public function index()
    {
        $records = Record::latest()->get();
        return view('records', compact('records'));
    }
}
