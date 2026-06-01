<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Kaliber School</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/Auth.css')
</head>
<body>

    <img class="background-svg" src="{{ asset('images/loginpage/background.png') }}" alt="Background Image">

    <div class="wrapper">
        <!-- ══ LEFT PANEL ══ -->
        <div class="left">
        <div class="logo-wrapper">
            <div class="logo-circle">
                <!-- Replace src with your actual logo path: } -->
                <img class="logo-svg" src="{{ asset('images/loginpage/logo_smk.png') }}" alt="Kaliber School Logo">
            </div>
            <p class="school-name">SMK 5 JEMBER</p>
        </div>
    </div>

    <!-- ══ RIGHT PANEL ══ -->
    <div class="right">
        <div class="card">
            <h1 class="card-title">Login</h1>

            {{-- Session status (e.g. after password reset) --}}
            @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            {{-- General auth error --}}
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">+
                    <div class="input-wrapper">
                        <input
                        type="text"
                        name="login"
                        id="email"
                        placeholder="Email atau Nama Pengguna"
                        value="{{ old('login') }}"
                        autocomplete="email"
                        autofocus
                        class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
                        required
                        >
                        <span class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                    </div>
                    @error('login')
                    <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Password"
                            autocomplete="current-password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Toggle password visibility">
                                <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forgot Password
                    <div class="forgot-row">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                        @else
                        <a href="#">Forgot Password?</a>
                        @endif
                    </div> --}}

                    {{-- Submit --}}
                    <button type="submit" class="btn-login" id="submitBtn">
                        <span class="btn-text">Login</span>
                        <span class="spinner"></span>
                    </button>
                </form>

                {{-- Password Help Info --}}
                <div class="password-help-section">
                    <p class="help-text">Lupa password atau ingin ganti password?</p>
                    <a href="https://wa.me/{{ config('app.admin_whatsapp', '6281939642588') }}?text=Halo%20Admin%2C%20saya%20ingin%20mengubah%20password%20akun%20saya.%20Nama%20%3A%20%5Bisi%20nama%5D%20%0AKelas%20%3A%20%5Bisi%20kelas%5D%20%0AJurusan%20%3A%20%5Bisi%20jurusan%5D%20%0AGuru%20%3A%20%5Bisi%20nama%20guru%5D"
                       target="_blank"
                       class="whatsapp-link"
                       title="Hubungi Admin via WhatsApp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.98 1.429 9.93 9.93 0 003.548 18.276h.006a9.9 9.9 0 004.979-1.429 9.93 9.93 0 00-3.543-18.276z"/>
                        </svg>
                        Hubungi Admin via WhatsApp
                    </a>
                </div>

                {{-- Optional: register link --}}
                {{-- <p class="register-row">Belum punya akun? <a href="#">Hubungi Admin</a></p> --}}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Auth.js') }}"></script>
</body>
</html>
