<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class BackofficeUserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('perPage', 20);
        $search = $request->get('search');

        // exclude admin accounts from the backoffice user list
        $query = User::where('role', '!=', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount(['testAttempts'])->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('pages.backoffice.users.index', compact('users', 'perPage', 'search'));
    }

    public function show(Request $request, $id)
    {
        $user = User::with(['testAttempts.result.recommendation'])->findOrFail($id);

        if ($request->ajax()) {
            return view('pages.backoffice.users.modal', compact('user'));
        }

        return view('pages.backoffice.users.show', compact('user'));
    }

    public function export(Request $request)
    {
        $users = User::with(['testAttempts.result.recommendation'])
            ->where('role', '!=', 'admin')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_test_results.csv"',
        ];

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            // headers (Indonesian) - no ID column, use sequential No only
            fputcsv($handle, ['No','Nama','Email','Jenis Kelamin','GitHub','Tanggal Lahir','Kota','Percobaan','Mulai','Selesai','Preferensi','Jam Mulai','Jam Selesai']);
            $no = 0;
            foreach ($users as $user) {
                // prepare city name using helper (avoids duplicate type like 'Kabupaten Kabupaten')
                $cityName = $this->getCityNameFromUser($user);

                $birthDateStr = null;
                if (!empty($user->birth_date)) {
                    try {
                        $birthDateStr = "'" . \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d');
                    } catch (\Throwable $e) {
                        $birthDateStr = $user->birth_date;
                    }
                }

                            $attemptsCount = $user->testAttempts->count();
                            $base = [
                                $user->name,
                                $user->email,
                                $user->gender ?? null,
                                $user->github_username ?? null,
                                $birthDateStr,
                                $cityName,
                            ];
                // only export latest attempt per user to avoid duplicate rows
                $attempt = $user->testAttempts->sortByDesc('id')->first();
                if (!$attempt) {
                    $no++;
                    fputcsv($handle, array_merge([$no], $base, [$attemptsCount, '', '', '', '', '', '']));
                    continue;
                }

                $result = $attempt->result;
                $rec = $result?->recommendation;

                $started = null;
                $finished = null;
                if (!empty($attempt->started_at)) {
                    try { $started = "'" . optional($attempt->started_at)->toDateTimeString(); } catch (\Throwable $e) { $started = $attempt->started_at; }
                }
                if (!empty($attempt->finished_at)) {
                    try { $finished = "'" . optional($attempt->finished_at)->toDateTimeString(); } catch (\Throwable $e) { $finished = $attempt->finished_at; }
                }

                $pref = $rec?->preferred_study_time ?? $rec?->prefered_study_time ?? null;
                $study_start = $rec?->study_hour_start ?? null;
                $study_end = $rec?->study_hour_end ?? null;

                // write row: increment counter and write
                $no++;
                fputcsv($handle, array_merge([$no], $base, [$attemptsCount, $started, $finished, $pref, $study_start, $study_end]));
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportUser($id)
    {
        $user = User::with(['testAttempts.result.recommendation'])->findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('backoffice.users')->with('error', 'Export untuk akun admin tidak diperbolehkan.');
        }

        $filename = 'user_' . $user->id . '_test_results.csv';
        // For consistency keep per-user export but include only student results and study time data
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($user) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No','Nama','Email','Jenis Kelamin','GitHub','Tanggal Lahir','Kota','Percobaan','Mulai','Selesai','Preferensi','Jam Mulai','Jam Selesai','Alt Mulai','Alt Selesai']);

            // prepare city name using helper
            $cityName = $this->getCityNameFromUser($user);

            $birthDateStr = null;
            if (!empty($user->birth_date)) {
                try {
                    $birthDateStr = "'" . \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d');
                } catch (\Throwable $e) {
                    $birthDateStr = $user->birth_date;
                }
            }

            $attemptsCount = $user->testAttempts->count();
            $base = [
                $user->name,
                $user->email,
                $user->gender ?? null,
                $user->github_username ?? null,
                $birthDateStr,
                $cityName,
            ];

            // per-user export: latest attempt only
            $attempt = $user->testAttempts->sortByDesc('id')->first();
            $no = 1;
            if (!$attempt) {
                fputcsv($handle, array_merge([$no], $base, [$attemptsCount, '', '', '', '', '', '', '']));
            } else {
                $result = $attempt->result;
                $rec = $result?->recommendation;

                $started = null; $finished = null;
                if (!empty($attempt->started_at)) { try { $started = "'" . optional($attempt->started_at)->toDateTimeString(); } catch (\Throwable $e) { $started = $attempt->started_at; } }
                if (!empty($attempt->finished_at)) { try { $finished = "'" . optional($attempt->finished_at)->toDateTimeString(); } catch (\Throwable $e) { $finished = $attempt->finished_at; } }

                $pref = $rec?->preferred_study_time ?? $rec?->prefered_study_time ?? null;
                $study_start = $rec?->study_hour_start ?? null;
                $study_end = $rec?->study_hour_end ?? null;
                $alt_start = $rec?->alt_study_hour_start ?? null;
                $alt_end = $rec?->alt_study_hour_end ?? null;

                fputcsv($handle, array_merge([$no], $base, [$attemptsCount, $started, $finished, $pref, $study_start, $study_end, $alt_start, $alt_end]));
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export latest attempt result for a user as PDF
     */
    public function exportUserPdf($id)
    {
        $user = User::with(['testAttempts.result.recommendation'])->findOrFail($id);

        // build rows same as CSV for this user
        $rows = [];

        $cityName = $this->getCityNameFromUser($user);
        $birthDateStr = null;
        if (!empty($user->birth_date)) {
            try { $birthDateStr = \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d'); } catch (\Throwable $e) { $birthDateStr = $user->birth_date; }
        }

        // only latest attempt for this user
        $attempt = $user->testAttempts->sortByDesc('id')->first();
        $attemptsCount = $user->testAttempts->count();
        if ($attempt) {
            $res = $attempt->result;
            $rec = $res?->recommendation;
            $rows[] = [
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender ?? null,
                'github_username' => $user->github_username ?? null,
                'birth_date' => $birthDateStr,
                'city' => $cityName,
                'attempts' => $attemptsCount,
                'started_at' => optional($attempt->started_at)->toDateTimeString(),
                'finished_at' => optional($attempt->finished_at)->toDateTimeString(),
                'preferred_study_time' => $rec?->preferred_study_time ?? $rec?->prefered_study_time ?? null,
                'study_hour_start' => $rec?->study_hour_start ?? null,
                'study_hour_end' => $rec?->study_hour_end ?? null,
            ];
        }

        if (empty($rows)) {
            return redirect()->route('backoffice.users.show', $user->id)->with('error', 'Tidak ada hasil untuk diekspor sebagai PDF.');
        }

        $title = 'Data Hasil Tes Pengguna';
        $pdf = Pdf::loadView('pdf.users_results_table', compact('rows','title'));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'user_' . $user->id . '_results.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export all users' latest results into a single multi-page PDF
     */
    public function exportAllPdf()
    {
        $users = User::with(['testAttempts.result.recommendation'])
            ->where('role', '!=', 'admin')
            ->get();

        $rows = [];
        foreach ($users as $user) {
            // prepare city
            $cityName = $this->getCityNameFromUser($user);

            $birthDateStr = null;
            if (!empty($user->birth_date)) {
                try { $birthDateStr = \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d'); } catch (\Throwable $e) { $birthDateStr = $user->birth_date; }
            }

            // only latest attempt per user
            $attempt = $user->testAttempts->sortByDesc('id')->first();
            if (!$attempt) continue;
            $res = $attempt->result;
            $rec = $res?->recommendation;

            $attemptsCount = $user->testAttempts->count();
            $rows[] = [
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender ?? null,
                'github_username' => $user->github_username ?? null,
                'birth_date' => $birthDateStr,
                'city' => $cityName,
                'attempts' => $attemptsCount,
                'started_at' => optional($attempt->started_at)->toDateTimeString(),
                'finished_at' => optional($attempt->finished_at)->toDateTimeString(),
                'preferred_study_time' => $rec?->preferred_study_time ?? $rec?->prefered_study_time ?? null,
                'study_hour_start' => $rec?->study_hour_start ?? null,
                'study_hour_end' => $rec?->study_hour_end ?? null,

            ];
        }

        if (empty($rows)) {
            return redirect()->route('backoffice.users')->with('error', 'Tidak ada hasil untuk diekspor.');
        }

        $title = 'Data Hasil Tes Pengguna';
        $pdf = Pdf::loadView('pdf.users_results_table', compact('rows','title'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('all_users_results.pdf');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.backoffice.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'nullable|string|max:50',
            'github_username' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:50',
            'city' => 'nullable',
            'city_id' => 'nullable|integer|exists:cities,id',
            'birth_date' => 'nullable|date',
        ]);

        // The database now uses `city_id` on users (migration migrated enum to city_id).
        // If the form sends a `city` value (name or id), map it to `city_id` and remove `city`
        if (array_key_exists('city', $data)) {
            $cityInput = $data['city'];
            $cityId = null;
            if (!empty($cityInput)) {
                // numeric -> assume id
                if (is_numeric($cityInput)) {
                    $cityId = (int) $cityInput;
                } else {
                    // try lookup by name (case-insensitive)
                    $cityModel = City::whereRaw('LOWER(name) = ?', [strtolower($cityInput)])->first();
                    if ($cityModel) $cityId = $cityModel->id;
                }
            }
            $data['city_id'] = $cityId;
            unset($data['city']);
        }

        // If a city_id was provided directly (from a select/hidden input), prefer it
        if (array_key_exists('city_id', $data) && !empty($data['city_id'])) {
            $data['city_id'] = (int) $data['city_id'];
        }

        $user->update($data);

        return redirect()->route('backoffice.users')->with('success', 'User diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('backoffice.users')->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $user->delete();

        return redirect()->route('backoffice.users')->with('success', 'User telah dihapus.');
    }

    /**
     * Resolve a displayable city name from a user record.
     * Handles legacy JSON in `city` string, or related City model.
     */
    private function getCityNameFromUser(User $user)
    {
        // prefer JSON/string stored city
        if (!empty($user->city) && is_string($user->city)) {
            try {
                $decoded = json_decode($user->city);
            } catch (\Throwable $e) {
                $decoded = null;
            }
            if ($decoded && (isset($decoded->name) || isset($decoded->type))) {
                    $name = isset($decoded->name) ? trim((string)$decoded->name) : null;
                    $type = isset($decoded->type) ? trim((string)$decoded->type) : null;
                    if (!empty($name)) return $name;
                    if (!empty($type)) return $type;
            }
            return $user->city;
        }

        // try relation
        try {
            if (method_exists($user, 'city')) {
                $cityModel = $user->city()->first();
                if ($cityModel) {
                        $name = trim($cityModel->name ?? '');
                        $type = trim($cityModel->type ?? '');
                        if (!empty($name)) return $name;
                        if (!empty($type)) return $type;
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return null;
    }
}
