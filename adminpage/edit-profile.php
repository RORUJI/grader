<?php
session_start();

include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: index.php");
} else {
    $userId = $_SESSION['userid'];
    $sqlUserData = "SELECT * FROM user INNER JOIN level ON user.levelID = level.levelID WHERE userid = $userId";
    $queryUserData = $conn->query($sqlUserData);
    $userData = $queryUserData->fetch_assoc();

    ?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Grader</title>
    </head>

    <style>
        .profile-field {
            height: 95%;
            width: 35vw;
            margin: 1vw;
            background: var(--sidebaer-color);
            border-radius: 28px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
    </style>

    <body>
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="../User.jpg" alt="">
                    </span>

                    <div class="text header-text">
                        <span class="name">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        <span class="profession">Web developer</span>
                    </div>
                </div>

                <i class='bx bx-chevron-right toggle'></i>

            </header>

            <div class="menu-bar">
                <div class="menu">
                    <li class="nav-link">
                        <a href="index.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">หน้าหลัก</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="profile.php">
                            <i class='bx bxs-user icon'></i>
                            <span class="text nav-text">โปรไฟล์</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="sum-student-score.php">
                            <i class="bx bx-history icon"></i>
                            <span class="text nav-text">คะแนนรวม</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../about-us.php">
                            <i class="bi bi-people-fill icon"></i>
                            <span class="text nav-text">เกี่ยวกับเรา</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../contact.php">
                            <i class="bx bxs-contact icon"></i>
                            <span class="text nav-text">ติดต่อเรา</span>
                        </a>
                    </li>
                </div>
                <div class="bottom-content">
                    <li class="">
                        <a href="../system/logout_system.php" id="logout-button">
                            <i class="bx bx-log-out icon"></i>
                            <span class="text nav-text">ล็อคเอาท์</span>
                        </a>
                    </li>

                    <li class="mode">
                        <div class="moon-sun">
                            <i class="bx bx-moon icon moon"></i>
                            <i class="bx bx-sun icon sun"></i>
                        </div>
                        <span class="mode-text text">โหมดมืด</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </div>
            </div>
        </nav>

        <section class="home">
            <div class="text">
                <div class="profile-field row p-2">
                    <div class="col p-2 rounded-5 type-select text-center">
                        <form action="profile-systems/edit-profile-system.php" id="editProfileForm" method="post">
                            <h2 class="fw-bold">Edit Profile</h2>
                            <hr>
                            <div class="rounded p-2 text-start">
                                <div class="mb-2">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control form-control-sm"
                                        value="<?php echo $userData['username']; ?>">
                                </div>

                                <div class="mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-sm"
                                        value="<?php echo $userData['password']; ?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control form-control-sm"
                                        value="<?php echo $userData['email']; ?>">
                                </div>

                                <div class="mb-2">
                                    <label for="tel" class="form-label">Telephone Number</label>
                                    <input type="tel" name="tel" class="form-control form-control-sm"
                                        value="<?php echo $userData['tel']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" name="status" class="form-control form-control-sm"
                                        value="<?php echo $userData['levelname']; ?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <button type="submit" class="btn btn-sm btn-success">Edit</button>
                                    <a href="profile.php" class="btn btn-sm btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js?"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                $('#editProfileForm').submit(function (e) {
                    e.preventDefault();
                    let formUrl = $(this).attr('action');
                    let reqMethod = $(this).attr('method');
                    let formData = $(this).serialize();

                    $.ajax({
                        type: reqMethod,
                        url: formUrl,
                        data: formData,
                        success: function (data) {
                            let jsonData = JSON.parse(data);

                            if (jsonData.status == "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "สำเร็จ",
                                    text: jsonData.msg,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then((r) => {
                                    window.location.href = "profile.php";
                                })
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "ล้มเหลว",
                                    text: jsonData.msg,
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }
                        }
                    });
                });
            });
        </script>
    </body>

    </html>

<?php } ?>