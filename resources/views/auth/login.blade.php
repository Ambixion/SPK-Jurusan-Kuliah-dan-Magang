<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Kaliber School</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/Auth.css') }}">
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
                        type="email"
                        name="email"
                        id="email"
                        placeholder="email@school.kaliber.ac.id"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                        >
                        <span class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                    </div>
                    @error('email')
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
                        placeholder="password"
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

                {{-- Optional: register link --}}
                {{-- <p class="register-row">Belum punya akun? <a href="#">Hubungi Admin</a></p> --}}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Auth.js') }}"></script>
</body>
</html>
