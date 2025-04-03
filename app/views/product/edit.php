<?php include 'app/views/components/header.php'; ?>

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

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="/Product/update" onsubmit="return validateForm();" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>" />

            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required />
            </div>

            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required />
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*" />
                <div class="mt-3">
                    <p>Ảnh hiện tại:</p>
                    <img src="/public/images/uploads/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="Ảnh sản phẩm" class="img-thumbnail" width="200">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
        </form>

        <a href="/Product/list" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'app/views/components/footer.php'; ?>
