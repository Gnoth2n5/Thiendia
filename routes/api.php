<?php

use App\Http\Controllers\AnniversaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TributeController;
use App\Models\Cemetery;
use App\Models\CemeteryPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// API to get wards (cached from Ninh Binh API)
Route::get('/wards', [HomeController::class, 'getWards']);

// API to get cemeteries (optionally filtered by commune)
Route::get('/cemeteries', function (Request $request) {
  $query = Cemetery::query()->withCount('graves');

  if ($commune = $request->get('commune')) {
    $query->where('commune', $commune);
  }

  $cemeteries = $query->orderBy('name')->get();

  return response()->json($cemeteries->map(function ($cemetery) {
    return [
      'id' => $cemetery->id,
      'name' => $cemetery->name,
      'commune' => $cemetery->commune,
      'graves_count' => $cemetery->graves_count,
    ];
  }));
});

// API to get grave details
Route::get('/graves/{id}', function ($id) {
  $grave = \App\Models\Grave::with('cemetery', 'plot')->findOrFail($id);

  return response()->json([
    'id' => $grave->id,
    'deceased_full_name' => $grave->deceased_full_name,
    'hometown' => $grave->hometown,
    'deceased_birth_date' => $grave->deceased_birth_date?->format('d/m/Y'),
    'enlistment_date' => $grave->enlistment_date?->format('d/m/Y'),
    'deceased_death_date' => $grave->deceased_death_date?->format('d/m/Y'),
    'rank' => $grave->rank,
    'position' => $grave->position,
    'unit' => $grave->unit,
    'deceased_photo' => $grave->deceased_photo ? \Illuminate\Support\Facades\Storage::url($grave->deceased_photo) : null,
    'grave_photos' => $grave->grave_photos ? array_map(fn($photo) => \Illuminate\Support\Facades\Storage::url($photo), $grave->grave_photos) : [],
    'notes' => $grave->notes,
    'plot' => $grave->plot ? [
      'id' => $grave->plot->id,
      'plot_code' => $grave->plot->plot_code,
      'row' => $grave->plot->row,
      'column' => $grave->plot->column,
    ] : null,
    'cemetery' => [
      'id' => $grave->cemetery->id,
      'name' => $grave->cemetery->name,
      'address' => $grave->cemetery->address,
      'commune' => $grave->cemetery->commune,
      'description' => $grave->cemetery->description,
    ],
  ]);
});

// API to get cemetery plots
Route::get('/cemeteries/{id}/plots', function ($id) {
  $cemetery = Cemetery::findOrFail($id);
  $plots = CemeteryPlot::where('cemetery_id', $id)
    ->with('grave:id,plot_id,deceased_full_name,deceased_photo')
    ->orderBy('row')
    ->orderBy('column')
    ->get();

  $dimensions = $cemetery->getGridDimensions();

  return response()->json([
    'cemetery' => [
      'id' => $cemetery->id,
      'name' => $cemetery->name,
      'address' => $cemetery->address,
      'commune' => $cemetery->commune,
    ],
    'grid' => [
      'rows' => $dimensions['rows'],
      'columns' => $dimensions['columns'],
    ],
    'plots' => $plots->map(function ($plot) {
      return [
        'id' => $plot->id,
        'plot_code' => $plot->plot_code,
        'row' => $plot->row,
        'column' => $plot->column,
        'status' => $plot->status,
        'status_label' => $plot->status_label,
        'grave' => $plot->grave ? [
          'id' => $plot->grave->id,
          'deceased_full_name' => $plot->grave->deceased_full_name,
          'deceased_photo' => $plot->grave->deceased_photo ? \Illuminate\Support\Facades\Storage::url($plot->grave->deceased_photo) : null,
        ] : null,
      ];
    }),
  ]);
});

// Tribute API Routes
Route::prefix('tributes')->group(function () {
  // Get tribute count for a grave
  Route::get('/count/{grave}', [TributeController::class, 'count']);

  // Get recent tributes for a grave
  Route::get('/recent/{grave}', [TributeController::class, 'recent']);

  // Check if user has tributed today
  Route::get('/status/{grave}', [TributeController::class, 'checkStatus']);

  // Add a tribute
  Route::post('/add', [TributeController::class, 'store']);
});

// Anniversary API Routes
Route::prefix('anniversary')->group(function () {
  // Get today's tribute count for a grave
  Route::get('/tribute-count/{grave}', [AnniversaryController::class, 'getTodayCount']);

  // Search martyrs
  Route::get('/search', [AnniversaryController::class, 'search']);
});
