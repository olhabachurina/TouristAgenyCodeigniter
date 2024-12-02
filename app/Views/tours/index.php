<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9e5e5;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #5a5a5a;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
            color: #4a4a4a;
        }
        select.form-select {
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .btn {
            border-radius: 10px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .btn:hover {
            transform: scale(1.05);
            background-color: #007bff !important;
            color: #fff !important;
        }
        #hotels {
            margin-top: 40px;
        }
        #hotels h4 {
            color: #007bff;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
            font-size: 1rem;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-info {
            background-color: #5bc0de;
            color: #fff;
            font-size: 0.9rem;
            padding: 5px 10px;
        }
        .btn-info:hover {
            background-color: #31b0d5;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Select Tours</h2>
    <hr>

    <!-- Country Selection -->
    <form method="GET" action="">
        <div class="mb-3">
            <label for="country" class="form-label">Select Country:</label>
            <select id="country" name="country" class="form-select" onchange="this.form.submit()">
                <option value="0">-- Select Country --</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= esc($country['id']) ?>" <?= ($selectedCountryId == $country['id']) ? 'selected' : '' ?>>
                        <?= esc($country['country']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- City Selection -->
        <?php if (!empty($cities)): ?>
            <div class="mb-3">
                <label for="city" class="form-label">Select City:</label>
                <select id="city" name="city" class="form-select" onchange="this.form.submit()">
                    <option value="0">-- Select City --</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= esc($city['id']) ?>" <?= ($selectedCityId == $city['id']) ? 'selected' : '' ?>>
                            <?= esc($city['city']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
    </form>

    <!-- Hotels -->
    <?php if (!empty($hotels)): ?>
        <div id="hotels" class="mt-4">
            <h4>Hotels</h4>
            <div id="hotels-list">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Price</th>
                        <th>Stars</th>
                        <th>Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($hotels as $hotel): ?>
                        <tr>
                            <td><?= esc($hotel['hotel']) ?></td>
                            <td><?= esc($hotel['country']) ?></td>
                            <td><?= esc($hotel['city']) ?></td>
                            <td>$<?= esc($hotel['cost']) ?></td>
                            <td><?= str_repeat('⭐', esc($hotel['stars'])) ?></td>
                            <td><a href="<?= base_url('hotel/' . $hotel['id']) ?>" class="btn btn-info btn-sm">More Info</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>