<?php

namespace App\Http\Controllers;

use App\Models\Corral;
use App\Models\Sheep;
use App\Services\SheepService;
use Illuminate\Http\Request;

class SheepController extends Controller
{
    protected $sheep_service;

    public function __construct(SheepService $sheep_service)
    {
        $this->sheep_service = $sheep_service;
    }

    public function index(){
        $sheeps = Sheep::with("corral")->get();
        return $sheeps;
    }

    public function indexForCorrals(){
        $corrals = Corral::with("sheeps")->get();
        return $corrals;
    }

    public function createSheeps(){
        $created = $this->sheep_service->generateRandSheeps();
        return $created;
    }
    public function createCorrals(){
        $created = $this->sheep_service->createCorrals();
        return $created;
    }

}
