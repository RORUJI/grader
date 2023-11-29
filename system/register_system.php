<?php
    session_start();

    include_once "../dbconnect.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    if (!$username) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your username.'));
    } else if (!$password) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your password.'));
    } else if (!$confirm_password) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please confirm your passowrd.'));
    } else if (!$email) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your email.'));
    } else if (!$tel) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your telephone number.'));
    } else if ($password != $confirm_password) {
        echo json_encode(array('status' => 'error', 'msg' => 'Confirm password is incorrect.'));
    } else {
        $checkuser = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $checkuser);
        if (mysqli_num_rows($result) == 0) {
            try {
                $passwordenc = md5($password);
                $level = 1;
                $sql = "INSERT INTO user(username, password, email, tel, levelID) VALUES(?, ?, ?, ?, ?)";
                $statement = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($statement, 'ssssi', $username, $passwordenc, $email, $tel, $level);
                mysqli_execute($statement);
                echo json_encode(array('status' => 'success', 'msg' => 'Registration Successfully!'));
            } catch (PDOException $e) {
                echo json_encode(array('status'=> 'error', 'msg'=> 'Something went wrong, please try again!'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'Username or email is already exists.'));
        }
    }
?>