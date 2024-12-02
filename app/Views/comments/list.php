
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center mb-4">Comments</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="card">
                <div class="card-header">
                    <strong><?= esc($comment['hotel']) ?></strong> — <?= esc($comment['user']) ?>
                    <span class="float-end"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></span>
                </div>
                <div class="card-body">
                    <?= esc($comment['comment']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">No comments yet.</div>
    <?php endif; ?>
</div>
</body>
</html>
