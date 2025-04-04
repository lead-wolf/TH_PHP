<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới danh mục</title>
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
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .card-header {
            background: #007bff;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
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
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            transition: background 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 10px 20px;
            margin-top: 15px;
        }
        .text-danger {
            font-size: 0.9rem;
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
                📂 Thêm mới danh mục
            </div>
            <div class="card-body">
                <div id="error-messages" class="mb-3"></div>
                <form id="add-category-form" onsubmit="addCategory(event)">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục:</label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="Nhập tên danh mục">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Nhập mô tả danh mục"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">💾 Lưu</button>
                </form>
                <a href="/Category/" class="btn btn-secondary">⬅ Quay lại danh sách</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addCategory(event) {
            event.preventDefault(); // Ngăn form submit mặc định

            const form = document.getElementById('add-category-form');
            const formData = new FormData(form);
            const data = {
                name: formData.get('name'),
                description: formData.get('description')
            };            
            console.log(data);
            fetch('http://localhost/api/category', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) throw new Error('Thêm danh mục thất bại');
                return response.json();
            })
            .then(result => {
                console.log(result);
                const errorMessages = document.getElementById('error-messages');
                if (result.status === 'success') {
                    errorMessages.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${result.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    setTimeout(() => window.location.href = '/Category/', 2000); // Chuyển hướng sau 2s
                } else {
                    console.log(result);
                    
                    let errorHtml = '<ul class="text-danger">';
                    for (const [key, value] of Object.entries(result.errors)) {
                        errorHtml += `<li>${value}</li>`;
                    }
                    errorHtml += '</ul>';
                    errorMessages.innerHTML = errorHtml;
                }
            })
            .catch(error => {
                document.getElementById('error-messages').innerHTML = `
                    <div class="alert alert-danger">${error.message}</div>
                `;
            });
        }
    </script>
</body>
</html>