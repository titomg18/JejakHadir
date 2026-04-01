<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f9fafc; }
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        .sidebar {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.7);
        }
        .menu-item { transition: all 0.2s; border-radius: 12px; margin: 4px 0; }
        .menu-item:hover { background: rgba(59,130,246,0.08); color: #1e40af; }
        .menu-item.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.12) 0%, rgba(139,92,246,0.12) 100%);
            color: #2563eb; font-weight: 500; border-left: 4px solid #3b82f6;
        }
        .menu-item i { width: 24px; color: #6b7280; }
        .menu-item.active i { color: #3b82f6; }

        /* Tab styling */
        .tab-btn { transition: all 0.2s; }
        .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* Form inputs */
        .form-input {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 10px 14px; font-size: 14px; background: rgba(255,255,255,0.8);
            transition: all 0.2s; outline: none;
        }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }

        /* Toggle switch */
        .toggle-checkbox:checked { right: 0; border-color: #3b82f6; }
        .toggle-checkbox:checked + .toggle-label { background-color: #3b82f6; }
        .toggle-checkbox { right: 4px; transition: all 0.2s; }

        /* Alert */
        .alert-success {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            border: 1px solid #86efac; color: #15803d;
            padding: 12px 16px; border-radius: 12px; font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body class="antialiased">
<div class="flex h-screen overflow-hidden">
    @include('Admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto">
        @include('Admin.partials.navbar')

        <div class="p-6 md:p-8 space-y-6">

            {{-- HEADER --}}
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
                <p class="text-sm text-gray-500 mt-1">Konfigurasi sistem JejakHadir</p>
            </div>

            {{-- TABS --}}
            <div class="flex flex-wrap gap-2">
                <button onclick="showTab('profil')" id="tab-profil"
                    class="tab-btn active inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-school"></i> Profil Sekolah
                </button>
                <button onclick="showTab('jam')" id="tab-jam"
                    class="tab-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-clock"></i> Jam Masuk
                </button>
                <button onclick="showTab('libur')" id="tab-libur"
                    class="tab-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-calendar-times"></i> Hari Libur
                </button>
                <button onclick="showTab('wa')" id="tab-wa"
                    class="tab-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100">
                    <i class="fab fa-whatsapp"></i> Notifikasi WA
                </button>
            </div>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- TAB 1: PROFIL SEKOLAH                              --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div id="content-profil" class="tab-content active space-y-5">

                @if(session('success_profil'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success_profil') }}</div>
                @endif

                <form action="{{ route('admin.pengaturan.profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="glass-card rounded-2xl p-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                                <i class="fas fa-school"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-800">Profil Sekolah</h2>
                                <p class="text-xs text-gray-400">Informasi ini akan tampil di header laporan cetak</p>
                            </div>
                        </div>

                        {{-- Logo --}}
                        <div>
                            <label class="form-label">Logo Sekolah</label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50" id="logoPreview">
                                    @if($settings->get('logo_sekolah'))
                                        <img src="{{ Storage::url($settings->get('logo_sekolah')) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-image text-gray-300 text-2xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="logo_sekolah" id="logoInput" accept="image/*" class="hidden" onchange="previewLogo(this)">
                                    <button type="button" onclick="document.getElementById('logoInput').click()"
                                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium hover:bg-blue-100 transition">
                                        <i class="fas fa-upload mr-1"></i> Upload Logo
                                    </button>
                                    <p class="text-xs text-gray-400 mt-1">PNG/JPG, maks 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Nama Sekolah <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_sekolah" class="form-input" required
                                    value="{{ old('nama_sekolah', $settings->get('nama_sekolah')) }}"
                                    placeholder="SMA Negeri 1">
                                @error('nama_sekolah')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="telp_sekolah" class="form-input"
                                    value="{{ old('telp_sekolah', $settings->get('telp_sekolah')) }}"
                                    placeholder="031-0000000">
                            </div>
                            <div>
                                <label class="form-label">Email Sekolah</label>
                                <input type="email" name="email_sekolah" class="form-input"
                                    value="{{ old('email_sekolah', $settings->get('email_sekolah')) }}"
                                    placeholder="info@sekolah.sch.id">
                            </div>
                            <div>
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat_sekolah" class="form-input"
                                    value="{{ old('alamat_sekolah', $settings->get('alamat_sekolah')) }}"
                                    placeholder="Jl. Pendidikan No. 1">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                                <i class="fas fa-save"></i> Simpan Profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- TAB 2: JAM MASUK                                   --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div id="content-jam" class="tab-content space-y-5">

                @if(session('success_jam'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success_jam') }}</div>
                @endif

                <form action="{{ route('admin.pengaturan.jam') }}" method="POST">
                    @csrf
                    <div class="glass-card rounded-2xl p-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-800">Jam Masuk & Toleransi</h2>
                                <p class="text-xs text-gray-400">Tentukan batas waktu kehadiran siswa</p>
                            </div>
                        </div>

                        {{-- Visualisasi timeline --}}
                        <div class="bg-amber-50/60 rounded-xl p-4">
                            <p class="text-xs font-semibold text-amber-700 mb-3 uppercase tracking-wide">Preview Timeline</p>
                            <div class="relative h-8 flex items-center">
                                <div class="absolute left-0 right-0 h-1.5 bg-gray-200 rounded-full"></div>
                                <div class="absolute left-0 w-1/2 h-1.5 bg-green-400 rounded-full" id="barHadir"></div>
                                <div class="absolute left-1/2 w-[10%] h-1.5 bg-yellow-400 rounded-full" id="barToleransi"></div>
                                <div class="absolute left-0 flex flex-col items-center" style="left: 0%">
                                    <div class="w-3 h-3 rounded-full bg-green-500 mb-1"></div>
                                    <span class="text-xs text-gray-500 whitespace-nowrap" id="labelJamMasuk">{{ $settings->get('jam_masuk', '07:00') }}</span>
                                </div>
                                <div class="absolute flex flex-col items-center" style="left: calc(50% + 10%)">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 mb-1"></div>
                                    <span class="text-xs text-gray-500 whitespace-nowrap">+{{ $settings->get('toleransi_menit', '15') }} mnt</span>
                                </div>
                                <div class="absolute right-0 flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-400 mb-1"></div>
                                    <span class="text-xs text-gray-500" id="labelJamPulang">{{ $settings->get('jam_pulang', '15:00') }}</span>
                                </div>
                            </div>
                            <div class="flex gap-4 mt-3 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><span class="w-3 h-1.5 bg-green-400 rounded inline-block"></span> Tepat waktu</span>
                                <span class="flex items-center gap-1"><span class="w-3 h-1.5 bg-yellow-400 rounded inline-block"></span> Toleransi (terlambat)</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="form-label">Jam Masuk <span class="text-red-500">*</span></label>
                                <input type="time" name="jam_masuk" class="form-input" required
                                    value="{{ $settings->get('jam_masuk', '07:00') }}"
                                    onchange="updateLabel('labelJamMasuk', this.value)">
                                <p class="text-xs text-gray-400 mt-1">Siswa hadir sebelum jam ini = Hadir</p>
                            </div>
                            <div>
                                <label class="form-label">Toleransi Keterlambatan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="toleransi_menit" class="form-input pr-16" min="0" max="60" required
                                        value="{{ $settings->get('toleransi_menit', '15') }}">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">menit</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Setelah toleransi = Terlambat</p>
                            </div>
                            <div>
                                <label class="form-label">Jam Pulang <span class="text-red-500">*</span></label>
                                <input type="time" name="jam_pulang" class="form-input" required
                                    value="{{ $settings->get('jam_pulang', '15:00') }}"
                                    onchange="updateLabel('labelJamPulang', this.value)">
                                <p class="text-xs text-gray-400 mt-1">Informasi jam selesai KBM</p>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                                <i class="fas fa-save"></i> Simpan Pengaturan Jam
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- TAB 3: HARI LIBUR                                  --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div id="content-libur" class="tab-content space-y-5">

                @if(session('success_libur'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success_libur') }}</div>
                @endif

                {{-- Form tambah --}}
                <form action="{{ route('admin.pengaturan.libur.tambah') }}" method="POST">
                    @csrf
                    <div class="glass-card rounded-2xl p-6 space-y-4">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-800">Tambah Hari Libur</h2>
                                <p class="text-xs text-gray-400">Hari libur tidak dihitung sebagai hari efektif di laporan</p>
                            </div>
                        </div>

                        @error('tanggal')<div class="alert-success !bg-red-50 !border-red-200 !text-red-600"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="form-label">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" class="form-input" required value="{{ old('tanggal') }}">
                            </div>
                            <div>
                                <label class="form-label">Keterangan <span class="text-red-500">*</span></label>
                                <input type="text" name="keterangan" class="form-input" required
                                    value="{{ old('keterangan') }}" placeholder="contoh: Hari Raya Idul Fitri">
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-red-500 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-red-600 transition">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Daftar hari libur --}}
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800">Daftar Hari Libur</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $hariLibur->count() }} hari libur terdaftar</p>
                    </div>
                    @if($hariLibur->count() > 0)
                        <div class="divide-y divide-gray-50">
                            @foreach($hariLibur as $libur)
                                <div class="px-6 py-3 flex items-center gap-4 hover:bg-red-50/20 transition">
                                    <div class="w-12 h-12 bg-red-50 rounded-xl flex flex-col items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-bold text-red-600">{{ $libur->tanggal->format('d') }}</span>
                                        <span class="text-xs text-red-400">{{ $libur->tanggal->locale('id')->translatedFormat('M') }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 text-sm">{{ $libur->keterangan }}</p>
                                        <p class="text-xs text-gray-400">{{ $libur->tanggal->locale('id')->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                    <form action="{{ route('admin.pengaturan.libur.hapus', $libur->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus hari libur ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-12 text-center text-gray-400">
                            <i class="fas fa-calendar-check text-3xl mb-2 block text-green-300"></i>
                            <p class="text-sm">Belum ada hari libur yang ditambahkan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- TAB 4: NOTIFIKASI WA                               --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div id="content-wa" class="tab-content space-y-5">

                @if(session('success_wa'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success_wa') }}</div>
                @endif

                <form action="{{ route('admin.pengaturan.wa') }}" method="POST">
                    @csrf
                    <div class="glass-card rounded-2xl p-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-500">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-800">Pengaturan Notifikasi WhatsApp</h2>
                                <p class="text-xs text-gray-400">Konfigurasi pesan yang dikirim otomatis ke orang tua</p>
                            </div>
                        </div>

                        {{-- Toggle aktif/nonaktif --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50/80 rounded-xl">
                            <div>
                                <p class="font-medium text-gray-700 text-sm">Aktifkan Notifikasi WhatsApp</p>
                                <p class="text-xs text-gray-400 mt-0.5">Kirim WA otomatis saat siswa scan absensi</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notif_wa_aktif" class="sr-only peer"
                                    {{ $settings->get('notif_wa_aktif', '1') === '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        {{-- Template pesan --}}
                        <div>
                            <label class="form-label">Template Pesan WA</label>
                            <div class="bg-blue-50/60 rounded-xl p-3 mb-3 text-xs text-blue-700 space-y-1">
                                <p class="font-semibold">📌 Variabel yang tersedia:</p>
                                <div class="grid grid-cols-2 gap-1 mt-1">
                                    <span><code class="bg-white px-1.5 py-0.5 rounded">{nama_murid}</code> → Nama siswa</span>
                                    <span><code class="bg-white px-1.5 py-0.5 rounded">{kelas}</code> → Nama kelas</span>
                                    <span><code class="bg-white px-1.5 py-0.5 rounded">{tanggal}</code> → Tanggal</span>
                                    <span><code class="bg-white px-1.5 py-0.5 rounded">{waktu}</code> → Jam masuk</span>
                                    <span><code class="bg-white px-1.5 py-0.5 rounded">{nama_sekolah}</code> → Nama sekolah</span>
                                </div>
                            </div>
                            <textarea name="notif_wa_template" rows="12" class="form-input font-mono text-xs leading-relaxed"
                                placeholder="Tulis template pesan WA di sini...">{{ old('notif_wa_template', $settings->get('notif_wa_template')) }}</textarea>
                        </div>

                        {{-- Preview --}}
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">📱 Preview Pesan</p>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 max-w-sm">
                                <div class="bg-[#dcf8c6] rounded-xl p-3 text-xs text-gray-700 leading-relaxed whitespace-pre-line">
✅ <strong>Notifikasi Kehadiran {{ $settings->get('nama_sekolah', 'Nama Sekolah') }}</strong>

Assalamu'alaikum Wr. Wb.

👤 <strong>Nama</strong>  : Budi Santoso
🏫 <strong>Kelas</strong> : 1 A
📅 <strong>Tanggal</strong> : {{ now()->locale('id')->translatedFormat('l, d F Y') }}
🕐 <strong>Waktu Masuk</strong> : {{ $settings->get('jam_masuk', '07:00') }} WIB
📋 <strong>Status</strong> : ✅ <strong>HADIR</strong>

Terima kasih atas kepercayaan Bapak/Ibu.
                                </div>
                                <p class="text-right text-xs text-gray-400 mt-2">Sent via fonnte.com</p>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                                <i class="fas fa-save"></i> Simpan Pengaturan WA
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
    function showTab(name) {
        // Sembunyikan semua tab content
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        // Tampilkan tab yang dipilih
        document.getElementById('content-' + name).classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
    }

    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('logoPreview').innerHTML =
                    `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateLabel(id, value) {
        document.getElementById(id).textContent = value;
    }

    // Sidebar toggle
    const sidebar   = document.querySelector('aside');
    const toggleBtn = document.getElementById('sidebarToggle');
    const backdrop  = document.createElement('div');
    backdrop.className = 'fixed inset-0 bg-black/20 backdrop-blur-sm z-20 hidden md:hidden';
    document.body.appendChild(backdrop);
    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    });
    backdrop.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    });

    // Buka tab sesuai flash session
    @if(session('success_jam'))   showTab('jam');   @endif
    @if(session('success_libur')) showTab('libur'); @endif
    @if(session('success_wa'))    showTab('wa');    @endif
</script>
</body>
</html>