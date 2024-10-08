<!DOCTYPE html>
<html class="bg-primary" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Grader</title>
</head>

<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="User.jpg" alt="">
                </span>

                <div class="text header-text">
                    <span class="profession">Web developer</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>

        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="search" placeholder="Search...">
                </li>
                <li class="nav-link">
                    <a href="index.php">
                        <i class='bx bx-home icon'></i>
                        <span class="text nav-text">Home</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="profile.php">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Profile</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="history.php">
                        <i class='bx bx-history icon'></i>
                        <span class="text nav-text">History</span>
                    </a>
                </li>
            </div>
            <div class="bottom-content">

                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>
    <section class="home">
        <div class="text">
            <div class="div-text-login">
                <img src="IconGrader.png" alt="" style="padding-bottom: 2.5vw; padding-left:4vw; margin-right: 1vw;">
                <div class="timeline">
                    <div class="div-login">
                        <form action="system/register_system.php" method="post" id="signupForm">
                            <h1>Register</h1>
                            <hr>
                            <div>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Create a username">
                            </div>
                            <p></p>
                            <div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Create a password">
                            </div>
                            <p></p>
                            <div>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control" placeholder="Confirm a password">
                            </div>
                            <p></p>
                            <div>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Create an email">
                            </div>
                            <p></p>
                            <div>
                                <input type="tel" name="tel" id="tel" class="form-control"
                                    placeholder="Create an telephone number">
                            </div>
                            <div>
                                <button type="submit" name="signup-btn" id="signup-btn"
                                    class="btn btn-primary fw-bold w-100">REGISTER</button>
                            </div>
                            <hr>
                            <div class="Register-text">
                                You have an account?
                                <a href="login2.php">Login!</a>
                            </div>
                        </form>
                    </div>
                </div><br>
            </div>
        </div>
    </section>

    <script src="change-mode.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#signupForm').submit(function (e) {
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
                            console.log('Success', result);
                            Swal.fire({
                                icon: result.status,
                                title: 'สำเร็จ!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                window.location.reload();
                            });
                        } else {
                            console.log('Error!', result);
                            Swal.fire({
                                icon: result.status,
                                title: 'ล้มเหลว',
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