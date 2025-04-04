<?php
// Require necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class CategoryApiController
{
    private $categoryModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        $this->jwtHandler = new JWTHandler();
        
        // Thiết lập header cho API
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type');
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = (new JWTHandler())->decode($jwt);
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

    // GET: Lấy danh sách danh mục
    public function index()
    {
        try {
            $categories = $this->categoryModel->getAllCategory();
            echo json_encode([
                'status' => 'success',
                'data' => $categories
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // GET: Lấy thông tin danh mục theo ID
    public function show($id)
    {
        try {
            $category = $this->categoryModel->getCategoryById($id);
            if ($category) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $category
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Không tìm thấy danh mục'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // POST: Tạo mới danh mục
    public function store()
    {
        try {
            $decoded = $this->authenticate();
            if (!$this->authorizeAdmin($decoded)) {
                http_response_code(403);
                echo json_encode(['message' => 'Access denied. Admins only.']);
                return;
            }

            // Lấy dữ liệu từ request body
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['name']) || !isset($data['description'])) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin name hoặc description'
                ]);
                return;
            }

            $result = $this->categoryModel->createCategory($data['name'], $data['description']);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Tạo danh mục thành công'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // PUT: Cập nhật danh mục
    public function update($id)
    {
        try {
            $decoded = $this->authenticate();
            if (!$this->authorizeAdmin($decoded)) {
                http_response_code(403);
                echo json_encode(['message' => 'Access denied. Admins only.']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['name']) || !isset($data['description'])) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Thiếu thông tin name hoặc description'
                ]);
                return;
            }

            $isUpdated = $this->categoryModel->updateCategory($id, $data['name'], $data['description']);
            if ($isUpdated) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật danh mục thành công'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Cập nhật không thành công'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // DELETE: Xóa danh mục
    public function destroy($id)
    {
        try {
            $decoded = $this->authenticate();
            if (!$this->authorizeAdmin($decoded)) {
                http_response_code(403);
                echo json_encode(['message' => 'Access denied. Admins only.']);
                return;
            }

            $result = $this->categoryModel->deleteCategory($id);
            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Xóa danh mục thành công'
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Không tìm thấy danh mục để xóa'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
?>
