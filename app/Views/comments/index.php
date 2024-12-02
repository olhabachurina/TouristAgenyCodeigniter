<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9e5e5;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        h3 {
            color: #5a5a5a;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
        }
        textarea {
            height: 150px;
            resize: none;
        }
        button[type="submit"] {
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
            border: none;
            font-weight: bold;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 20px rgba(255, 117, 140, 0.4);
        }
        button[type="submit"]:hover {
            background: linear-gradient(90deg, #ff7eb3, #ff758c);
            box-shadow: 0px 8px 30px rgba(255, 117, 140, 0.6);
            transform: scale(1.05);
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Добавить комментарий</h3>

    <!-- Пуш-уведомления -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
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

        <?php if (session()->getFlashdata('success')): ?>
        toastr.success("<?= session()->getFlashdata('success') ?>", "Спасибо!");
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        toastr.error("<?= session()->getFlashdata('error') ?>", "Ошибка!");
        <?php endif; ?>
    </script>

    <!-- Форма добавления комментария -->
    <form action="<?= base_url('/comments/add') ?>" method="post">
        <div class="mb-3">
            <label for="hotel" class="form-label">Выберите отель:</label>
            <select name="hotel_id" id="hotel" class="form-select" required>
                <option value="">-- Выберите отель --</option>
                <?php foreach ($hotels as $hotel): ?>
                    <option value="<?= esc($hotel['id']) ?>"><?= esc($hotel['hotel']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Ваш комментарий:</label>
            <textarea name="comment" id="comment" class="form-control" placeholder="Напишите ваш комментарий" required></textarea>
        </div>
        <button type="submit" class="btn">Отправить</button>
    </form>
</div>
</body>
</html>