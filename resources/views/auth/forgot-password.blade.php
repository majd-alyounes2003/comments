@extends('layouts.app')

@section('title', 'بازیابی رمز عبور')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-4">
                    <i class="bi bi-key"></i> بازیابی رمز عبور
                </h2>
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-envelope"></i> ارسال لینک بازیابی
                    </button>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">بازگشت به صفحه ورود</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

