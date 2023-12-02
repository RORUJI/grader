<?php
    session_start();
    
    include_once('../dbconnect.php');

    $code = $_POST['sqlCode'];

    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        try {
            $questionID = 5;
            $sql = "SELECT * FROM question WHERE questionID = '$questionID'";
            $query = mysqli_query($conn, $sql);
            $question = mysqli_fetch_assoc($query);

            $aResult = mysqli_query($conn, $question['code']);
            $bResult = mysqli_query($conn, $code);

            if (mysqli_num_fields($aResult) != mysqli_num_fields($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
            } else if (mysqli_num_rows($aResult) != mysqli_num_rows($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
            } else {
                $count = 1;

                while (($aRow = mysqli_fetch_assoc($aResult)) && ($bRow = mysqli_fetch_assoc($bResult))) {
                    if ($aRow['genderID'] != $bRow['genderID']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['gender'] != $bRow['gender']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
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
                                echo json_encode(array('status' => 'success', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    }
?>