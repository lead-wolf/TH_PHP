<?php include 'app/views/components/head.php'; ?>

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
            <tbody id="category-list">
                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch danh sách danh mục khi trang tải
        fetch('http://localhost/api/category', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Không thể lấy danh sách danh mục');
            return response.json();
        })
        .then(data => {
            const categoryList = document.getElementById('category-list');
            if (data.status === 'success') {
                let html = '';
                data.data.forEach(category => {
                    html += `
                        <tr>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>${category.description}</td>
                            <td class="text-center">
                                <a href="/category/edit?id=${category.id}" class="btn btn-sm btn-warning">✏ Sửa</a>
                                <button onclick="deleteCategory(${category.id})" class="btn btn-sm btn-danger">🗑 Xóa</button>
                            </td>
                        </tr>
                    `;
                });
                categoryList.innerHTML = html;
            } else {
                categoryList.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">${data.message}</td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            document.getElementById('category-list').innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger">Lỗi: ${error.message}</td>
                </tr>
            `;
        });

        // Hàm xóa danh mục (giả định có API DELETE)
        function deleteCategory(id) {
            if (!confirm('Bạn có chắc chắn muốn xóa?')) return;

            fetch(`http://localhost/api/category/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Xóa danh mục thất bại');
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Lỗi: ' + error.message);
            });
        }
    </script>
</body>
</html>
