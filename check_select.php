<?php
session_start();

include_once "dbconnect.php";

$questionID = $_POST['questionID'];
$questionCode = $_POST['code'];
$code = $_POST['sqlCode'];

try {
    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        $query = $conn->query($questionCode);
        $queryCode = $conn->query($code);

        if ($query->num_rows != $queryCode->num_rows) {
            echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
        } else if ($query->field_count != $queryCode->field_count) {
            echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
        } else {
            $i = 1;
            while (($aRow = $query->fetch_array()) && ($bRow = $queryCode->fetch_array())) {
                $j = 0;
                while ($j < $query->field_count) {
                    if ($aRow[$j] != $bRow[$j]) {
                        $result = 'false';
                        echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                        break;
                    } else {
                        $j++;
                        continue;
                    }
                }
                if (isset($result) && $result == 'false') {
                    break;
                } else if ($i < $query->num_rows) {
                    $i++;
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
    echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
}
?>