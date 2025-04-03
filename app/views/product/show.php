<?php include 'app/views/components/head.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h2 class="mb-0 fw-bold">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body p-4">
            <?php if ($product): ?>
                
                <!-- In tên sản phẩm -->
                <div class="row g-4">
                    <!-- Phần hình ảnh -->
                    <div class="col-md-6">
                        <div class="text-center">
                            <?php if ($product->image): ?>
                                <img src="/public/images/uploads/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                     class="img-fluid rounded shadow-sm" 
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     style="max-height: 400px; object-fit: cover;">
                            <?php else: ?>
                                <img src="/images/no-image.png" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="Không có ảnh"
                                     style="max-height: 400px; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Phần thông tin sản phẩm -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="w-100">
                            <h3 class="card-title text-dark fw-bold mb-3">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <p class="card-text text-muted mb-3">
                                <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                            <p class="text-danger fw-bold fs-3 mb-3">
                                💰 <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                            </p>
                            <p class="mb-4">
                                <strong>Danh mục:</strong>
                                <span class="badge bg-info text-white px-2 py-1">
                                    <?php echo !empty($categories) ?
                                        htmlspecialchars($categories['name'], ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục';
                                    ?>
                                </span>
                            </p>
                            <div class="d-flex gap-2">
                                <a href="/Product/addToCart/<?php echo $product->id; ?>" 
                                   class="btn btn-success px-4 py-2 fw-medium">
                                    <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                                </a>
                                <a href="/Product" 
                                   class="btn btn-outline-secondary px-4 py-2 fw-medium">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center py-4" role="alert">
                    <h4 class="alert-heading mb-0">Không tìm thấy sản phẩm!</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>