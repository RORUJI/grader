<?php
    session_start();

    include_once '../dbconnect.php';

    if (isset($_SESSION['userID']) && isset($_POST['scoreID'])) {
        try {
            $scoreID = $_POST['scoreID'];
            $userID = $_SESSION['userID'];

            $sql = "DELETE FROM score WHERE scoreID = '$scoreID' AND userID = '$userID'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo json_encode(array('status' => 'success', 'msg' => 'รีเซ็ตคะแนนเรียบร้อยแล้ว!'));
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'รีเซ็ตคะแนนไม่สำเร็จ'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'โค้ดของคุณมีบางอย่างผิดพลาด โปรดลองใหม่อีกครั้ง!'));
        }
    }
?>