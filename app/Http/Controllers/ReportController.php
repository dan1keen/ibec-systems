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
        $created = Date::where('date',$key)->whereRaw("description LIKE '%created%'")->count();
        $updated = Date::where('date',$key)->whereRaw("description LIKE '%updated%'")->count();
        $deleted = Date::where('date',$key)->whereRaw("description LIKE '%deleted%'")->count();
        return [$reports, $created, $updated, $deleted];
    }
}
