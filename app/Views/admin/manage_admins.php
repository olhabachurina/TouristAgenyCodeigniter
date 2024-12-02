<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Administrators</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9e5e5;
            color: #343a40;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            color: #5a5a5a;
            margin-bottom: 30px;
            font-weight: bold;
        }

        form {
            background: linear-gradient(145deg, #ffdee9, #b5e3ff);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }

        form:hover {
            transform: scale(1.02);
        }

        form label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #d9d9d9;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        form input:focus, form select:focus {
            border-color: #007bff;
        }

        .btn {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            transition: all 0.3s;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        table th, table td {
            text-align: center;
            padding: 15px;
        }

        table thead {
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
        }

        table tbody tr {
            transition: background-color 0.3s;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        table img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #ff4d4d;
        }

        .btn-danger:hover {
            background-color: #cc0000;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(255, 77, 77, 0.3);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(40, 167, 69, 0.3);
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Manage Administrators</h1>

    <form action="<?= base_url('admin/update_admin') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="userid" class="form-label">Select User</label>
            <select name="userid" id="userid" class="form-control">
                <?php foreach ($users as $user): ?>
                    <option value="<?= esc($user['id']) ?>"><?= esc($user['login']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="file" class="form-label">Upload Avatar</label>
            <input type="file" name="file" id="file" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Admin</button>
    </form>

    <h2 class="text-center mb-4">Current Administrators</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Email</th>
            <th>Avatar</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['id']) ?></td>
                <td><?= esc($user['login']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td>
                    <img src="<?= esc($user['avatar_path']) ?>" alt="Avatar">
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<a href="<?= base_url('/') ?>" class="btn btn-primary mt-4">Back to Main Page</a>
</body>
</html>