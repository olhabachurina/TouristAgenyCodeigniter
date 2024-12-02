<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn {
            margin-top: 10px;
        }
        .table {
            margin-top: 20px;
        }
        img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }
        footer {
            margin-top: 30px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Admin Panel</h3>
    <div class="d-flex justify-content-end mb-4">
        <a href="<?= base_url('/') ?>" class="btn btn-primary">Back to Home</a>
    </div>

    <!-- Helper Function for Render Table -->
    <?php
    function renderTable($headers, $rows, $deleteAction, $rowFields, $imageField = null) {
        echo '<table class="table table-bordered table-hover">';
        echo '<thead><tr>';
        foreach ($headers as $header) {
            echo "<th>{$header}</th>";
        }
        echo '<th>Actions</th></tr></thead>';
        echo '<tbody>';
        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($rowFields as $field) {
                echo "<td>" . esc($row[$field]) . "</td>";
            }
            if ($imageField) {
                echo '<td><img src="' . base_url('uploads/' . esc($row[$imageField])) . '" alt="Image"></td>';
            }
            echo '<td>';
            echo '<form method="POST" action="' . base_url($deleteAction) . '" class="d-inline">';
            echo '<input type="hidden" name="id" value="' . esc($row['id']) . '">';
            echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
            echo '</form>';
            echo '</td></tr>';
        }
        echo '</tbody></table>';
    }
    ?>

    <!-- Countries Section -->
    <div class="card">
        <div class="card-header">Manage Countries</div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('/admin/add-country') ?>">
                <div class="d-flex mb-3">
                    <input type="text" name="country" class="form-control" placeholder="Add Country" required>
                    <button type="submit" class="btn btn-success ms-2">Add</button>
                </div>
            </form>
            <?php
            renderTable(
                ['ID', 'Country'],
                $countries,
                '/admin/delete-country',
                ['id', 'country']
            );
            ?>
        </div>
    </div>

    <!-- Cities Section -->
    <div class="card">
        <div class="card-header">Manage Cities</div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('/admin/add-city') ?>">
                <div class="mb-3">
                    <select name="country_id" class="form-select" required>
                        <option value="">Select Country</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?= esc($country['id']) ?>"><?= esc($country['country']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex mb-3">
                    <input type="text" name="city" class="form-control" placeholder="Add City" required>
                    <button type="submit" class="btn btn-success ms-2">Add</button>
                </div>
            </form>
            <?php
            renderTable(
                ['ID', 'City', 'Country'],
                $cities,
                '/admin/delete-city',
                ['id', 'city', 'country']
            );
            ?>
        </div>
    </div>

    <!-- Hotels Section -->
    <div class="card">
        <div class="card-header">Manage Hotels</div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('/admin/add-hotel') ?>">
                <div class="mb-3">
                    <select name="city_id" class="form-select" required>
                        <option value="">Select City</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= esc($city['id']) ?>"><?= esc($city['city']) ?> (<?= esc($city['country']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="text" name="hotel" class="form-control mb-3" placeholder="Hotel Name" required>
                <input type="number" name="stars" class="form-control mb-3" placeholder="Stars (1-5)" min="1" max="5" required>
                <input type="number" name="cost" class="form-control mb-3" placeholder="Cost" required>
                <textarea name="info" class="form-control mb-3" placeholder="Hotel Description" rows="3"></textarea>
                <button type="submit" class="btn btn-success">Add Hotel</button>
            </form>
            <?php
            renderTable(
                ['ID', 'Hotel', 'City', 'Country', 'Stars', 'Cost'],
                $hotels,
                '/admin/delete-hotel',
                ['id', 'hotel', 'city', 'country', 'stars', 'cost']
            );
            ?>
        </div>
    </div>

    <!-- Images Section -->
    <div class="card">
        <div class="card-header">Manage Hotel Images</div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('/admin/add-image') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <select name="hotel_id" class="form-select" required>
                        <option value="">Select Hotel</option>
                        <?php foreach ($hotels as $hotel): ?>
                            <option value="<?= esc($hotel['id']) ?>"><?= esc($hotel['hotel']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="file" name="images[]" class="form-control mb-3" multiple required>
                <button type="submit" class="btn btn-success">Upload Images</button>
            </form>
            <?php
            renderTable(
                ['ID', 'Hotel', 'Image'],
                $images,
                '/admin/delete-image',
                ['id', 'hotel'],
                'imagepath'
            );
            ?>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Manage Comments</h3>

        <!-- Display flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">All Comments</div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hotel</th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?= esc($comment['id']) ?></td>
                                <td><?= esc($comment['hotel'] ?? 'N/A') ?></td>
                                <td><?= esc($comment['user']) ?></td>
                                <td><?= esc($comment['comment']) ?></td>
                                <td><?= esc(date('d M Y, H:i', strtotime($comment['created_at']))) ?></td>
                                <td>
                                    <form method="POST" action="<?= base_url('/admin/comments/delete') ?>" class="d-inline">
                                        <input type="hidden" name="id" value="<?= esc($comment['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No comments found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
<footer>
    &copy; <?= date('Y') ?> Travel Agency. All rights reserved.
</footer>
</body>
</html>