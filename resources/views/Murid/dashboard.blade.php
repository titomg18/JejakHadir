<!DOCTYPE html>
<html>
<head>
    <title>Murid Dashboard - JejakHadir</title>
</head>
<body>
    <h1>Halaman Murid</h1>
    <p>Selamat datang, {{ Auth::user()->name }} (Murid)</p>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>