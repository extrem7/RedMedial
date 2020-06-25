@extends('admin::layouts.master')

@section('main')
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="Email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @include('admin::includes.field-error',['error'=>'email'])
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password" placeholder="Password">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @include('admin::includes.field-error',['error'=>'password'])
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-outline-primary btn-block">Log in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .login-page {
            background-image: url('/admin/img/login-{{random_int(1,4)}}.jpg') !important;
        }
    </style>
@endpush

