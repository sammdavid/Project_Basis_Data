<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - VOIZ FTMM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(107, 33, 168, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(14, 165, 240, 0.03) 0%, transparent 50%);
            z-index: 0;
        }

        .auth-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            background: linear-gradient(135deg, #6B21A8 0%, #7C3AED 50%, #0ea5f0 100%);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .icon-circle i {
            font-size: 2.5rem;
            color: white;
        }

        .auth-header h1 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .auth-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0.5rem 0 0 0;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #7C3AED;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }

        .form-control.with-icon {
            padding-left: 3rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6B21A8, #7C3AED);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(107, 33, 168, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 33, 168, 0.4);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            color: #059669;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(14, 165, 240, 0.05), rgba(59, 130, 246, 0.05));
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            margin: 0;
            color: #0284c7;
            font-size: 0.9rem;
        }

        .link-primary {
            color: #7C3AED;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .link-primary:hover {
            color: #6B21A8;
        }

        .back-to-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }

        .back-to-home a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .back-to-home a:hover {
            transform: translateX(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        @media (max-width: 576px) {
            .auth-body { padding: 2rem 1.5rem; }
            .back-to-home { top: 1rem; left: 1rem; }
        }
    </style>
</head>
<body>
    <div class="back-to-home">
        <a href="{{ route('login.form') }}">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="icon-circle">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h1>Reset Password</h1>
                <p>Buat password baru untuk akun Anda</p>
            </div>

            <div class="auth-body">
                @if(session('success'))
                <div class="alert alert-success mb-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Berhasil!</strong>
                            <p class="mb-0 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                </div>
                @endif

                <div class="info-box">
                    <p><i class="bi bi-info-circle me-2"></i>Masukkan password baru Anda, lalu konfirmasi untuk menyelesaikan reset.</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email"
                                   class="form-control with-icon @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $email) }}"
                                   placeholder="nama@ftmm.unair.ac.id"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password"
                                   class="form-control with-icon @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Minimal 6 karakter"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password"
                                   class="form-control with-icon"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-check2-circle me-2"></i>Reset Password
                    </button>

                    <div class="text-center">
                        <span class="text-muted">Ingat password lama?</span>
                        <a href="{{ route('login.form') }}" class="link-primary ms-1">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
