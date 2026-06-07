<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class getRekomendasiController extends Controller
{
    public function getRekomendasi(Request $request)
    {
        $request->validate([
            'study_hours'    => 'required|numeric|min:0|max:40',
            'organization'   => 'required|integer|min:1|max:5',
            'procrastination'=> 'required|integer|min:1|max:5',
            'uses_study_aids'=> 'required|boolean',
            'study_location' => 'required|string',
            'study_method'   => 'required|string',
        ]);

        $payload = [
            'study_hours_weekly'    => $request->study_hours,
            'organization_level'    => $request->organization,
            'procrastination_level' => $request->procrastination,
            'uses_study_aids'       => $request->uses_study_aids ? 1 : 0,
            'study_location'        => $request->study_location,
            'study_method'          => $request->study_method,
        ];

        $response = Http::post(config('services.flask_api.url') . '/recommend', $payload);
        $hasil    = $response->json();

        return view('pages.student.rekomendasi', ['hasil' => $hasil]);
    }

    public function store(Request $request)
{
    $payload = [
        // existing fields
        'study_hours_weekly'    => $request->input('study_hours_weekly'),
        'organization_level'    => $request->input('organization_level'),
        'procrastination_level' => $request->input('procrastination_level'),
        'uses_study_aids'       => $request->input('uses_study_aids'),
        'study_location'        => $request->input('study_location'),
        'study_method'          => $request->input('study_method'),

        // new fields
        'github_username'       => $request->input('github_username', ''),
        'usual_study_hour'      => $request->input('usual_study_hour'),
    ];

    $response = Http::post(config('services.flask_api.url') . '/recommend', $payload);
    $result   = $response->json();

    return view('rekomendasi', [
        'recommendation' => $result['recommendation'],
        'scores'         => $result['scores'],
        'boost_source'   => $result['boost_source'],
        'boost_slot'     => $result['boost_slot'],
    ]);
}
}
