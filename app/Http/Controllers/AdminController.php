<?php

namespace App\Http\Controllers;

use App\Models\Earth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        $earths = Earth::orderBy('id')->get();
        return view('backend.index', compact('earths'));
    }
}
