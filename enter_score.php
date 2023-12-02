<?php
    session_start();

    include_once 'dbconnect.php';

    if (isset($_SESSION['userID']) && isset($_POST['questionID'])) {
        $userID = $_SESSION['userID'];
        $questionID = $_POST['questionID'];
        $score = 1;

        $sql = "INSERT INTO score(score, userID, questionID) VALUES(?, ?, ?)";
        $statement = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($statement, 'iii', $score, $userID, $questionID);
        $result = mysqli_stmt_execute($statement);

        if ($result) {
            echo json_encode(array('status' => 'success', 'msg' => 'บันทึกคะแนนของคุณสำเร็จ!'));
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'บันทึกคะแนนของคุณไม่สำเร็จ!'));
        }
    }
?>