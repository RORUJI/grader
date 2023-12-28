<?php
session_start();
include_once "../dbconnect.php";
$typeID = $_POST['type'];
$quizID = $_POST['questionID'];
$code = $_POST['sqlCode'];
$sql = "SELECT * FROM question WHERE questionID = '$quizID'";
$query = $conn->query($sql);
$answer = $query->fetch_assoc();
if ($code == "") {
    echo json_encode(array('status' => 'error', 'msg' => 'กรุณากรอก Code ของคุณ'));
} else {
    if ($typeID == 1) {
        try {
            $userInput = $conn->query($code);
            $selectSQL = $conn->query($answer['select_code']);
            if ($userInput->num_rows != $selectSQL->num_rows) {
                echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
            } else if ($userInput->field_count != $selectSQL->field_count) {
                echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
            } else {
                $count = 1;
                while (($userSQL = $userInput->fetch_array()) && ($answerSQL = $selectSQL->fetch_array())) {
                    if ($count < $userInput->num_rows) {
                        for ($i = 0; $i < $userInput->field_count; $i++) {
                            if ($userSQL[$i] != $answerSQL[$i]) {
                                echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                                break 2;
                            } else {
                                continue;
                            }
                        }
                    } else {
                        echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                    }
                    $count++;
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    } else if ($typeID == 2) {
        try {
            $selectSQL = $conn->query($answer['select_code']);
            if ($selectSQL->num_rows > 0) {
                $deleteSQL = $conn->query($answer['delete_code']);
                if ($deleteSQL) {
                    $userInput = $conn->query($code);
                    if ($userInput) {
                        $selectSQL = $conn->query($answer['select_code']);
                        if ($selectSQL->num_rows > 0) {
                            echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                        }
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                }
            } else {
                $userInput = $conn->query($code);
                if ($userInput) {
                    $selectSQL = $conn->query($answer['select_code']);
                    if ($selectSQL->num_rows > 0) {
                        echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    } else if ($typeID == 3) {
        try {
            $selectSQL = $conn->query($answer['select_code']);
            if ($selectSQL->num_rows < 1) {
                $insertSQL = $conn->query($answer['insert_code']);
                if ($insertSQL) {
                    $userInput = $conn->query($code);
                    if ($userInput) {
                        $selectSQL = $conn->query($answer['select_code']);
                        if ($selectSQL->num_rows < 1) {
                            echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                        }
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                }
            } else {
                $userInput = $conn->query($code);
                if ($userInput) {
                    $selectSQL = $conn->query($answer['select_code']);
                    if ($selectSQL->num_rows < 1) {
                        echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    } else {
        try {
            $selectSQL = $conn->query($answer['select_code']);
            if ($selectSQL->num_rows > 0) {
                $updateSQL = $conn->query($answer['update_code']);
                if ($updateSQL) {
                    $userInput = $conn->query($code);
                    if ($userInput) {
                        $selectSQL = $conn->query($answer['select_code']);
                        if ($selectSQL->num_rows > 0) {
                            echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                        }
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                }
            } else {
                $beforeSQL = $conn->query($answer['before_code']);
                if ($beforeSQL->num_rows > 0) {
                    $userInput = $conn->query($code);
                    if ($userInput) {
                        $selectSQL = $conn->query($answer['select_code']);
                        if ($selectSQL->num_rows > 0) {
                            echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                        }
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                    }
                } else {
                    $insertSQL = $conn->query($answer['insert_code']);
                    if ($insertSQL) {
                        $userInput = $conn->query($code);
                        if ($userInput) {
                            $selectSQL = $conn->query($answer['select_code']);
                            if ($selectSQL->num_rows > 0) {
                                echo json_encode(array('status' => 'success', 'msg' => 'Code ของคุณผลลัพธ์ถูกต้อง!'));
                            } else {
                                echo json_encode(array('status' => 'error', 'msg' => 'Code ของคุณผลลัพธ์ไม่ถูกต้อง!'));
                            }
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                        }
                    } else {
                        echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    }
}
?>