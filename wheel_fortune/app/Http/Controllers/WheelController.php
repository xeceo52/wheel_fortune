<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WheelController extends Controller
{
    public function index()
    {
        return view('wheel');
    }

    public function spin()
    {
        // Можно оставить порядок, как тебе удобно —
        // на фронте мы всё равно ищем сектор по строке.
        $prizes = [
            "Скидка 5%",
            "Скидка 10%",
            "Скидка 15%",
            "Сертификат 500р",
            "Сертификат 1000р",
            "Подарок",
        ];

        $weights = [
            3, // 5%
            1, // 10%
            1, // 15%
            1, // 500р
            1, // 1000р
            1  // Подарок
        ];

        $index = $this->weightedRandom($weights);

        return response()->json([
            // 'index' => $index, // можно больше не слать
            'prize' => $prizes[$index]
        ]);
    }

    // Функция выборки по весам
    private function weightedRandom($weights)
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);

        foreach ($weights as $i => $w) {
            if ($rand <= $w) {
                return $i;
            }
            $rand -= $w;
        }
        return 0;
    }
}
