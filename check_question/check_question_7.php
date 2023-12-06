<?php
    session_start();

    include_once('../dbconnect.php');

    $code = $_POST['sqlCode'];

    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'โปรดใส่โค้ดคำสั่ง'));
    } else {
        try {
            $questionID = 7;
            $sql = "SELECT * FROM question WHERE questionID = '$questionID'";
            $query = mysqli_query($conn, $sql);
            $question = mysqli_fetch_assoc($query);

            $aResult = mysqli_query($conn, $question['code']);
            $bResult = mysqli_query($conn, $code);

            if (mysqli_num_fields($aResult) != mysqli_num_fields($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
            } else if (mysqli_num_rows($aResult) != mysqli_num_rows($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
            } else {
                $count = 1;

                while (($aRow = mysqli_fetch_assoc($aResult)) && ($bRow = mysqli_fetch_assoc($bResult))) {
                    if ($aRow['personID'] != $bRow['personID']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else if ($aRow['firstname'] != $bRow['firstname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else if ($aRow['lastname'] != $bRow['lastname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else if ($aRow['weight'] != $bRow['weight']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else if ($aRow['height'] != $bRow['height']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else if ($aRow['genderID'] != $bRow['genderID']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else {
                        if ($count < mysqli_num_rows($aResult)) {
                            $count++;
                            continue;
                        } else {
                            if (isset($_SESSION['userID'])) {
                                $sql = "SELECT * FROM score WHERE userID = '$_SESSION[userID]' AND questionID = '$questionID'";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) == 0) {
                                    echo json_encode(array('status' => 'noscore_success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                                } else {
                                    echo json_encode(array('status' => 'score_success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                                }
                            } else {
                                echo json_encode(array('status' => 'success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'โค้ดของคุณมีบางอย่างผิดพลาด โปรดลองใหม่อีกครั้ง!'));
        }
    }
?>