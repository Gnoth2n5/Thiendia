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

// API to get grave details
Route::get('/graves/{id}', function ($id) {
    $grave = \App\Models\Grave::with('cemetery')->findOrFail($id);

    return response()->json([
        'id' => $grave->id,
        'grave_number' => $grave->grave_number,
        'owner_name' => $grave->owner_name,
        'grave_type' => $grave->grave_type,
        'grave_type_label' => $grave->grave_type_label,
        'status' => $grave->status,
        'status_label' => $grave->status_label,
        'burial_date' => $grave->burial_date?->format('d/m/Y'),
        'deceased_full_name' => $grave->deceased_full_name,
        'deceased_relationship' => $grave->deceased_relationship,
        'deceased_gender' => $grave->deceased_gender,
        'deceased_birth_date' => $grave->deceased_birth_date?->format('d/m/Y'),
        'deceased_death_date' => $grave->deceased_death_date?->format('d/m/Y'),
        'deceased_photo' => $grave->deceased_photo ? \Storage::url($grave->deceased_photo) : null,
        'grave_photos' => $grave->grave_photos ? array_map(fn ($photo) => \Storage::url($photo), $grave->grave_photos) : [],
        'location_description' => $grave->location_description,
        'notes' => $grave->notes,
        'latitude' => $grave->latitude,
        'longitude' => $grave->longitude,
        'contact_info' => $grave->contact_info,
        'cemetery' => [
            'id' => $grave->cemetery->id,
            'name' => $grave->cemetery->name,
            'address' => $grave->cemetery->address,
            'district' => $grave->cemetery->district,
            'commune' => $grave->cemetery->commune,
            'description' => $grave->cemetery->description,
        ],
    ]);
});
