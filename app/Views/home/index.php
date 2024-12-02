<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4, #fad0c4);
            font-family: 'Roboto', sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
            animation: gradientBackground 10s ease infinite;
        }

        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        header, footer {
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: headerFooterPop 1s ease-in-out;
        }

        @keyframes headerFooterPop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .user-info {
            font-size: 1rem;
        }

        .auth-buttons input, .auth-buttons button {
            margin: 5px;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .nav-buttons a {
            padding: 12px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            border-radius: 8px;
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .nav-buttons a:hover {
            background: linear-gradient(90deg, #ff7eb3, #ff758c);
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .video-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin: 40px auto;
            width: 80%;
            max-width: 1000px;
        }

        .video-container video {
            width: 100%;
            border-radius: 15px;
        }

        footer {
            margin-top: 30px;
            justify-content: center;
        }

        .greeting {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #ff758c;
            animation: fadeSlideIn 2s ease;
        }

        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Push-уведомления -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        <?php if (session()->getFlashdata('success')): ?>
        toastr.success("<?= session()->getFlashdata('success') ?>", "Success");
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        toastr.error("<?= session()->getFlashdata('error') ?>", "Error");
        <?php endif; ?>
    </script>

    <!-- Шапка -->
    <header>
        <h1>Travel Agency</h1>
        <div class="auth-buttons">
            <?php if (isset($user)): ?>
                <span class="user-info">Welcome back, <?= esc($user['login']) ?>!</span>
                <form method="POST" action="<?= base_url('/logout') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            <?php else: ?>
                <form method="POST" action="<?= base_url('/login') ?>" class="d-inline">
                    <input type="text" name="login" placeholder="Login" class="form-control d-inline-block w-auto" required>
                    <input type="password" name="password" placeholder="Password" class="form-control d-inline-block w-auto" required>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            <?php endif; ?>
        </div>
    </header>

    <!-- Навигация -->
    <div class="nav-buttons">
        <a href="/BestTravelAgency/public/tours">Tours</a>
        <a href="/BestTravelAgency/public/comments">Comments</a>
        <a href="/BestTravelAgency/public/registration">Registration</a>
        <?php if (isset($user) && $user['role'] == 1): ?>
            <a href="/BestTravelAgency/public/admin">Admin Panel</a>
            <a href="<?= base_url('admin/manage_admins') ?>">Private</a>
        <?php endif; ?>
    </div>

    <!-- Видео -->
    <div class="video-container">
        <h2 class="text-center text-secondary">Welcome to our Travel Agency!</h2>
        <video controls autoplay muted loop>
            <source src="/BestTravelAgency/public/videos/summercoming.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<!-- Футер -->
<footer>
    &copy; <?= date('Y') ?> Travel Agency. All rights reserved.
</footer>
</body>
</html>