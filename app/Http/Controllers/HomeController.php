<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch 8 latest books for the catalog
        $bukus = Buku::latest('id_buku')->take(8)->get();
        
        return view('welcome', compact('bukus'));
    }
}
