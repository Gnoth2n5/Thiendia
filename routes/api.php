<?php

use App\Models\Cemetery;
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

// API to get all districts
Route::get('/districts', function () {
    $locations = config('ninhbinh_locations');
    $districts = array_keys($locations);

    return response()->json($districts);
});

// API to get communes by district
Route::get('/communes', function (Request $request) {
    $district = $request->get('district');

    if (! $district) {
        return response()->json([]);
    }

    $locations = config('ninhbinh_locations');
    $communes = $locations[$district] ?? [];

    return response()->json($communes);
});

// API to get cemeteries (optionally filtered by district and commune)
Route::get('/cemeteries', function (Request $request) {
    $query = Cemetery::query()->withCount('graves');

    if ($district = $request->get('district')) {
        $query->where('district', $district);
    }

    if ($commune = $request->get('commune')) {
        $query->where('commune', $commune);
    }

    $cemeteries = $query->orderBy('name')->get();

    return response()->json($cemeteries->map(function ($cemetery) {
        return [
            'id' => $cemetery->id,
            'name' => $cemetery->name,
            'district' => $cemetery->district,
            'commune' => $cemetery->commune,
            'graves_count' => $cemetery->graves_count,
        ];
    }));
});
