<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
        FROM " . $this->table_name . " p
        LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function addProduct($name, $description, $price, $category_id)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $image_name = 'no-image.jpg'; // Mặc định nếu không có ảnh

        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            if ($image['error'] == 0) {
                $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                $allow_exts = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($image_ext, $allow_exts)) {
                    $errors['image'] = 'Chỉ chấp nhận file ảnh có định dạng jpg, jpeg, png, gif';
                }
                if ($image['size'] > 2097152) {
                    $errors['image'] = 'Dung lượng file ảnh không được vượt quá 2MB';
                }
                if (count($errors) > 0) {
                    return $errors;
                }

                // Đổi tên file
                $image_name = uniqid() . '.' . $image_ext;
                $image_path = 'public/images/uploads/' . $image_name;

                // Di chuyển file vào thư mục uploads
                move_uploaded_file($image['tmp_name'], $image_path);
            }
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, image, category_id) 
                VALUES (:name, :description, :price, :image, :category_id)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $image_name = htmlspecialchars(strip_tags($image_name));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image_name);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }


    public function updateProduct($id, $name, $description, $price, $category_id)
    {
        // var_dump($category_id);
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        // Lấy thông tin sản phẩm cũ để kiểm tra ảnh
        $query = "SELECT image FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return ['error' => 'Sản phẩm không tồn tại'];
        }

        $old_image = $product['image'];
        $new_image_name = $old_image;

        // Kiểm tra nếu có file ảnh mới
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            if ($image['error'] == 0) {
                $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                $allow_exts = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($image_ext, $allow_exts)) {
                    $errors['image'] = 'Chỉ chấp nhận file ảnh có định dạng jpg, jpeg, png, gif';
                }
                if ($image['size'] > 2097152) {
                    $errors['image'] = 'Dung lượng file ảnh không được vượt quá 2MB';
                }
                if (count($errors) > 0) {
                    return $errors;
                }

                // Đổi tên file mới
                $new_image_name = uniqid() . '.' . $image_ext;
                $new_image_path = 'public/images/uploads/' . $new_image_name;

                // Xóa ảnh cũ nếu không phải ảnh mặc định
                if ($old_image !== 'no-image.jpg' && file_exists('public/images/uploads/' . $old_image)) {
                    unlink('public/images/uploads/' . $old_image);
                }

                // $uploadDir = 'public/images/uploads/';

                // // Kiểm tra và tạo thư mục nếu chưa tồn tại
                // if (!is_dir($uploadDir)) {
                //     mkdir($uploadDir, 0777, true);
                // }
                
                // // Kiểm tra quyền ghi của thư mục
                // if (!is_writable($uploadDir)) {
                //     die("Thư mục không có quyền ghi: " . $uploadDir);
                // }
                
                // Di chuyển ảnh vào thư mục
                if (!move_uploaded_file($image['tmp_name'], $new_image_path)) {
                    die("Lỗi khi di chuyển file từ " . $image['tmp_name'] . " đến " . $new_image_path);
                }
                echo "Tải ảnh lên thành công!";

                // Di chuyển ảnh mới vào thư mục
                // move_uploaded_file($image['tmp_name'], $new_image_path);
            }
        }

        $query = "UPDATE " . $this->table_name . " SET 
                    name=:name, description=:description, price=:price, 
                    image=:image, category_id=:category_id 
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $new_image_name = htmlspecialchars(strip_tags($new_image_name));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $new_image_name);
        $stmt->bindParam(':category_id', $category_id);


        return $stmt->execute();
    }
    
    public function deleteProduct($id)
    {
        // Lấy tên ảnh trước khi xóa sản phẩm
        $query = "SELECT image FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$product) {
            return false; // Sản phẩm không tồn tại
        }
    
        $old_image = $product['image'];
    
        // Xóa sản phẩm khỏi database
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            // Kiểm tra và xóa ảnh (trừ trường hợp ảnh mặc định)
            if ($old_image !== 'no-image.jpg' && file_exists('public/images/uploads/' . $old_image)) {
                unlink('public/images/uploads/' . $old_image);
            }
            return true;
        }
        return false;
    }
    
}
?>