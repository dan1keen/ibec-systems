<?php


namespace App\Services;


use App\Date;
use App\Models\Corral;
use App\Models\Sheep;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class SheepService
{
    public function createCorrals(){
        // Создаем для начала загоны
        $corrals = [];
        for($i=1;$i<=4;$i++) {
            $count = Corral::all()->count();
            if($count < 5) {
                $corrals = Corral::firstOrCreate([
                    "name" => "Corral " . $i
                ]);
            }
        }
        return $corrals;
    }

    public function generateRandSheeps(){
        // И сразу в загоны создаем и распределяем рандомно 10 овечек
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
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get(); // Берем загоны где кол-во овечек больше 1
        $count = Sheep::select('id')->max('id'); // Берем самое большое ID для counter
        $count = $count + 1;
        // Создаем овечку в рандомный загон
        $sheep = Sheep::firstOrCreate(
            [
                "name" => "Sheep no." . $count,
                "corral_id" => $corrals->random()->id,
                "date" => $date->format("Y-m-d")
            ]
        );
        // Записываем в отчеты
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
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get(); // Берем загоны где кол-во овечек больше 1
        $sheep = Sheep::findOrFail($corrals->random()->sheeps->random()->id); // Берем 1 рандомную овечку из загонов
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
        $sheep->delete(); // Удаляем рандомную овечку
        return [$sheep,$dates];
    }

    public function checkSheep(Carbon $date){
        $corrals = Corral::has("sheeps", "=", 1)->with("sheeps")->get(); // Берем загоны где кол-во овечек равна 1

        $sheep = [];
        foreach ($corrals as $corral) {
            $corralsMore = Corral::has("sheeps", ">", 1)->with("sheeps")->get(); // Берем рандомный загон где кол-во овечек больше 1
            $sheep = Sheep::where("corral_id", $corralsMore->random()->id)->first(); // Вытаскиваем первую овечку из рандомного загона
            $dates = Date::firstOrCreate(
                [
                    "date" => $date->format("Y-m-d"),
                    "description" => [
                        "name" => $sheep->name,
                        "old" => $sheep->corral->name,
                        "new" => $corral->name,
                        "status" => "updated"
                    ]
                ]

            );
            // Перетаскиваем овечку в загон где осталась 1 овечка
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