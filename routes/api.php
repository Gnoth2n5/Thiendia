<?php

use App\Http\Controllers\HomeController;
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
    $grave = \App\Models\Grave::with('cemetery')->findOrFail($id);

    return response()->json([
        'id' => $grave->id,
        'caretaker_name' => $grave->caretaker_name,
        'deceased_full_name' => $grave->deceased_full_name,
        'birth_year' => $grave->birth_year,
        'rank_and_unit' => $grave->rank_and_unit,
        'position' => $grave->position,
        'deceased_birth_date' => $grave->deceased_birth_date?->format('d/m/Y'),
        'deceased_death_date' => $grave->deceased_death_date?->format('d/m/Y'),
        'certificate_number' => $grave->certificate_number,
        'decision_number' => $grave->decision_number,
        'decision_date' => $grave->decision_date?->format('d/m/Y'),
        'deceased_gender' => $grave->deceased_gender,
        'deceased_relationship' => $grave->deceased_relationship,
        'next_of_kin' => $grave->next_of_kin,
        'deceased_photo' => $grave->deceased_photo ? \Illuminate\Support\Facades\Storage::url($grave->deceased_photo) : null,
        'grave_photos' => $grave->grave_photos ? array_map(fn($photo) => \Illuminate\Support\Facades\Storage::url($photo), $grave->grave_photos) : [],
        'burial_date' => $grave->burial_date?->format('d/m/Y'),
        'grave_type' => $grave->grave_type,
        'grave_type_label' => $grave->grave_type_label,
        'location_description' => $grave->location_description,
        'notes' => $grave->notes,
        'latitude' => $grave->latitude,
        'longitude' => $grave->longitude,
        'contact_info' => $grave->contact_info,
        'cemetery' => [
            'id' => $grave->cemetery->id,
            'name' => $grave->cemetery->name,
            'address' => $grave->cemetery->address,
            'commune' => $grave->cemetery->commune,
            'description' => $grave->cemetery->description,
        ],
    ]);
});
