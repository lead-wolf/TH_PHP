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
    <header class="header">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid justify-content-center" style="font-size: 1.2rem;">
                <div class="">
                    <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 100px;">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-warning text-dark me-2" href="/product">Trang Chủ</a>
                        </li>
                        <?php if (SessionHelper::isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/Product/add">Thêm sản phẩm</a>
                            </li>
                        <?php endif; ?>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/Product/add">Thêm SP</a>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sản Phẩm
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Phổ biến</a></li>
                                <li><a class="dropdown-item" href="#">Điện thoại</a></li>
                                <li><a class="dropdown-item" href="#">Máy tính</a></li>
                                <li><a class="dropdown-item" href="#">Phụ kiện</a></li>
                                <li><a class="dropdown-item" href="#">Tai nghe</a></li>
                                <li><a class="dropdown-item" href="#">Smart Watch</a></li>
                                <li><a class="dropdown-item" href="#">Web Cam</a></li>
                            </ul>
                        </li>
                        <?php if (SessionHelper::isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/Category/">Danh mục</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Liên Hệ</a>
                        </li>
                    </ul>
                </div>
                </div>
                <div style="margin-right: 300px;">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" style="font-size: 2.5rem;" href="/product">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    <span class="logo-text">E-Tech</span>
                  </a>
                </div>
                <div>
                    <!-- Right Side Icons -->
                    <div class="d-flex align-items-center">
                        <a href="#" class="me-3"><i class="fas fa-search"></i></a>
                        <a href="/Product/cart" class="me-3 position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
                            // Kiểm tra xem giỏ hàng có tồn tại trong session không
                            if (isset($_SESSION['cart'])) {
                                $totalQuantity = 0;
                                
                                // Duyệt qua tất cả sản phẩm trong giỏ hàng
                                foreach ($_SESSION['cart'] as $item) {
                                    // Cộng dồn số lượng sản phẩm
                                    $totalQuantity += $item['quantity'];
                                }
                                
                                echo "<span class='badge bg-warning text-dark rounded-circle position-absolute top-0 start-100 translate-middle'>". htmlspecialchars($totalQuantity) ."</span>" ;
                            } else {
                                echo "<span class='badge bg-warning text-dark rounded-circle position-absolute top-0 start-100 translate-middle'>0</span>";
                            }
                            ?>
                            
                        </a>
                        <!-- <a href="#" class="me-3"><i class="fas fa-user"></i></a> -->
                        <?php
                            if (SessionHelper::isLoggedIn()) {
                                echo "<a class='navlink ms-2'><i class='fas fa-user me-2'></i>". htmlspecialchars($_SESSION['username']) . "(" . SessionHelper::getRole() . ")</a>";
                            } else {
                                echo "<a class='nav-link' href='/account/login'>Login</a>";
                            }
                            ?>
                        </a>
                        <?php
                        if (SessionHelper::isLoggedIn()) {
                            echo "<a class='nav-link ms-2' href='/account/logout'>Logout</a>";
                        }
                        ?>
                    </div>
                </div>
                <!-- Toggle button for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Submenu for Categories -->
        <div class="container-fluid bg-light py-2">
            <div class="container">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-fire me-1"></i> Phổ biến</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-mobile-alt me-1"></i> Điện thoại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-laptop me-1"></i> Máy tính</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-headphones me-1"></i> Phụ kiện</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-headphones-alt me-1"></i> Tai nghe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-clock me-1"></i> Smart Watch</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-video me-1"></i> Web Cam</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>