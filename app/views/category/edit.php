<h1>Sửa danh mục</h1>
<form action="/category/update/<?php echo $category['id']; ?>" method="POST">
    <label for="name">Tên danh mục:</label>
    <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" required>
    <br>
    <label for="description">Mô tả:</label>
    <textarea id="description" name="description"><?php echo $category['description']; ?></textarea>
    <br>
    <button type="submit">Cập nhật</button>
</form>
