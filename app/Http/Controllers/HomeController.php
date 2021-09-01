<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* IMPORT CLASSES */

/* IMPORT MODEL */
use App\Modul;
use App\Lecture;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
    {
        $modul = Modul::withCount('lectures')->where('status', '1')->take(6)->get();
        $sum_data = Modul::count();
        $search = '';
        return view('home', compact('modul', 'sum_data', 'search'))->with('title', 'Beranda');
    }

    public function retrieve(Request $request)
    {
        /*ajax fetching*/
        $taker = $request->get('taker');
        $sum_data = $request->get('sumData');
        /*end*/

        if ($taker > $sum_data) {
            $taker = $sum_data;
        }

        /*check apakah ada data yang di parse lewat uri*/
        $search = $request->get('searchData');
        /*end*/

        $modul = Modul::withCount('lectures')->where('status', '1')->where('title', 'like', "%" . $search . "%")
            ->orWhere('status', '1')->where('level', 'like', "%" . $search . "%")
            ->orWhere('status', '1')->where('platform', 'like', "%" . $search . "%")
            ->take($taker)->get();

        return view('retrieveHome', compact('modul'));
    }
}
