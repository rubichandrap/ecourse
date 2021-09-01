<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */

/* IMPORT MODEL */
use App\User;
use App\Modul;

class PencarianController extends Controller
{
    public function index(Request $request) {
        $search = $request->search_input;
        $sum_data = Modul::where('status', '1')->where('title', 'like', "%" . $search . "%")
            ->orWhere('status', '1')->where('level', 'like', "%" . $search . "%")
            ->orWhere('status', '1')->where('platform', 'like', "%" . $search . "%")->count();

        $modul = Modul::withCount('lectures')->where('status', '1')->where('title', 'like', "%".$search."%")
            ->orWhere('status', '1')->where('level', 'like', "%".$search."%")
            ->orWhere('status', '1')->where('platform', 'like', "%".$search."%")
            ->take(6)->get();
        return view('home', compact('modul', 'sum_data', 'search'))->with('title', 'Beranda');
    }
}
