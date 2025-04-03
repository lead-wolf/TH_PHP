<?php
class CategoryModel
{
    private $db;
    private $table = 'category';

    public function __construct($_db)
    {
        $this->db = $_db;
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy tất cả các danh mục
    public function getAllCategory()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Sử dụng PDO::FETCH_ASSOC để trả về mảng kết hợp
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm một danh mục mới
    public function createCategory($name, $description)
    {
        $query = "INSERT INTO " . $this->table . " (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name, $description)
    {
        $query = "UPDATE " . $this->table . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute(); // Trả về true hoặc false
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>