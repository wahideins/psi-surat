<!DOCTYPE html>
<html>
<head>
    <title>Firestore Data</title>
</head>
<body>
    <h1>Data dari Firestore</h1>

    @if(count($users) > 0)
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Umur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['nama'] ?? '-' }}</td>
                        <td>{{ $user['nik'] ?? '-' }}</td>
                        <td>{{ $user['pekerjaan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data ditemukan.</p>
    @endif

</body>
</html>
