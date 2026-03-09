<!DOCTYPE html>
<html>
<head>
    <title>Guru Dashboard - JejakHadir</title>
</head>
<body>
    <h1>Halaman Guru</h1>
    <p>Selamat datang, {{ Auth::user()->name }} (Guru)</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>