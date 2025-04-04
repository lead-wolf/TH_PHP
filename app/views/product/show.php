<?php include 'app/views/components/head.php'; ?>

<div class="container mt-5 mb-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2 class="mb-0 fw-bold">Chi tiết sản phẩm</h2>
            </div>
            <div class="card-body p-4" id="product-detail">
                <!-- Nội dung sẽ được thêm bằng JavaScript -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Lấy ID sản phẩm từ URL (ví dụ: /product-detail.html?id=5)
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');

        console.log(productId);
        

        // Gọi API để lấy chi tiết sản phẩm
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
            const productDetail = document.getElementById('product-detail');
            if (data) {
                const product = data;
                const categoryName = await getNameCategory(product.category_id);
                console.log(categoryName);
                productDetail.innerHTML = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <img src="${product.image ? `/public/images/uploads/${product.image}` : '/images/no-image.png'}"
                                     class="img-fluid rounded shadow-sm" 
                                     alt="${product.name}"
                                     style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="w-100">
                                <h3 class="card-title text-dark fw-bold mb-3">${product.name}</h3>
                                <p class="card-text text-muted mb-3">${product.description.replace(/\n/g, '<br>')}</p>
                                <p class="text-danger fw-bold fs-3 mb-3">
                                    💰 ${Number(product.price).toLocaleString('vi-VN')} VND
                                </p>
                                <p class="mb-4">
                                    <strong>Danh mục:</strong>
                                    <span class="badge bg-info text-white px-2 py-1">${categoryName}</span>
                                </p>
                                <div class="d-flex gap-2">
                                    <button onclick="addToCart(${product.id})" class="btn btn-success px-4 py-2 fw-medium">
                                        <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                                    </button>
                                    <a href="/" class="btn btn-outline-secondary px-4 py-2 fw-medium">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                productDetail.innerHTML = `
                    <div class="alert alert-danger text-center py-4" role="alert">
                        <h4 class="alert-heading mb-0">${data.message}</h4>
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('product-detail').innerHTML = `
                <div class="alert alert-danger text-center py-4" role="alert">
                    <h4 class="alert-heading mb-0">Lỗi: ${error.message}</h4>
                </div>
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

        function updateCartBadge() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartBadge = document.querySelector('.fa-shopping-cart + .badge');
            if (cartBadge) {
                cartBadge.textContent = totalQuantity;
            }
        }

        function addToCart(productId) {
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

    </script>

<!-- <?php include 'app/views/shares/footer.php'; ?> -->