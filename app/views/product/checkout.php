<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Header Example</title> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .navlink {
            color: rgba(var(--bs-link-color-rgb)); /* Giữ màu chữ giống với phần tử cha, không dùng màu xanh mặc định */
            text-decoration: none; /* Loại bỏ gạch chân */
            cursor: default; /* Đặt con trỏ chuột thành mũi tên mặc định */
        }

        /* Nếu bạn muốn thay đổi màu khi hover (tùy chọn) */
        .navlink:hover {
            color: inherit; /* Giữ màu khi hover, hoặc bạn có thể đổi màu khác */
            text-decoration: none; /* Đảm bảo không có gạch chân khi hover */
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0 fw-bold">Thanh toán</h2>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="/Product/processCheckout">
                            <!-- Họ tên -->
                            <div class="form-group mb-4">
                                <label for="name" class="form-label fw-medium">Họ tên:</label>
                                <input type="text" id="name" name="name" class="form-control form-control-lg shadow-sm" required>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="form-group mb-4">
                                <label for="phone" class="form-label fw-medium">Số điện thoại:</label>
                                <input type="text" id="phone" name="phone" class="form-control form-control-lg shadow-sm" required>
                            </div>

                            <!-- Địa chỉ -->
                            <div class="form-group mb-4">
                                <label for="address" class="form-label fw-medium">Địa chỉ:</label>
                                <textarea id="address" name="address" class="form-control form-control-lg shadow-sm" rows="4" required></textarea>
                            </div>

                            <!-- Nút Thanh toán -->
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-medium">
                                    <i class="bi bi-credit-card me-2"></i>Thanh toán
                                </button>
                            </div>
                        </form>

                        <!-- Nút Quay lại -->
                        <div class="text-center mt-4">
                            <a href="/Product/cart" class="btn btn-outline-secondary px-4 py-2 fw-medium">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
<?php include 'app/views/shares/footer.php'; ?>