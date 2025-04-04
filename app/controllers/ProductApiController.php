<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

require_once('app/utils/JWTHandler.php');
class ProductApiController
{
    private $productModel;
    private $db;
    private $jwtHandler;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->jwtHandler = new JWTHandler();

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded;
            }
        }
        return null;
    }


    private function authorizeAdmin($decoded)
    {
        if ($decoded && isset($decoded['role']) && $decoded['role'] === 'admin') {
            return true;
        }
        return false;
    }
    // Lấy danh sách sản phẩm
    public function index()
    {
        // header("Access-Control-Allow-Origin: *");
        // header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }
    // Lấy thông tin sản phẩm theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }
    // Thêm sản phẩm mới
    public function store()
    {
        $decoded = $this->authenticate();
        if (!$this->authorizeAdmin($decoded)) {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Admins only.']);
            return;
        }

        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $result = $this->productModel->addProduct(
            $name,
            $description,
            $price,
            $category_id,
            // null
        );

        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }
    // Cập nhật sản phẩm theo ID
    public function update($id)
    {
        $decoded = $this->authenticate();
        if (!$this->authorizeAdmin($decoded)) {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Admins only.']);
            return;
        }

        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $result = $this->productModel->updateProduct(
            $id,
            $name,
            $description,
            $price,
            $category_id,
        );  

        // echo json_encode([
        //     $name,
        //     $description,
        //     $price,
        //     $category_id,
        // ]);
        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }
    // Xóa sản phẩm theo ID
    public function destroy($id)
    {
        $decoded = $this->authenticate();
        echo json_encode($decoded);
        echo json_encode($decoded['role']);
        if (!$this->authorizeAdmin($decoded)) {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Admins only.']);
            return;
        }

        // header('Content-Type: application/json');
        $result = $this->productModel->deleteProduct($id);
        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
}
?>