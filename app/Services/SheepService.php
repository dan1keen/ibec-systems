<?php


namespace App\Services;


use App\Date;
use App\Models\Corral;
use App\Models\Sheep;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class SheepService
{


    public function generateRandSheeps(){
        $sheep = [];
        $dates = [];
        $corral = Corral::all();
        $date = Carbon::now();
        for($i=0;$i<10;$i++) {
            $count = Sheep::all()->count();
            $random_corral = Corral::all()->random();

            if($count < 10) {
                $count = $count + 1;
                $sheep = Sheep::firstOrCreate(
                    [
                        "name" => "Sheep no." . $count,
                        "corral_id" => $random_corral->id,
                        "date" => $date->format("Y-m-d")
                    ]
                );
                $dates = Date::firstOrCreate(
                    [
                        "date" => $date->format("Y-m-d"),
                        "description" => [
                            "name" => "Sheep no." . $count,
                            "corral_id" => $random_corral->id,
                            "status" => "created"
                        ]
                    ]

                );

            }
        }
        return [$sheep,$dates];
    }

    public function createSheep(Carbon $date){
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
        $count = Sheep::all()->count();
        $count = $count + 1;
        $sheep = Sheep::firstOrCreate(
            [
                "name" => "Sheep no." . $count,
                "corral_id" => $corrals->random()->id,
                "date" => $date->format("Y-m-d")
            ]
        );
        $dates = Date::firstOrCreate(
            [
                "date" => $date->format("Y-m-d"),
                "description" => [
                    "name" => "Sheep no." . $count,
                    "corral_id" => $corrals->random()->id,
                    "status" => "created"
                ]
            ]

        );
        return [$sheep,$dates];
    }

    public function removeSheep(Carbon $date){
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
        $sheep = Sheep::findOrFail($corrals->random()->sheeps->random()->id);
        $dates = Date::firstOrCreate(
            [
                "date" => $date->format("Y-m-d"),
                "description" => [
                    "name" => $sheep->name,
                    "corral_id" => $sheep->corral_id,
                    "status" => "deleted"
                ]
            ]

        );
        $sheep->delete();
        return [$sheep,$dates];
    }

    public function checkSheep(Carbon $date){
        $corrals = Corral::has("sheeps", "=", 1)->with("sheeps")->get();

        $sheep = [];
        foreach ($corrals as $corral) {
            $corralsMore = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
            $sheep = Sheep::where("corral_id", $corralsMore->random()->id)->first();
            $dates = Date::firstOrCreate(
                [
                    "date" => $date->format("Y-m-d"),
                    "description" => [
                        "name" => $sheep->name,
                        "corral_id" => $sheep->corral_id,
                        "status" => "updated"
                    ]
                ]

            );
            $sheep->update(
                [
                    "corral_id" => $corral->id,
                    "date" => $date->format("Y-m-d")
                ]

            );
        }

        return $sheep;
    }
}