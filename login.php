<form?php session_start(); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Grader</title>
    </head>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap");

        * {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /*=== Color ===*/
            --body-color: #e4e9f7;
            --sidebaer-color: #fff;
            --primary-color: #695cfe;
            --primary-color-light: #f6f5ff;
            --toggle-color: #ddd;
            --text-color: #707070;

            /*=== Transition ===*/
            --tran-02: all 0.2s ease;
            --tran-03: all 0.3s ease;
            --tran-04: all 0.4s ease;
            --tran-05: all 0.5s ease;
        }

        body {
            height: 100vh;
            background: var(--body-color);
            transition: var(--tran-04);
        }

        .signInForm {
            position: relative;
            width: 170vh;
            height: 95vh;
            background: var(--sidebaer-color);
            border-radius: 28px;
        }

        .float-start {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            margin-left: 8px;
        }

        .signIn {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
        }

        img {
            height: 90vh;
            border-radius: 20px;
        }

        #signInForm {
            width: 100%;
            height: 90vh;
            background: var(--primary-color-light);
            transition: var(--tran-04);
            margin-right: 8px;
            border-radius: 28px;
            color: var(--text-color)
        }

        .btn-login {
            width: 100%;
        }

        .signUp-link a {
            text-decoration: none;
        }

        .signUp-link a:hover {
            text-decoration: underline;
        }
    </style>

    <body>
        <div class="container">
            <div class="position-absolute start-50 top-50 translate-middle">
                <div class="signInForm row">
                    <div class="col float-start">
                        <img src="IconGrader.png" alt="">
                    </div>
                    <div class="col signIn">
                        <form action="system/login_system.php" method="post" id="signInForm">
                            <div class="p-4">
                                <h2 class="fw-bold text-center">Sign In</h2>
                                <hr>
                                <div class="mx-4 my-4">
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="กรุณาใส่ Email ของคุณ">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-bold">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="กรุณาใส่ Password ของคุณ">
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary btn-login fw-bold">Sign In</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="signUp-link">
                                    คุณไม่ได้มีบัญชีใช่ไหม?
                                    <a href="register.php">Sign Up</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
                $('#signInForm').submit(function (e) {
                    e.preventDefault();
                    let formUrl = $(this).attr('action');
                    let reqMethod = $(this).attr('method');
                    let formData = $(this).serialize();
                    $.ajax({
                        type: reqMethod,
                        url: formUrl,
                        data: formData,
                        success: function (data) {
                            let result = JSON.parse(data);
                            if (result.status == 'success') {
                                Swal.fire({
                                    icon: result.status,
                                    title: 'สำเร็จ!',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function () {
                                    if (result.level == 1) {
                                        window.location.href = 'index.php';
                                    } else {
                                        window.location.href = 'adminpage/home.php';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: result.status,
                                    title: 'ล้มเหลว!',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                });
            });
        </script>
    </body>

    </html>