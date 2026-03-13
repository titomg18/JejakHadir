<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | JejakHadir</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom styles for advanced effects -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Animated gradient background */
        body {
            background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            position: relative;
            overflow-x: hidden;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating shapes */
        .shape {
            position: absolute;
            filter: blur(60px);
            opacity: 0.4;
            border-radius: 50%;
            z-index: 0;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: #ff7b89;
            top: -100px;
            left: -100px;
            animation: float 8s infinite alternate;
        }
        
        .shape-2 {
            width: 400px;
            height: 400px;
            background: #7b92ff;
            bottom: -150px;
            right: -100px;
            animation: float 10s infinite alternate-reverse;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            background: #47ebff;
            top: 50%;
            left: 20%;
            animation: float 12s infinite alternate;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 30px) scale(1.1); }
        }
        
        /* Card entrance animation */
        .card {
            animation: cardFloat 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        @keyframes cardFloat {
            0% { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        /* Input focus effect */
        .input-focus-effect:focus-within {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }
        
        /* QR Code hover animation */
        .qr-icon {
            transition: all 0.5s ease;
        }
        
        .qr-icon:hover {
            transform: rotate(10deg) scale(1.1);
        }
        
        /* Button shine effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.6s;
        }
        
        .btn-shine:hover::after {
            left: 100%;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 relative">

    <!-- Floating decorative shapes - disembunyikan di mobile, ditampilkan di tablet/desktop -->
    <div class="shape shape-1 hidden md:block"></div>
    <div class="shape shape-2 hidden md:block"></div>
    <div class="shape shape-3 hidden lg:block"></div>

    <!-- Main card dengan padding responsif -->
    <div class="card relative z-10 w-full max-w-md p-5 sm:p-6 md:p-8 rounded-3xl shadow-2xl">
        
        <!-- Logo and brand section -->
        <div class="text-center mb-6">
            <div class="flex justify-center mb-4">
                <div class="qr-icon w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl sm:rounded-3xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-qrcode text-white text-2xl sm:text-4xl"></i>
                </div>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                JejakHadir
            </h1>
            <p class="text-gray-600 mt-1 text-xs sm:text-sm font-medium">Presensi pintar dengan QR Code</p>
        </div>

        <!-- Welcome back message -->
        <div class="mb-6 sm:mb-8 text-center">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-gray-500 text-xs sm:text-sm mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <!-- Login form -->
        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <!-- Email field with icon -->
            <div class="mb-4 sm:mb-5">
                <label for="email" class="block text-gray-700 text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Email</label>
                <div class="relative input-focus-effect rounded-xl border border-gray-300 bg-white/50 transition-all">
                    <span class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center text-gray-400">
                        <i class="fas fa-envelope text-sm sm:text-base"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@sekolah.ac.id"
                           class="w-full pl-9 sm:pl-11 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-transparent rounded-xl focus:outline-none text-sm sm:text-base">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs sm:text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Password field with icon -->
            <div class="mb-5 sm:mb-6">
                <label for="password" class="block text-gray-700 text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Kata Sandi</label>
                <div class="relative input-focus-effect rounded-xl border border-gray-300 bg-white/50 transition-all">
                    <span class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center text-gray-400">
                        <i class="fas fa-lock text-sm sm:text-base"></i>
                    </span>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••"
                           class="w-full pl-9 sm:pl-11 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-transparent rounded-xl focus:outline-none text-sm sm:text-base">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs sm:text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember me and forgot password -->
            <div class="flex flex-col xs:flex-row items-start xs:items-center justify-between gap-2 xs:gap-0 mb-6 sm:mb-8">
                <label class="flex items-center text-xs sm:text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-500 focus:ring-blue-400 mr-2 w-4 h-4 sm:w-auto sm:h-auto">
                    Ingat saya
                </label>
                <a href="#" class="text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline transition">
                    Lupa password?
                </a>
            </div>

            <!-- Login button with shine effect -->
            <button type="submit"
                    class="btn-shine w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-2.5 sm:py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
            </button>
        </form>

        <!-- Additional info: demo or registration hint -->
        <div class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-gray-500">
            <p>Belum punya akun? <a href="#" class="text-blue-600 font-semibold hover:underline">Hubungi administrator</a></p>
            <p class="mt-2 text-xs opacity-75">© 2025 JejakHadir. All rights reserved.</p>
        </div>

        <!-- QR Code decoration subtle - diperkecil di mobile -->
        <div class="absolute -bottom-4 -right-4 opacity-10 pointer-events-none">
            <i class="fas fa-qrcode text-7xl sm:text-9xl text-gray-800"></i>
        </div>
    </div>
</body>
</html>