<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password | SITOBAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #1a5c2a 0%, #2d8a4e 50%, #4caf72 100%);
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .login-card {
            background: white; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%; max-width: 420px; overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #1a5c2a, #2d8a4e);
            padding: 24px 32px 20px;
            text-align: center; color: white;
        }
        .login-header h4 { font-weight: 700; margin: 0; font-size: 1.3rem; }
        .login-body { padding: 32px; }
        .form-control { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: .92rem; transition: all 0.2s ease; }
        .form-control:focus { border-color: #2d8a4e; box-shadow: 0 0 0 3px rgba(45,138,78,.15); }
        .form-label { font-weight: 500; color: #444; font-size: .88rem; }
        .btn-login {
            background: linear-gradient(135deg, #1a5c2a, #2d8a4e);
            color: white; border: none; border-radius: 10px;
            padding: 12px; font-size: .95rem; font-weight: 600; width: 100%;
            transition: all .2s;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,92,42,.35); color: white; }
        
        .alert { border-radius: 10px; font-size: .88rem; padding: 10px 14px; margin-bottom: 16px; border: none; }
        .info-text { font-size: 0.85rem; color: #666; margin-bottom: 20px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h4>RESET PASSWORD</h4>
        </div>
        <div class="login-body">
            <p class="info-text text-center">
                Silakan isi password baru Anda di bawah ini untuk memperbarui akun Anda.
            </p>

            @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-light" value="{{ $email ?? old('email') }}" readonly required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru" required>
                </div>

                <button type="submit" class="btn-login shadow-sm">
                    <i class="bi bi-shield-check me-2"></i>Perbarui Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>
