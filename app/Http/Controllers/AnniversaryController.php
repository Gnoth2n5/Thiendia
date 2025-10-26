<?php

namespace App\Http\Controllers;

use App\Models\Grave;
use App\Models\Tribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LucNham\LunarCalendar\LunarDateTime;

class AnniversaryController extends Controller
{
  /**
   * Display the today's death anniversary page.
   */
  public function index(Request $request)
  {
    // Get graves with death anniversary matching today
    $graves = Grave::with('cemetery')
      ->deathAnniversaryToday()
      ->paginate(20);

    // Get today's lunar date for display
    $todayLunar = LunarDateTime::now();

    // Format for display
    $todayLunarFormatted = [
      'year' => (int) $todayLunar->format('Y'),
      'month' => (int) $todayLunar->format('m'),
      'day' => (int) $todayLunar->format('d'),
    ];

    return view('anniversary-today', [
      'graves' => $graves,
      'todayLunar' => $todayLunarFormatted,
    ]);
  }

  /**
   * Get tribute count for a specific grave today.
   */
  public function getTodayCount(int $graveId): JsonResponse
  {
    $count = Tribute::where('grave_id', $graveId)
      ->whereDate('created_at', today())
      ->count();

    return response()->json([
      'success' => true,
      'count' => $count,
    ]);
  }

  /**
   * AJAX search function for filtering martyrs.
   */
  public function search(Request $request): JsonResponse
  {
    $searchTerm = $request->get('search', '');

    $graves = Grave::with('cemetery')
      ->deathAnniversaryToday()
      ->where(function ($query) use ($searchTerm) {
        $query->where('deceased_full_name', 'like', "%{$searchTerm}%")
          ->orWhere('owner_name', 'like', "%{$searchTerm}%")
          ->orWhereHas('cemetery', function ($q) use ($searchTerm) {
            $q->where('district', 'like', "%{$searchTerm}%")
              ->orWhere('commune', 'like', "%{$searchTerm}%")
              ->orWhere('name', 'like', "%{$searchTerm}%");
          });
      })
      ->get()
      ->map(function ($grave) {
        $lunarDate = $grave->getLunarDate();

        return [
          'id' => $grave->id,
          'deceased_full_name' => $grave->deceased_full_name,
          'hometown' => $grave->cemetery ? ($grave->cemetery->commune . ', ' . $grave->cemetery->district) : '',
          'cemetery_name' => $grave->cemetery ? $grave->cemetery->name : '',
          'death_date' => $grave->deceased_death_date ? $grave->deceased_death_date->format('d/m/Y') : '',
          'lunar_date' => $lunarDate ? sprintf('%02d/%02d', $lunarDate['month'], $lunarDate['day']) : '',
          'tribute_count_today' => $grave->tribute_count_today,
        ];
      });

    return response()->json([
      'success' => true,
      'graves' => $graves,
    ]);
  }
}
