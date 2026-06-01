<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Users Test Results' }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size:10px; color:#111; }
        table { width:100%; border-collapse: collapse; margin-bottom:8px; table-layout: fixed; word-wrap: break-word }
        th, td { border:1px solid #ddd; padding:4px 6px; vertical-align:top }
        th { background:#f3f4f6; font-weight:700; font-size:10px }
        thead { display: table-header-group }
        tbody { display: table-row-group }
        .small { font-size:9px; color:#555 }
        .page-break{ page-break-after: always; }
        /* set explicit widths to help layout in landscape */
        th.user-id, td.user-id { width:5% }
        th.name, td.name { width:12% }
        th.email, td.email { width:18% }
        th.gender, td.gender { width:6% }
        th.github, td.github { width:10% }
        th.birth, td.birth { width:8% }
        th.city, td.city { width:12% }
        th.attempt, td.attempt { width:6% }
        th.started, td.started, th.finished, td.finished { width:9% }
        th.pref, td.pref { width:6% }
        th.smallcol, td.smallcol { width:6% }
    </style>
</head>
<body>

    <h3 style="margin-bottom:6px">{{ $title ?? 'Users Test Results' }}</h3>

    <table>
        <thead>
            <tr>
                <th class="user-id">No</th>
                <th class="name">Nama</th>
                <th class="email">Email</th>
                <th class="gender">Jenis Kelamin</th>
                <th class="github">GitHub</th>
                <th class="birth">Tanggal Lahir</th>
                <th class="city">Kota</th>
                <th class="attempt">Percobaan</th>
                <th class="started">Mulai</th>
                <th class="finished">Selesai</th>
                <th class="pref">Preferensi</th>
                <th class="smallcol">Jam Mulai</th>
                <th class="smallcol">Jam Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r['name'] }}</td>
                <td>{{ $r['email'] }}</td>
                <td>{{ $r['gender'] }}</td>
                <td>{{ $r['github_username'] }}</td>
                <td>{{ $r['birth_date'] }}</td>
                <td>{{ $r['city'] }}</td>
                <td>{{ $r['attempts'] }}</td>
                <td>{{ $r['started_at'] }}</td>
                <td>{{ $r['finished_at'] }}</td>
                <td>{{ $r['preferred_study_time'] }}</td>
                <td>{{ $r['study_hour_start'] }}</td>
                <td>{{ $r['study_hour_end'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
