<?php include 'app/views/components/head.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>E-Tech shop</title>
    <link rel="icon" href="/favicon.jpg" type="image/jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>
    <!-- Custom CSS -->
    <style>
        .product-card {
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            padding: 20px;
            color: white;
            /* text-align: center; */
            height: 100%;
        }
        .product-card .d-flex {
            gap: 5px;
            position: absolute;
            bottom: 30px;
            justify-self: anchor-center;
        }
        .product-card .btn {
            background-color: #ff4b2b;
            border: none;
            /* margin-bottom: 30px; */
            /* bottom: 10px; */
        }
        .product-card .btn:hover {
            background-color: #ff3a1a;
        }
    </style>
</head>
<body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display success message
        const successMessage = localStorage.getItem('success');
        if (successMessage) {
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${successMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('afterbegin', successAlert);
            localStorage.removeItem('success'); // Clear the message after displaying
        }

        // Display error message
        const errorMessage = localStorage.getItem('error');
        if (errorMessage) {
            const errorAlert = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${errorMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('afterbegin', errorAlert);
            localStorage.removeItem('error'); // Clear the message after displaying
        }
    });
</script>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="product-card p-4" style="background-image: url('https://e-tech.monamedia.net/wp-content/uploads/2023/10/banner-1.jpg');">
                    <p class="text-danger">Mua chỉ với 6,000,000 đ</p>
                    <h2 style="color: black; f </br>ont-weight: 700; </br>">Samsung Galaxy </br> Tab A8</h2>
                    <p style="color: black;">Samsung Galaxy Tab A8 64GB </br> WiFi Grey là máy tính bảng tầm trung</p>
                    <span class="badge bg-warning text-dark">-20% OFF</span>
                    <div class="mt-3">
                        <button class="btn btn-danger">Mua Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="product-card p-4" style="background-image: url('https://e-tech.monamedia.net/wp-content/uploads/2023/10/banner-2.jpg');">
                    <p class="text-warning">Mua ngay chỉ với 4,990,000 đ</p>
                    <h2 style="color: black; font-weight: 700;">Meta Quest 2 256GB</h2>
                    <p style="color: black;">Meta là cái tên mới thay thế Oculus</p>
                    <div class="mt-3">
                        <button class="btn btn-light">Mua Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="product-card p-4" style="background-image: url('https://e-tech.monamedia.net/wp-content/uploads/2023/10/banner-3.jpg');">
                    <p class="text-danger">Hàng mới về</p>
                    <h2 style="color: black; font-weight: 700;">Apple AirPods Max Space Orange</h2>
                    <div class="mt-3">
                        <button class="btn btn-light">Mua Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="product-card p-4" style="background-image: url('https://e-tech.monamedia.net/wp-content/uploads/2023/10/banner-5.jpg');">
                    <p class="text-success">Ưu đãi hấp dẫn</p>
                    <h2 style="color: black; font-weight: 700;">Apple Smart Watch Pro</h2>
                    <p style="color: green;">6,990,000 đ <del>7,990,000 đ</del></p>
                    <div class="mt-3">
                        <button class="btn btn-dark">Mua Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="product-card p-4" style="background-image: url('https://e-tech.monamedia.net/wp-content/uploads/2023/10/banner-4.jpg');">
                    <p class="text-warning">Hàng mới về</p>
                    <h2 style="color: black; font-weight: 700;">Máy ảnh lấy liền Fujifilm</h2>
                    <div class="mt-3">
                        <button class="btn btn-light">Mua Ngay <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="el2-section-title text-center text-lg-start">
                            <!-- <span class="el2-section-subtitle">Khuyến mãi lớn</span> -->
                            <h2 class="fw-semibold">Sản phẩm nổi bật</h2>
                        </div>
                    </div>
        <div class="row" id="product-container">
            
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
    // Define globally accessible functions
    function editProduct(productId) {
        window.location.href = `/Product/edit/?id=${productId}`;
    }

    function deleteProduct(productId) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`http://127.0.0.1/api/product/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Sản phẩm đã được xóa thành công.');
                    fetchProducts(); // Refresh product list
                } else {
                    alert('Không thể xóa sản phẩm. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            });
        }
    }

    function updateCartBadge() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartBadge = document.querySelector('.fa-shopping-cart + .badge');
            if (cartBadge) {
                cartBadge.textContent = totalQuantity;
            }
        }

    function addProduct(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the product already exists in the cart
        const existingProduct = cart.find(item => item.productId === productId);
        if (existingProduct) {
            existingProduct.quantity += 1; 
        } else {
            cart.push({ productId, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        const successAlert = `
            <div class="alert alert-success alert-dismissible fade show" id="alertRm" role="alert">
                Sản phẩm đã được thêm vào giỏ hàng.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        window.location.href = '#';
        updateCartBadge();
        document.body.insertAdjacentHTML('afterbegin', successAlert);

        setTimeout(() => {
            const alert = document.getElementById('alertRm');
            if (alert) alert.remove();
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch products when page loads
        fetchProducts();

        const token = localStorage.getItem('token');
        let isAdmin = false;
        if (token) {
            try {
                const decoded = jwt_decode(token); 
                isAdmin = decoded.data.role === 'admin';
            } catch (error) {
                console.log('Invalid token:', error);
            }
        }

        function fetchProducts() {
            $.ajax({
                url: 'http://127.0.0.1/api/product/',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    displayProducts(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching products:', error);
                    $('#product-container').html('<p class="text-danger">Error loading products</p>');
                }
            });
        }

        function displayProducts(products) {
            let html = '';
            
            products.forEach(product => {
                // Escape HTML special characters
                const escapeHtml = (str) => {
                    return str
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                };

                html += `
                    <div class="col-md-4 mb-4">
                        <div class="card product-card shadow-sm">
                            <img src="/public/images/uploads/${escapeHtml(product.image)}" 
                                 class="card-img-top" 
                                 alt="Hình ảnh sản phẩm">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <a href="/Product/show/?id=${product.id}">
                                        ${escapeHtml(product.name)}
                                    </a>
                                </h5>
                                <p class="text-muted">${escapeHtml(product.description)}</p>
                                <p class="fw-bold text-danger">Giá: ${Number(product.price).toLocaleString('vi-VN')} VNĐ</p>
                                <p><strong>Danh mục:</strong> ${escapeHtml(product.category_name)}</p>
                                <div class="d-flex justify-content-around">
                                    ${isAdmin ? `
                                        <button class="btn btn-warning" onclick="editProduct(${product.id})">
                                           <i class="fas fa-edit"></i> Sửa
                                        </button>
                                        <button class="btn btn-danger" onclick="deleteProduct(${product.id})">
                                           <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    ` : ''}
                                        <button class="btn btn-danger" onclick="addProduct(${product.id})">
                                            <i class="fas fa-edit"></i> Thêm vào giỏ hàng
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#product-container').html(html);
        }

        fetchProducts(); // Fetch products on page load
    });
</script>
</body>
</html>