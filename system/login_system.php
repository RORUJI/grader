<?php
    session_start();

    include_once '../dbconnect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$email) {
        echo json_encode(array('status' => 'error', 'msg' => 'กรุณากรอก Email ของคุณ'));
    } else if (!$password) {
        echo json_encode(array('status' => 'error', 'msg' => 'กรุณากรอก Password ของคุณ'));
    } else {
        try {
            $passwordenc = md5($password);
            $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$passwordenc'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['level'] = $row['levelID'];
                echo json_encode(
                    array(
                        'status' => 'success', 
                        'msg' => 'เข้าสู่ระบบสำเร็จ', 
                        'level' => $_SESSION['level']
                    )
                );
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Email หรือ Password ของคุณไม่ถูกต้อง'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('status'=> 'error', 'msg'=> 'มีบางอย่างผิดพลาด โปรดลองอีกครั้ง'));
        }
    }
?>