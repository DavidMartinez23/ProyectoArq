<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProgress;
use App\Models\ModuleUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener todos los progresos del estudiante
        $courseProgress = StudentProgress::where('user_id', $user->id)
            ->with(['course.modules'])
            ->get();
        
        // Calcular estadísticas generales
        $activeCourses = $courseProgress->where('completed', false)->count();
        $completedCourses = $courseProgress->where('completed', true)->count();
        
        // Calcular tiempo total (simulado - necesitarás implementar el tracking real de tiempo)
        $totalTime = $courseProgress->sum('total_time_spent') ?? 0;
        
        // Obtener datos para la gráfica de progreso
        $progressDates = [];
        $progressData = [];
        
        // Obtener los últimos 7 días de progreso
        for($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $progressDates[] = Carbon::now()->subDays($i)->format('d/m');
            
            // Calcular el progreso promedio para ese día
            $dayProgress = ModuleUser::where('user_id', $user->id)
                ->whereDate('completed_at', $date)
                ->count();
                
            $progressData[] = $dayProgress;
        }
        
        return view('progress.index', compact(
            'courseProgress',
            'activeCourses',
            'completedCourses',
            'totalTime',
            'progressDates',
            'progressData'
        ));
    }
}