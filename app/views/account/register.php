<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background: #29334f;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .card-body {
            padding: 40px;
        }
        .form-control-user {
            border-radius: 25px;
            padding: 15px;
            font-size: 1rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #141b30;
            border-color: #141b30;
            border-radius: 25px;
            font-size: 1.1rem;
            padding: 15px 40px;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .text-danger {
            font-size: 0.9rem;
            margin-top: 10px;
        }
        .card-header {
            background: #141b30;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-size: 1.5rem;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg" style="width: 450px;">
            <div class="card-header text-center">
                Đăng Ký Tài Khoản
            </div>
            <div class="card-body">
                <div id="error-messages" class="mb-3"></div>
                <form class="user" id="register-form" onsubmit="register(event)">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="username" name="username"
                                   placeholder="Tên người dùng" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="fullname" name="fullname"
                                   placeholder="Họ và tên" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="password" name="password"
                                   placeholder="Mật khẩu" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="confirmpassword"
                                   name="confirmpassword" placeholder="Nhập lại mật khẩu" required>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary btn-icon-split p-3" type="submit">
                            Đăng Ký
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function register(event) {
            event.preventDefault(); // Ngăn form submit mặc định

            const form = document.getElementById('register-form');
            const formData = new FormData(form);
            const data = {
                username: formData.get('username'),
                fullname: formData.get('fullname'),
                password: formData.get('password'),
                confirmpassword: formData.get('confirmpassword')
            };

            fetch('http://localhost/api/account/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) throw new Error('Đăng ký thất bại');
                return response.json();
            })
            .then(result => {
                const errorMessages = document.getElementById('error-messages');
                if (result.status === 'success') {
                    errorMessages.innerHTML = `
                        <div class="alert alert-success">${result.message}</div>
                    `;
                    setTimeout(() => window.location.href = 'account/login', 2000);
                } else {
                    let errorHtml = '<ul class="text-danger">';
                    for (const [key, value] of Object.entries(result.errors)) {
                        errorHtml += `<li>${value}</li>`;
                    }
                    errorHtml += '</ul>';
                    errorMessages.innerHTML = errorHtml;
                }
            })
            .catch(error => {
                document.getElementById('error-messages').innerHTML = `
                    <div class="alert alert-danger">Lỗi: ${error.message}</div>
                `;
            });
        }
    </script>
</body>
</html>
