<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DisposableController extends Controller
{
    public function index()
    {
         // Example: pass sample data (replace with db later)

         $items = [
         
         ];
         return view('disposable', compact('items'));
    }
}