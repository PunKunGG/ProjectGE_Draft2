<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register Archery Club KKU</title>
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
        <h2 class="mb-4 text-dark">Create an account</h2>
        <!-- นี่คือโค้ดฟอร์มเดิมจากไฟล์ register.blade.php -->
          <form method="POST" action="{{ route('register') }}" class="text-start">
                @csrf

                <!-- โครงสร้างฟอร์มแบบใหม่ที่เรียบง่าย -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="studentId" class="form-label">{{__('Student ID')}}</label>
                    <input id="studentId" type="text"  class="form-control @error('studentId') is-invalid @enderror" name="studentId" value="{{ old('studentId') }}" required autocomplete="off" autofocus>
                    @error('studentId')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{__('Student Phone')}}</label>
                    <input id="phone" type="text"  class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="off" autofocus>
                    @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

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

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- โครงสร้างปุ่มแบบใหม่ -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-register btn-lg">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Already have an account? Sign In</a>
                </div>
            </form>
     </div>

    </main>
</body>
</html>