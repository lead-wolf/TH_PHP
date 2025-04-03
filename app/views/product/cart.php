<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome (nếu cần) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">🛒 Giỏ hàng của bạn</h1>

    <?php if (!empty($cart)): ?>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng cộng</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_price = 0; ?>
                <?php foreach ($cart as $id => $item): ?>
            <?php 
                $subtotal = $item['price'] * $item['quantity']; 
                $total_price += $subtotal; 
            ?>
            <tr>
                <td>
                    <?php if (!empty($item['image'])): ?>
                        <img src="/public/images/uploads/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                            alt="Ảnh sản phẩm" class="img-thumbnail" style="max-width: 80px;">
                    <?php else: ?>
                        <img src="/public/images/no-image.png" alt="Không có ảnh" class="img-thumbnail" style="max-width: 80px;">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo number_format($item['price'], 0, ',', '.') . ' VND'; ?></td>
                <td>
                    <form method="POST" action="/Product/updateCart">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" 
                            min="1" class="form-control form-control-sm d-inline-block w-50">
                        <button type="submit" class="btn btn-sm btn-warning">Cập nhật</button>
                    </form>
                </td>
                <td><?php echo number_format($subtotal, 0, ',', '.') . ' VND'; ?></td>
                <td>
                    <a href="/Product/remove/<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">🗑 Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>

            </tbody>
        </table>

        <h4 class="text-end">💰 Tổng tiền: <strong><?php echo number_format($total_price, 0, ',', '.') . ' VND'; ?></strong></h4>

        <div class="d-flex justify-content-between mt-4">
            <a href="/Product" class="btn btn-secondary">⬅ Tiếp tục mua sắm</a>
            <a href="/Product/clear" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">🗑 Xóa giỏ hàng</a>
            <a href="/Product/checkout" class="btn btn-success">💳 Thanh Toán</a>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            🛒 Giỏ hàng của bạn đang trống. <a href="/Product" class="alert-link">Tiếp tục mua sắm</a>!
        </div>
    <?php endif; ?>
</div>

</body>
<?php include 'app/views/shares/footer.php'; ?>

