<?php
session_start();

include_once "dbconnect.php";

$type = $_POST['type'];
$questionID = $_POST['questionID'];
$code = $_POST['sqlCode'];
$sql = "SELECT * FROM question WHERE questionID = '$questionID'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($code == "") {
    echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.' . $type));
} else {
    if ($type == 1) {
        try {
            $query = $conn->query($row['select_code']);
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
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    } else if ($type == 2) {
        try {
            $query = $conn->query($row['select_code']);

            if ($query->num_rows > 0) {
                $delete = $conn->query($row['delete_code']);
            }
            $queryCode = $conn->query($code);
            $query = $conn->query($row['select_code']);
            if ($query->num_rows > 0) {
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
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    } else if ($type == 3) {
        try {
            $query = $conn->query($row['select_code']);

            if ($query->num_rows < 1) {
                $insert = $conn->query($row['insert_code']);
            }
            $queryCode = $conn->query($code);
            $query = $conn->query($row['select_code']);
            if ($query->num_rows < 1) {
                if (isset($_SESSION['userID'])) {
                    $sql = "SELECT * FROM score WHERE userID = '$_SESSION[userID]' AND questionID = '$questionID'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) < 1) {
                        echo json_encode(array('status' => 'noscore_success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                    } else {
                        echo json_encode(array('status' => 'score_success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                    }
                } else {
                    echo json_encode(array('status' => 'success', 'msg' => 'คำตอบของคุณถูกต้อง!'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    }
}
?>