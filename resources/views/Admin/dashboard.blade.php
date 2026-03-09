<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - JejakHadir</title>
</head>
<body>
    <h1>Halaman Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }} (Admin)</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>