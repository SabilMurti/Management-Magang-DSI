<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InternHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="card p-8 sm:p-10">
            <!-- Brand -->
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl flex items-center justify-center text-2xl text-white shadow-lg"
                    style="background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%); box-shadow: 0 8px 20px -4px rgba(167,139,250,0.5);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="text-xl font-extrabold text-slate-800 mb-1 tracking-tight">InternHub</h1>
                <p class="text-slate-400 text-sm">Masuk ke akun Anda</p>
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div class="alert alert-error mb-5">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error mb-5">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div class="form-group mb-0">
                    <label class="form-label">Email</label>
                    <div class="search-input">
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com"
                            value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Password</label>
                    <div class="search-input">
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="form-checkbox">
                    <label for="remember" class="text-sm text-slate-500 cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 text-sm">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>
        </div>
    </div>
</body>

</html>
