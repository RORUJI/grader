<?php
if (!isset($_SESSION['username']) && !isset($_POST['code']) && !isset($_POST['quizid'])) {
    header("location: ../../index.php");
} else {
    include_once "create_temptable.php";
    $code = $_POST['code'];
    $table = $_POST['table'];
    $type = $_POST['type'];
    $quizid = $_POST['quizid'];
    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        if ($type == 1) {
            $queryofquiz = $conn->query($selectcode);
            $queryofuser = $conn->query($code);
            try {
                if ($queryofquiz->num_rows != $queryofuser->num_rows) {
                    echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                    $droptable = $conn->query("DROP TABLE $usertable");
                } else if ($queryofquiz->field_count != $queryofuser->field_count) {
                    echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                    $droptable = $conn->query("DROP TABLE $usertable");
                } else {
                    $i = 1;
                    while (($rowofquiz = $queryofquiz->fetch_array()) && ($rowofuser = $queryofuser->fetch_array())) {
                        $j = 0;
                        while ($j < $queryofuser->field_count) {
                            if ($rowofquiz[$j] != $rowofuser[$j]) {
                                $result = 'false';
                                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                                break;
                            } else {
                                $j++;
                                continue;
                            }
                        }
                        if (isset($result) && $result == 'false') {
                            $droptable = $conn->query("DROP TABLE $usertable");
                            break;
                        } else if ($i < $queryofuser->num_rows) {
                            $i++;
                            continue;
                        } else {
                            if ($code == $selectcode) {
                                $score = 2;
                            } else {
                                $score = 1;
                            }
                            echo json_encode(
                                array(
                                    'status' => 'success',
                                    'msg' => 'Correct',
                                    'score' => $score,
                                    'userid' => $_SESSION['userid'],
                                    'quizid' => $quizid
                                )
                            );
                            $droptable = $conn->query("DROP TABLE $usertable");
                        }
                    }
                }
            } catch (Exception $e) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                $droptable = $conn->query("DROP TABLE $usertable");
            }
        } else if ($type == 2) {
            try {
                $insertcode = str_replace("INTO $table", "INTO $usertable", $code);
                $query = $conn->query($insertcode);
                $checkresultcode = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $checkresult = $conn->query($checkresultcode);
                if ($checkresult->num_rows == 1) {
                    if ($code == $loadresult['answercode']) {
                        $score = 2;
                    } else {
                        $score = 1;
                    }
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'msg' => 'Correct',
                            'score' => $score,
                            'userid' => $_SESSION['userid'],
                            'quizid' => $quizid
                        )
                    );
                    $droptable = $conn->query("DROP TABLE $usertable");
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                    $droptable = $conn->query("DROP TABLE $usertable");
                }
            } catch (Exception $e) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                $droptable = $conn->query("DROP TABLE $usertable");
            }
        } else if ($type == 3) {
            try {
                $deletecode = str_replace("FROM $table", "FROM $usertable", $code);
                $query = $conn->query($deletecode);
                $checkresultcode = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $checkresult = $conn->query($checkresultcode);
                if ($checkresult->num_rows == 0) {
                    if ($code == $loadresult['answercode']) {
                        $score = 2;
                    } else {
                        $score = 1;
                    }
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'msg' => 'Correct',
                            'score' => $score,
                            'userid' => $_SESSION['userid'],
                            'quizid' => $quizid
                        )
                    );
                    $droptable = $conn->query("DROP TABLE $usertable");
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                    $droptable = $conn->query("DROP TABLE $usertable");
                }
            } catch (Exception $e) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                $droptable = $conn->query("DROP TABLE $usertable");
            }
        } else {
            try {
                $updatecode = str_replace("UPDATE $table", "UPDATE $usertable", $code);
                $query = $conn->query($updatecode);
                $checkresultcode = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $checkresult = $conn->query($checkresultcode);
                if ($checkresult->num_rows == 1) {
                    if ($code == $loadresult['answercode']) {
                        $score = 2;
                    } else {
                        $score = 1;
                    }
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'msg' => 'Correct',
                            'score' => $score,
                            'userid' => $_SESSION['userid'],
                            'quizid' => $quizid
                        )
                    );
                    $droptable = $conn->query("DROP TABLE $usertable");
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                    $droptable = $conn->query("DROP TABLE $usertable");
                }
            } catch (Exception $e) {
                echo json_encode(array('status' => 'error', 'msg' => 'คำตอบของคุณไม่ถูกต้อง!'));
                $droptable = $conn->query("DROP TABLE $usertable");
            }
        }
    }
}
?>