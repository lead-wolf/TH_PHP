<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .card-header {
            background: #007bff;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-body {
            padding: 30px;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control, .form-control:focus {
            border-radius: 10px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: background 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="header" style="width: 100%; color: white; text-align: center; margin-bottom: 50px;">
        <?php include 'app/views/components/head.php'; ?>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                ✏ Sửa danh mục
            </div>
            <div class="card-body">
                <div id="error-messages" class="mb-3"></div>
                <form id="edit-category-form" onsubmit="updateCategory(event)">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục:</label>
                        <input type="text" id="name" name="name" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
                <a href="/Category/" class="btn btn-secondary mt-3">Quay lại</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lấy ID từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('id');

        // Fetch thông tin danh mục khi trang tải
        fetch(`http://localhost/api/category/${categoryId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Không tìm thấy danh mục');
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const category = data.data;
                document.getElementById('name').value = category.name;
                document.getElementById('description').value = category.description;
            } else {
                document.getElementById('error-messages').innerHTML = `
                    <div class="alert alert-danger">${data.message}</div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('error-messages').innerHTML = `
                <div class="alert alert-danger">Lỗi: ${error.message}</div>
            `;
        });

        // Hàm cập nhật danh mục
        function updateCategory(event) {
            event.preventDefault();

            const form = document.getElementById('edit-category-form');
            const formData = new FormData(form);
            const data = {
                name: formData.get('name'),
                description: formData.get('description')
            };

            fetch(`http://localhost/api/category/${categoryId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) throw new Error('Cập nhật thất bại');
                return response.json();
            })
            .then(data => {
                const errorMessages = document.getElementById('error-messages');
                if (data.status === 'success') {
                    errorMessages.innerHTML = `
                        <div class="alert alert-success">${data.message}</div>
                    `;
                    setTimeout(() => window.location.href = '/Category/', 2000);
                } else {
                    let errorHtml = '<ul class="text-danger">';
                    for (const [key, value] of Object.entries(data.errors)) {
                        errorHtml += `<li>${value}</li>`;
                    }
                    errorHtml += '</ul>';
                    errorMessages.innerHTML = errorHtml;
                }
            })
            .catch(error => {
                document.getElementById('error-messages').innerHTML = `
                    <div class="alert alert-danger">Lỗi: ${error.message}</div>
                `;
            });
        }
    </script>
</body>
</html>