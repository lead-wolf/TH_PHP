<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }
        .banner {
            background: url('https://source.unsplash.com/1600x500/?seafood,market') center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            font-size: 3rem;
            font-weight: bold;
        }
        .product-card {
            border: none;
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }
        .card-body h5 a {
            text-decoration: none;
            color: #ff6600;
            font-weight: bold;
        }
        .card-body h5 a:hover {
            color: #cc5500;
        }
    </style>
</head>
<body>
  <?php include 'app/views/components/header.php'; ?>
    
  <img src="/public/images/slider_1.jpg" alt="Banner" class="img-fluid">

    
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-uppercase">Danh sách sản phẩm</h1>
        <div class="text-end mb-3">
            <a href="/Product/add" class="btn btn-success">Thêm sản phẩm mới</a>
            <a href="/Product/cart" class="btn btn-success">Giỏ hàng</a>
            <a href="/Category/" class="btn btn-success">category manager</a>
        </div>
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card shadow-sm">
                <img src="/public/images/uploads/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="Hình ảnh sản phẩm">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <a href="/Product/show/<?php echo $product->id; ?>">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <p class="text-muted"> <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?> </p>
                        <p class="fw-bold text-danger">Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VNĐ</p>
                        <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="d-flex justify-content-around">
                            <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Sửa</a>
                            <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="fas fa-trash-alt"></i> Xóa</a>
                            <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php include 'app/views/components/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
