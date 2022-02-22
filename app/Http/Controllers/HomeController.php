<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {
        error_log(json_encode($request->user()));

        if($request->user()->type === 0){
            //eturn view('/admin/home');
            return view('/admin/home');
        }else if($request->user()->type === 2){
            return view('/stud/home');
        }else{
            return view('/lecturer/home');
        }
    }
}
