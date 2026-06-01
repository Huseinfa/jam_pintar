<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // Method untuk menampilkan semua kota
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');

        if ($perPage === 'all') {
            $cities = City::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('regency_code', 'like', "%{$search}%");
            })->get();
        } else {
            $cities = City::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('regency_code', 'like', "%{$search}%");
            })
            ->paginate((int) $perPage)
            ->onEachSide(0);
        }

        return view('pages.backoffice.cities.cities', compact('cities', 'perPage', 'search'));
    }

    public function create()
    {
        return view('pages.backoffice.cities.cities_create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'type' => 'nullable|string',
            'province' => 'nullable|string',
            'regency_code' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ]);

        // Simpan data
        City::create($validatedData);

        // Redirect dengan success message
        return redirect()
            ->route('backoffice.cities')
            ->with('success', 'Kota berhasil ditambahkan!');
    }

    public function show(City $city)
    {
        // Show detail kota
        return view('pages.backoffice.cities.cities_show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('pages.backoffice.cities.cities_edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'nullable|string',
            'province' => 'nullable|string',
            'regency_code' => 'nullable|string',
        ]);

        $city->update($validated);

        return redirect()
            ->route('backoffice.cities')
            ->with('success', 'Kota berhasil diperbarui!');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()
            ->route('backoffice.cities')
            ->with('success', 'Kota berhasil dihapus!');
    }
}
