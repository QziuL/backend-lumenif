<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    // Retorna todas as estatísticas principais para o dashboard do criador.
    public function mainDashboardStats()
    {
        $creatorId = Auth::id();

        // Pega os IDs de todos os cursos do criador
        $courseIds = Course::where('creator_id', $creatorId)->pluck('id');

        // Total de cursos
        $totalCourses = $courseIds->count();

        // Total de alunos únicos em todos os cursos
        $totalUniqueStudents = Registration::whereIn('course_id', $courseIds)
            ->distinct('user_id')
            ->count();

        // 3. (Bônus) Média de avaliação (quando implementado)
        // $averageRating = ...

        return response()->json([
            'totalCursos' => $totalCourses,
            'totalAlunos' => $totalUniqueStudents,
            'avaliacaoMedia' => 4.8
        ]);
    }


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
