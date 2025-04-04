<?php include 'app/views/components/head.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm sản phẩm mới</h1>
        <div id="error-messages" class="mb-3"></div>

        <form id="add-product-form" enctype="multipart/form-data" onsubmit="addProduct(event)">
            <div class="form-group mb-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" required />
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required />
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Danh mục:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <!-- Options sẽ được thêm bằng JavaScript -->
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*" required />
            </div>

            <button type="submit" class="btn btn-primary mt-3">Thêm sản phẩm</button>
        </form>

        <a href="/products" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lấy danh sách danh mục khi trang tải
        fetch('http://localhost/api/category', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Không thể lấy danh mục');
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const categorySelect = document.getElementById('category_id');
                data.data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
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

        // Hàm thêm sản phẩm
        function addProduct(event) {
            event.preventDefault(); // Ngăn form submit mặc định

            const form = document.getElementById('add-product-form');
            const formData = new FormData(form);
            const name = document.getElementById('name').value;
            const description =document.getElementById('description').value;
            const price = document.getElementById('price').value;
            const category_id = document.getElementById('category_id').value;
            
            const datafetch = {
                name: name,
                description: description,
                price: price,
                category_id: category_id
            }           

            fetch('http://localhost/api/product', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
                body: JSON.stringify(datafetch) // Gửi FormData để hỗ trợ file upload
            })
            .then(response => {
                if (!response.ok) throw new Error('Thêm sản phẩm thất bại');
                return response.json();
            })
            .then(data => {               
                const errorMessages = document.getElementById('error-messages');
                if (data) {
                    console.log(data);
                    errorMessages.innerHTML = `
                        <div class="alert alert-success">${data.message}</div>
                    `;
                    setTimeout(() => window.location.href = '/', 2000); 
                } else {
                    console.log(data);
                    
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
                    <div class="alert alert-danger">Lỗi: ${error}</div>
                `;
            });
        }
    </script>
</body>
</html>

<!-- <?php include 'app/views/components/footer.php'; ?> -->
