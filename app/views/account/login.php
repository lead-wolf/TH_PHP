<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Header Example</title> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/head.css">
    <style>
        body{
            background: #29334f;
            font-family: 'Arial', sans-serif;
        } 
    </style>
</head>
<body>
    
<section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label d-flex" for="username">UserName</label>
                                    <input type="text" id="username" class="form-control form-control-lg" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label d-flex" for="password">Password</label>
                                    <input type="password" id="password" class="form-control form-control-lg" />
                                </div>
                                <p class="small mb-5 pb-lg-2">
                                    <a class="text-white-50" href="#!">Forgot password?</a>
                                </p>
                                <button class="btn btn-outline-light btn-lg px-5" onclick="login()">Login</button>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0">
                                    Don't have an account? 
                                    <a href="/account/register" class="text-white-50 fw-bold">Sign Up</a>
                                </p>
                            </div>
                            <div id="message" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- <script>
        function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');

            fetch('http://localhost/api/account/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageDiv.innerHTML = `<p class="text-success">${data.message}</p>`;
                    localStorage.setItem('token', data.token); 
                    setTimeout(() => window.location.href = '/product', 1000);
                } else {
                    messageDiv.innerHTML = `<p class="text-danger">${data.message}</p>`;
                }
            })
            .catch(error => {
                messageDiv.innerHTML = `<p class="text-danger">Lỗi: ${error.message}</p>`;
            });
        }
    </script> -->
    <script>
        // Gọi hàm login khi nhấn Enter
        document.addEventListener('DOMContentLoaded', function () {
            // const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            // Lắng nghe sự kiện keydown trên cả hai trường
            // usernameInput.addEventListener('keydown', handleEnterKey);
            passwordInput.addEventListener('keydown', handleEnterKey);

            function handleEnterKey(event) {
                if (event.key === 'Enter') {
                    login(); 
                }
            }
        });

        function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');        

            fetch('http://localhost/api/account/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageDiv.innerHTML = `<p class="text-success">${data.message}</p>`;
                    localStorage.setItem('token', data.token); 
                    localStorage.setItem('username', username);
                    setTimeout(() => window.location.href = '/product', 1000);
                } else {
                    messageDiv.innerHTML = `<p class="text-danger">${data.message}</p>`;
                }
            })
            .catch(error => {
                messageDiv.innerHTML = `<p class="text-danger">Lỗi: ${error.message}</p>`;
            });
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>