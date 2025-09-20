<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Archery Club KKU</title>
     <!-- Google Fonts & Bootstrap CSS (เหมือนกับหน้า welcome) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Link to your custom CSS file -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
ิ<body class="bg-main"> <!-- ใช้คลาสเดียวกันเพื่อให้ได้พื้นหลังแบบเดียวกัน -->
    <!-- ใช้โครงสร้าง Flexbox เหมือนเดิมเพื่อจัดทุกอย่างให้อยู่กลาง -->
    <main class=" d-flex flex-column justify-content-center align-items-center text-center p-4" >
    <!-- เราจะสร้างกล่องสีขาวขึ้นมาครอบฟอร์ม -->
     <div class="form-container col-11 col-md-8 col-lg-5 text-center">
        <img src="{{ asset('img/LOGO KK AC 3.png') }}" alt="Club Logo"  style="width: 80%; max-width: 520px;">
            <h2 class="mb-4 text-dark">Login</h2>
             <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                        <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                        <div class="mb-3 text-center">
                    <div class="form-check d-inline-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>


                         <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-login btn-lg">
                        {{ __('Login') }}
                    </button>
                     @if (Route::has('password.request'))
                                    <a class="btn btn-link text-center" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif


                </div>

                        
                    </form>
</body>
</html>