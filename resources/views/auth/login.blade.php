@php
    $activePanel = $errors->any() ? ($errors->has('login') ? 'login' : 'register') : ($mode ?? 'login');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activePanel === 'register' ? 'Register' : 'Login' }}</title>
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
</head>
<body class="{{ $activePanel === 'register' ? 'bg-register' : '' }}">

<div class="login-container">
    <div class="login-form-section">

        {{-- Login Panel --}}
        <div class="auth-panel {{ $activePanel === 'login' ? '' : 'is-hidden' }}" id="loginPanel">
            <div class="login-header">
                <h1>Login</h1>
            </div>

            @if ($errors->any() && $activePanel === 'login')
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="login">
                        <span>Username or E-mail</span>
                    </label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        placeholder="Enter your username or e-mail"
                        value="{{ old('login') }}"
                        required
                    >
                </div>

                <div class="form-group" style="margin-bottom: 3em;">
                    <label for="password">
                        <span>Password</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="#" onclick="switchPanel('register'); return false;">Register here</a>
            </div>
        </div>

        {{-- Register Panel --}}
        <div class="auth-panel {{ $activePanel === 'register' ? '' : 'is-hidden' }}" id="registerPanel">
            <div class="login-header">
                <h1>Create Account</h1>
            </div>

            @if ($errors->any() && $activePanel === 'register')
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="username">
                        <span>Username</span>
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
                        value="{{ old('username') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">
                        <span>E-mail</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your e-mail"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="reg_password">
                        <span>Password</span>
                    </label>
                    <input
                        type="password"
                        id="reg_password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <div class="form-group" style="margin-bottom: 3em;">
                    <label for="password_confirmation">
                        <span>Confirm Password</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        required
                    >
                </div>

                <button type="submit" class="login-btn">Register</button>
            </form>

            <div class="register-link">
                Already have an account? <a href="#" onclick="switchPanel('login'); return false;">Login here</a>
            </div>
        </div>

    </div>
</div>

<script>
    function switchPanel(to) {
        const loginPanel    = document.getElementById('loginPanel');
        const registerPanel = document.getElementById('registerPanel');
        const outPanel = to === 'register' ? loginPanel : registerPanel;
        const inPanel  = to === 'register' ? registerPanel : loginPanel;

        outPanel.classList.add('is-sliding-out');

        if (to === 'register') {
            document.body.classList.add('bg-register');
        } else {
            document.body.classList.remove('bg-register');
        }

        setTimeout(() => {
            outPanel.classList.add('is-hidden');
            outPanel.classList.remove('is-sliding-out');
            inPanel.classList.remove('is-hidden');
            inPanel.classList.add('is-sliding-in');
            setTimeout(() => inPanel.classList.remove('is-sliding-in'), 400);
        }, 280);

        document.title = to === 'register' ? 'Register' : 'Login';
    }
</script>

</body>
</html>
