<?php
    session_start();

    include_once 'dbconnect.php';

    if (!isset($_SESSION['userID'])) {
        header('location: login.php');
    } else {
        $count = 1;
        $userID = $_SESSION['userID'];
        $sql = "SELECT * FROM question";
        $result = mysqli_query($conn, $sql);
    }
?>

<!DOCTYPE html>
<html class="bg-primary" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <span class="name">
                        <?php if (!isset($_SESSION['userID'])) : ?>
                            Guest
                        <?php endif; ?>
                    </span>
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
                    <a href="index2.php">
                        <i class='bx bx-home icon'></i>
                        <span class="text nav-text">Home</span>
                    </a>
                </li> 
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Profile</span>
                    </a>
                </li> 
            </div>
            <div class="bottom-content">
                    <li class="">
                        <a href="login.php">
                            <i class="bx bx-log-out icon"></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>

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
            <div class="div-text"><br>
            <div class="d-flex justify-content-center  my-3">
            <h2>คะแนนของคุณ</h2>
        </div>
        <table class="table table-striped table-bordered shadow-lg">
            <thead>
                <tr>
                    <th scope="row">#</th>
                    <th scope="row">แบบทดสอบ</th>
                    <th scope="row">คะแนน</th>
                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_array($result)): ?>
                <tbody>
                        <tr>
                        
                        </tr>
                </tbody>
            <?php endwhile; ?>
                <tfoot>
                    <tr>
                        <td>รวม</td>
                        <td>แบบทดสอบทั้งหมด</td>
                        <td>
                            <?php 
                                $sql = "SELECT count(question) FROM question";
                                $result = mysqli_query($conn, $sql);
                                $questionCount = mysqli_fetch_assoc($result);

                                $sql = "SELECT sum(score) FROM score WHERE userID = '$userID'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo $row['sum(score)'] . '/' . $questionCount['count(question)'];
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger"
                                onclick="resetAllScore(<?php echo $userID; ?>)">รีเซ็ตคะแนนทั้งหมด</button>
                        </td>
                    </tr>
                </tfoot>
        </table>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#btnBack').click(function () {
                history.back();
            });
        });

        function resetScore(scoreID) {
            $(document).ready(function () {
                Swal.fire({
                    icon: 'info',
                    title: 'คุณต้องการรีเซ็ตคะแนนหรือไม่?',
                    text: 'หากคุณรีเซ็ต คะแนนของแบบทดสอบนี้จะหายไป!',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'รีเซ็ต',
                    cancelButtonText: 'ไม่ล่ะ',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'system/reset_score.php',
                            data: {
                                scoreID: scoreID
                            },
                            success: function (data) {
                                result = JSON.parse(data);
                                if (result.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สำเร็จ!',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: score.status,
                                        title: 'ล้มเหลว!',
                                        text: score.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        })
                    }
                })
            });
        }

        function resetAllScore(userID) {
            $(document).ready(function () {
                Swal.fire({
                    icon: 'info',
                    title: 'คุณต้องการรีเซ็ตคะแนนหรือไม่?',
                    text: 'หากคุณรีเซ็ต คะแนนของแบบทดสอบนี้จะหายไป!',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'รีเซ็ต',
                    cancelButtonText: 'ไม่ล่ะ',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'system/reset_allScore.php',
                            data: {
                                userID: userID
                            },
                            success: function (data) {
                                result = JSON.parse(data);
                                if (result.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สำเร็จ!',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: score.status,
                                        title: 'ล้มเหลว!',
                                        text: score.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        })
                    }
                })
            });
        }
        
        const body = document.querySelector("body"),
        sidebar = body.querySelector(".sidebar"),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwtich = body.querySelector(".toggle-switch")
        modeText = body.querySelector(".mode-text");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });

        modeSwtich.addEventListener("click", () => {
            body.classList.toggle("dark");

            if(body.classList.contains("dark")){
                modeText.innerText = "Light Mode"
            }else{
                modeText.innerText = "Drak Mode"
            }
        });
        
    </script>
    
</body>

</html>