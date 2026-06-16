<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | SITOBAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            height: 100vh; /* ⚡ PERBAIKAN: Mengunci tinggi sesuai layar */
            overflow: hidden; /* ⚡ PERBAIKAN: Menghilangkan scroll-bar di monitor laptop */
            background: linear-gradient(135deg, #1a5c2a 0%, #2d8a4e 50%, #4caf72 100%);
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .login-card {
            background: white; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%; max-width: 420px; overflow: hidden; /* ⚡ PREMIUM UX: Mengunci kelengkungan header atas */
        }
        .login-header {
            background: linear-gradient(135deg, #1a5c2a, #2d8a4e);
            padding: 24px 32px 20px; /* ⚡ PERBAIKAN: Mengurangi padding atas-bawah agar ringkas */
            text-align: center; color: white;
        }
        .login-icon { font-size: 2.5rem; margin-bottom: 4px; }
        .login-header h4 { font-weight: 700; margin: 0; font-size: 1.3rem; }
        .login-header p { opacity: .8; margin: 4px 0 0; font-size: .85rem; }
        .login-body { padding: 32px; } /* ⚡ PREMIUM UX: Menyeimbangkan padding luar seluruh isi form */
        .form-control { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: .92rem; transition: all 0.2s ease; }
        .form-control:focus { border-color: #2d8a4e; box-shadow: 0 0 0 3px rgba(45,138,78,.15); }
        .form-label { font-weight: 500; color: #444; font-size: .88rem; }
        .input-group .btn { border-radius: 0 10px 10px 0 !important; border: 1.5px solid #e2e8f0; border-left: none; transition: all 0.2s ease; }
        .input-group .form-control:focus + .btn { border-color: #2d8a4e; }
        .btn-login {
            background: linear-gradient(135deg, #1a5c2a, #2d8a4e);
            color: white; border: none; border-radius: 10px;
            padding: 12px; font-size: .95rem; font-weight: 600; width: 100%;
            transition: all .2s;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,92,42,.35); color: white; }
        .divider { color: #aaa; font-size: .82rem; text-align: center; margin: 18px 0; position: relative; }
        .divider::before, .divider::after { content:''; position:absolute; top:50%; width:38%; height:1px; background:#e5e5e5; }
        .divider::before { left:0; } .divider::after { right:0; }
        
        /* ⚡ REVISI UI/UX RAMAH USER: Mengubah lingkaran menjadi Outline Button yang Informatif & Proporsional */
        .btn-back-website {
            display: inline-flex; align-items: center; justify-content: center;
            border: 1.5px solid #2d8a4e; color: #2d8a4e; background: transparent;
            border-radius: 10px; padding: 10px 20px; font-size: 0.88rem; font-weight: 500;
            text-decoration: none; transition: all 0.2s ease-in-out; width: 100%;
        }
        .btn-back-website:hover {
            background: #2d8a4e; color: white; transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(45, 138, 78, 0.15);
        }
        
        .alert { border-radius: 10px; font-size: .88rem; padding: 10px 14px; margin-bottom: 16px; border: none; }
        .info-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 14px; font-size: .82rem; color: #166534; margin-bottom: 20px; line-height: 1.5; }
        .forgot-link { font-size: .85rem; color: #2d8a4e; text-decoration: none; transition: .2s; font-weight: 500; }
        .forgot-link:hover { color: #1a5c2a; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h4>LOGIN</h4>
        </div>
        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif



            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="passInput" placeholder="Masukkan password" required>
                        <button type="button" class="btn btn-outline-secondary bg-white" onclick="togglePass()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)" class="forgot-link" onclick="alert('Lupa password? \n\nSilakan hubungi Administrator IT Kebun Raya Universitas Pahlawan untuk mereset password akun Anda.')">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn-login shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            
            {{-- ⚡ REVISI UI/UX: Tombol kembali menggunakan kombinasi ikon & teks penjelas yang ramah pengguna --}}

        </div>
    </div>

    <script>
    function togglePass() {
        const inp = document.getElementById('passInput');
        const ico = document.getElementById('eyeIcon');
        if (inp.type === 'password') { 
            inp.type = 'text'; 
            ico.className = 'bi bi-eye-slash'; 
        } else { 
            inp.type = 'password'; 
            ico.className = 'bi bi-eye'; 
        }
    }
    </script>
</body>
</html>