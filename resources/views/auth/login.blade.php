@extends('auth.layouts.main')

@section('contents')

    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="/"><img src="./static/logo.svg" height="36" alt=""></a>
            </div>
            <form class="card card-md" action="{{ route('login') }}" method="post" autocomplete="off">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login to your account</h2>
                    @if (session()->has('loginError'))

                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                    <!-- SVG icon code with class="alert-icon" -->
                                </div>
                                <div>
                                    <h4 class="alert-title">{{ session('loginError') }}</h4>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>

                    @endif

                    @if (session()->has('logoutSuccess'))

                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                    <!-- SVG icon code with class="alert-icon" -->
                                </div>
                                <div>
                                    <h4 class="alert-title">{{ session('logoutSuccess') }}</h4>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>

                    @endif

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Masukkan username anda" name="username" value="{{ old('username') }}" autofocus>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password anda" autocomplete="off" id="password" name="password">
                            <span class="input-group-text" onclick="showPassword()" id="passwordIcon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/eye-off -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="3" y1="3" x2="21" y2="21" />
                                    <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                    <path
                                        d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                                </svg>
                            </span>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div id="caps" class="pt-2 text-secondary" style="display: none"><b><small>Caps Lock is
                                    on!</small></b></div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showPassword() {
            let x = document.getElementById("password");
            let y = document.getElementById("passwordIcon");
            if (x.type === "password") {
                x.type = "text";
                y.innerHTML =
                    '<!-- Download SVG icon from http://tabler-icons.io/i/eye --> <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>';
            } else {
                x.type = "password";
                y.innerHTML =
                    '<!-- Download SVG icon from http://tabler-icons.io/i/eye-off --><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="3" x2="21" y2="21" /><path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" /><path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" /></svg>'
            }
        }

        const el = document.getElementById('password');
        const msg = document.getElementById('caps');

        el.addEventListener('keyup', e => {
            msg.style = e.getModifierState('CapsLock') ?
                'display: block' :
                'display: none';
        });
    </script>

@endsection
