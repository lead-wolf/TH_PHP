<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');

class AccountApiController
{
    private $accountModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();

        // Thiết lập header cho API
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *'); // Điều chỉnh theo nhu cầu bảo mật
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    // POST: Đăng ký tài khoản
    public function register()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data['username'] ?? '';
            $fullName = $data['fullname'] ?? '';
            $password = $data['password'] ?? '';
            $confirmPassword = $data['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password !== $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            if (count($errors) > 0) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'errors' => $errors]);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $result = $this->accountModel->save($username, $fullName, $hashedPassword);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Đăng ký thành công',
                    'data' => ['username' => $username]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Đăng ký thất bại']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // POST: Đăng nhập
    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            $user = $this->accountModel->getAccountByUsername($username);

            if ($user && password_verify($password, $user->password)) {
                $token = $this->jwtHandler->encode([
                    'id' => $user->id,
                    'username' => $user->username,
                    'fullname' => $user->fullname,
                    'role' => $user->role,
                ]);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công',
                    'token' => $token
                ]);
            } else {
                http_response_code(401);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Thông tin đăng nhập không hợp lệ'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
                return;
            }
            echo json_encode([
                'status' => 'success',
                'message' => 'Đăng xuất thành công, vui lòng xóa token ở client'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // GET: Kiểm tra token (thêm để xác thực JWT)
    public function verifyToken()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
                return;
            }

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                http_response_code(401);
                echo json_encode(['status' => 'error', 'message' => 'Token không được cung cấp']);
                return;
            }

            $token = $matches[1];
            $decoded = $this->jwtHandler->decode($token);
            if ($decoded) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Token hợp lệ',
                    'data' => $decoded
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 'error', 'message' => 'Token không hợp lệ hoặc đã hết hạn']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$controller = new AccountApiController();

switch ($method) {
    case 'POST':
        if (preg_match('/\/account\/register/', $uri)) {
            $controller->register();
        } elseif (preg_match('/\/account\/login/', $uri)) {
            $controller->login();
        } elseif (preg_match('/\/account\/logout/', $uri)) {
            $controller->logout();
        }
        break;
    case 'GET':
        if (preg_match('/\/account\/verify/', $uri)) {
            $controller->verifyToken();
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method không được hỗ trợ']);
}