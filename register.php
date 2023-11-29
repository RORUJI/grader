<!DOCTYPE html>
<html class="bg-primary" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Grader</title>
</head>

<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <form action="system/register_system.php" method="post" id="signupForm" class="signup-form bg-body rounded shadow-lg">
            <div class="p-3">
                <h2 class="fw-bold text-center">R e g i s t e r</h2>
                <hr>
                <div class="mb-3">
                    <label for="username" class="fw-bold form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Create a username">
                </div>
                <div class="mb-3">
                    <label for="password" class="fw-bold form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Create a password">
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="fw-bold form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        placeholder="Confirm a password">
                </div>
                <div class="mb-3">
                    <label for="email" class="fw-bold form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Create an email"
                    >
                </div>
                <div class="mb-3">
                    <label for="tel" class="fw-bold form-label">Telephone Number</label>
                    <input type="tel" name="tel" id="tel" class="form-control" placeholder="Create an telephone number"
                    >
                </div>
                <div class="mb-3 text-center">
                    You have an account?
                    <a href="login.php" class="signup-link text-primary">Login!</a>
                </div>
                <button type="submit" name="signup-btn" id="signup-btn"
                    class="btn btn-primary w-100">REGISTER</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#signupForm').submit(function(e) {
                e.preventDefault();
                let formUrl = $(this).attr('action');
                let reqMethod = $(this).attr('method');
                let formData = $(this).serialize();
                $.ajax({
                    type: reqMethod,
                    url: formUrl,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);
                        if(result.status == 'success') {
                            console.log('Success', result);
                            Swal.fire({
                                icon: result.status,
                                title: 'สำเร็จ!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
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