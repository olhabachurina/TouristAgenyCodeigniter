<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnH2N2kX5fQ2nM+usYpsyslgpE0iJ36CMQ9A8sV/ZzxNDDcMti13d6z9h6qWscRt82bO2HQgw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9e5e5;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #5a5a5a;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding-left: 45px;
        }

        .form-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #007bff;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 1.2rem;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert ul li {
            color: #d9534f;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-user-plus"></i> Register</h1>

    <!-- Сообщения об ошибках -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><i class="fas fa-exclamation-circle"></i> <?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Форма регистрации -->
    <form method="post" action="<?= base_url('/registration') ?>">
        <div class="form-group">
            <i class="fas fa-user form-icon"></i>
            <input type="text" name="login" id="login" class="form-control" placeholder="Login" value="<?= old('login') ?>" required>
        </div>
        <div class="form-group">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group">
            <i class="fas fa-envelope form-icon"></i>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
        </div>
        <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Register</button>
    </form>
</div>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Настройки для Toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Пример отображения приветственного сообщения
    <?php if (session()->getFlashdata('success')): ?>
    toastr.success('<?= session()->getFlashdata('success') ?>', 'Welcome!');
    <?php elseif (session()->getFlashdata('errors')): ?>
    toastr.error('<?= session()->getFlashdata('errors')[0] ?>', 'Error!');
    <?php endif; ?>
</script>
</body>
</html>