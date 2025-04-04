<?php include 'app/views/components/head.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa sản phẩm</h1>
        <div id="error-messages" class="mb-3"></div>
        <div id="success-messages" class="mb-3" style="background-color: darkseagreen;"></div>
        <form id="editProductForm" enctype="multipart/form-data" onsubmit="return validateForm(event);">
            <input type="hidden" id="id" name="id" />

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
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*" />
                <div class="mt-3" id="current-image"></div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
        </form>

        <a href="/" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');

        // Fetch dữ liệu sản phẩm và danh mục
        fetch(`http://localhost/api/product/${productId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Không tìm thấy sản phẩm');
            return response.json();
        })
        .then(async data => {
            const categoryName = await getCategory(data.category_id);
            console.log(data);
            console.log(categoryName);
            
            if (data) {
                const product = data;
                const categories = categoryName;

                // Gán dữ liệu vào form
                document.getElementById('id').value = product.id;
                document.getElementById('name').value = product.name;
                document.getElementById('description').value = product.description;
                document.getElementById('price').value = product.price;

                // Gán danh sách danh mục vào select
                const categorySelect = document.getElementById('category_id');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    if (category.id == product.category_id) option.selected = true;
                    categorySelect.appendChild(option);
                });

                // Hiển thị ảnh hiện tại
                document.getElementById('current-image').innerHTML = `
                    <p>Ảnh hiện tại:</p>
                    <img src="/public/images/uploads/${product.image}" alt="Ảnh sản phẩm" class="img-thumbnail" width="200">
                `;
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

        async function getNameCategory(id) {
            try {
                const response = await fetch(`http://localhost/api/category/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.status === 'success' && data.data && data.data.name) {
                    return data.data.name;
                } else {
                    return "chưa phân loại";
                }
            } catch (error) {
                console.error('Lỗi:', error.message);
                return "chưa phân loại";
            }
        }

        async function getCategory(id) {
            try {
                const response = await fetch(`http://localhost/api/category/`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.status === 'success' && data.data) {
                    return data.data
                } else {
                    return [];
                }
            } catch (error) {
                console.error('Lỗi:', error.message);
                return [];
            }
        }

        // Hàm validate form 
        function validateForm(event) {
            event.preventDefault();
            const form = document.getElementById('editProductForm');
            const formData = new FormData(form);
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const price = document.getElementById('price').value;
            const category_id = document.getElementById('category_id').value;

            const data ={
                    name: name,
                    description: description,
                    price: price,
                    category_id: category_id
                };

            console.log(formData.get('image'));
            console.log(formData.get('name'));
            console.log(formData.get('description'));
            console.log(formData.get('price'));
            console.log(formData.get('category_id'));  
            
            // Gửi dữ liệu cập nhật qua API
            fetch(`http://localhost/api/product/${productId}`, {
                method: 'POST',
                headers: {
                    // 'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("data", data);
                
                if (data) {
                    console.log(data);
                    
                    document.getElementById('success-messages').innerHTML = `
                        <div class="alert alert-danger" style="background-color: darkseagreen;">${data.message}</div>
                    `;

                    setTimeout(() => {
                        window.location.href = '/';
                    },3000);
                    
                } else {
                    console.log("data",data);
                    
                    document.getElementById('error-messages').innerHTML = `
                        <div class="alert alert-danger">${data.message}</div>
                    `;
                }
            })
            .catch(error => {
                console.log("error", error);
                
                document.getElementById('error-messages').innerHTML = `
                    <div class="alert alert-danger">Lỗi: ${error.message}</div>
                `;
            });

            return false; 
        }
    </script>
</body>
</html>

<!-- <?php include 'app/views/components/footer.php'; ?> -->
