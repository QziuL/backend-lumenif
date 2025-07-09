<?php

namespace App\Http\Controllers;

use App\Enums\CourseStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    // Retorna ao Frontend os dados para serem apresentados nos gráficos
    // É usado o próprio Enum de Status dos Cursos para traduzir os status direto ao Front
    public function courseStatusStats()
    {
        $stats = Auth::user()->courses()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

//        $translatedStats = $stats->map(function ($item) {
//            $enumCase = CourseStatusEnum::tryFrom($item->raw_status);
//            if ($enumCase) {
//                $item->status = $enumCase->label();
//            } else {
//                $item->status = $item->raw_status;
//            }
//            unset($item->raw_status);
//            return $item;
//        });

        return response()->json($stats);
    }

    public function topCoursesByStudents()
    {
        $stats = Auth::user()->courses()
            ->withCount('registrations')
            ->orderBy('registrations_count', 'desc')
            ->limit(5)
            ->get();

        return response()->json($stats);
    }
}
