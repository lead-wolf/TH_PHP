<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách danh mục</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center my-4">📂 Danh sách danh mục</h1>

    <div class="d-flex justify-content-between mb-3">
        <h4>📝 Quản lý danh mục</h4>
        <a href="/Category/create" class="btn btn-primary">
            ➕ Thêm mới danh mục
        </a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                    <td class="text-center">
                        <a href="/Category/edit/<?php echo $category['id']; ?>" class="btn btn-sm btn-warning">✏ Sửa</a>
                        <a href="/Category/delete/<?php echo $category['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa?');">🗑 Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS (Optional: chỉ cần nếu bạn dùng modal hoặc các component JS của Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
