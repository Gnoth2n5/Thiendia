<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTributeRequest;
use App\Models\Grave;
use App\Models\Tribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TributeController extends Controller
{
  /**
   * Store a new tribute for a grave.
   */
  public function store(StoreTributeRequest $request): JsonResponse
  {
    $graveId = $request->validated()['grave_id'];
    $userIp = $request->ip();

    // Check rate limiting: 1 tribute per IP per grave per day
    if (Tribute::hasTributedToday($graveId, $userIp)) {
      return response()->json([
        'success' => false,
        'message' => 'Bạn đã thắp hương cho liệt sĩ này hôm nay',
        'error_code' => 'RATE_LIMITED',
      ], 429);
    }

    // Create the tribute
    $tribute = Tribute::create([
      'grave_id' => $graveId,
      'name' => $request->validated()['name'],
      'message' => $request->validated()['message'],
      'user_ip' => $userIp,
    ]);

    // Get updated tribute count and recent tributes
    $tributeCount = Tribute::where('grave_id', $graveId)->count();
    $recentTributes = Tribute::where('grave_id', $graveId)
      ->recent(5)
      ->get()
      ->map(function ($tribute) {
        return [
          'id' => $tribute->id,
          'display_name' => $tribute->display_name,
          'message' => $tribute->message,
          'formatted_date' => $tribute->formatted_date,
        ];
      });

    return response()->json([
      'success' => true,
      'message' => 'Cảm ơn bạn đã thắp hương tưởng nhớ',
      'tribute_count' => $tributeCount,
      'recent_tributes' => $recentTributes,
      'tribute' => [
        'id' => $tribute->id,
        'display_name' => $tribute->display_name,
        'message' => $tribute->message,
        'formatted_date' => $tribute->formatted_date,
      ],
    ]);
  }

  /**
   * Get recent tributes for a specific grave.
   */
  public function recent(Request $request, int $graveId): JsonResponse
  {
    // Validate that the grave exists
    $grave = Grave::find($graveId);
    if (!$grave) {
      return response()->json([
        'success' => false,
        'message' => 'Lăng mộ không tồn tại',
      ], 404);
    }

    $tributes = Tribute::where('grave_id', $graveId)
      ->recent(5)
      ->get()
      ->map(function ($tribute) {
        return [
          'id' => $tribute->id,
          'display_name' => $tribute->display_name,
          'message' => $tribute->message,
          'formatted_date' => $tribute->formatted_date,
        ];
      });

    return response()->json([
      'success' => true,
      'tributes' => $tributes,
    ]);
  }

  /**
   * Get tribute count for a specific grave.
   */
  public function count(int $graveId): JsonResponse
  {
    // Validate that the grave exists
    $grave = Grave::find($graveId);
    if (!$grave) {
      return response()->json([
        'success' => false,
        'message' => 'Lăng mộ không tồn tại',
      ], 404);
    }

    $count = Tribute::where('grave_id', $graveId)->count();

    return response()->json([
      'success' => true,
      'count' => $count,
    ]);
  }

  /**
   * Check if user has already tributed today for a specific grave.
   */
  public function checkStatus(Request $request, int $graveId): JsonResponse
  {
    $userIp = $request->ip();
    $hasTributed = Tribute::hasTributedToday($graveId, $userIp);

    return response()->json([
      'success' => true,
      'has_tributed_today' => $hasTributed,
    ]);
  }
}
