<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        
        $query = Buku::query();

        if ($search) {
            $query->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
        }

        // Fetch paginated books for the catalog (12 per page)
        $bukus = $query->latest('id_buku')->paginate(12)->withQueryString();
        
        return view('welcome', compact('bukus', 'search'));
    }
}
