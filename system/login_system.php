<?php
    session_start();

    include_once '../dbconnect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$email) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your email.'));
    } else if (!$password) {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your password.'));
    } else {
        try {
            $passwordenc = md5($password);
            $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$passwordenc'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['levelID'] = $row['levelID'];
                echo json_encode(
                    array(
                        'status' => 'success', 
                        'msg' => 'SignIn Successfully!', 
                        'levelID' => $_SESSION['levelID']
                    )
                );
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Username or password is incorrect.'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('status'=> 'error', 'msg'=> 'Something went wrong, please try again!'));
        }
    }
?>