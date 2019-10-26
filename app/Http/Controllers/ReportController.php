<?php

namespace App\Http\Controllers;

use App\Date;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $reports = Date::orderBy('id', 'desc')->get()->groupBy(function($item){return $item->date;});

        return $reports;
    }

    public function show($key){
        $reports = Date::where('date',$key)->orderBy('id', 'desc')->get();
        return $reports;
    }
}
