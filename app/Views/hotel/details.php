<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($hotel['hotel'] ?? 'Hotel Details') ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9e5e5;
            color: #343a40;
            margin: 0;
            padding: 0;
        }
        h2 {
            font-size: 2.5rem;
            color: #5a5a5a;
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .price-stars {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.25rem;
            margin-bottom: 20px;
        }
        .price-stars .stars img {
            width: 24px;
            height: 24px;
        }
        .price-stars .badge {
            font-size: 1.5rem;
            background-color: #ff5757;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .slider-container {
            position: relative;
            flex: 1;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .slider-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .slider-container img.active {
            opacity: 1;
        }
        .info-block {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .comments-section {
            margin-top: 50px;
        }
        .comments-section h3 {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            background-color: #fff5f5;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            display: block;
            margin: 30px auto;
            font-size: 1.25rem;
            padding: 10px 20px;
            border-radius: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            transition: all 0.3s ease-in-out;
        }
        .btn-back:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
            .price-stars {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
        .comments-section {
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .comments-section h3 {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            background-color: #fff5f5;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .card-body {
            padding: 20px;
            text-align: left;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .text-muted {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Заголовок отеля -->
    <h2><?= esc($hotel['hotel'] ?? 'Hotel Details') ?></h2>
    <div class="price-stars">
        <div class="stars">
            <?php for ($i = 0; $i < ($hotel['stars'] ?? 0); $i++): ?>
                <img src="<?= base_url('uploads/images/star.png') ?>" alt="Star">
            <?php endfor; ?>
        </div>
        <span class="badge"><?= esc($hotel['cost'] ?? 'N/A') ?> Евро</span>
    </div>

    <!-- Слайдер и описание -->
    <div class="row">
        <div class="slider-container" id="slider">
            <?php foreach ($images as $image): ?>
                <img src="<?= base_url('uploads/' . $image['imagepath']) ?>" alt="Hotel Image">
            <?php endforeach; ?>
        </div>
        <div class="info-block">
            <?= nl2br(esc($hotel['info'] ?? 'No description available.')) ?>
        </div>
    </div>

    <!-- Секция комментариев -->
    <div class="comments-section">
        <h3>Comments</h3>
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($comment['username'] ?? 'Anonymous') ?></h5>
                        <p class="card-text"><?= nl2br(esc($comment['comment'])) ?></p>
                        <p class="text-muted small">Posted on: <?= esc(date('d M Y, H:i', strtotime($comment['created_at']))) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </div>

    <!-- Кнопка возврата -->
    <a href="<?= base_url('/') ?>" class="btn btn-back">Back to Main Page</a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slider = document.getElementById('slider');
        const images = slider.querySelectorAll('img');
        let currentIndex = 0;

        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }

        if (images.length > 0) {
            images[currentIndex].classList.add('active');
            setInterval(showNextImage, 3000);
        }
    });
</script>
</body>
</html>