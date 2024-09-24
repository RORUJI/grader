<?php
session_start();

include_once "../../dbconnect.php";

function changeCase($input, $wordsToUpper)
{
    foreach ($wordsToUpper as $word) {
        $pos = stripos($input, $word);
        if ($pos !== false) {
            $input = substr_replace($input, strtoupper($word), $pos, strlen($word));
        }
    }
    return $input;
}

function trimWhitespace($input)
{
    $trimmed = trim($input);
    $formatted = preg_replace('/\s+/', ' ', $trimmed);
    $formatted = preg_replace('/\s*\(\s*/', '(', $formatted);
    return $formatted;
}

function extractTableName($sql)
{
    if (stripos($sql, "DELETE")) {
        preg_match('/DELETE FROM\s+(\w+)/i', $sql, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    } else {
        preg_match('/UPDATE\s+(\w+)/i', $sql, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}

if (!isset($_SESSION['userid'])) {
    header("Location: ../../system/logout_system.php");
} else if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../../all_quiz.php");
} else {
    $quizId = $_POST['quizId'];
    $typeId = $_POST['typeId'];
    $code = $_POST['code'];

    if ($code == "") {
        echo json_encode(
            array(
                "status" => "error",
                "title" => "ล้มเหลว",
                "text" => "คุณยังไม่ได้กรอก Code"
            )
        );
    } else {
        if ($typeId == 1) {
            try {
                $queryUserCode = $conn->query($code);

                $sqlQuiz = "SELECT * FROM quiz WHERE quizid = $quizId LIMIT 1";
                $queryQuiz = $conn->query($sqlQuiz);
                $resultQuiz = $queryQuiz->fetch_assoc();

                $result_check_code = $resultQuiz['resultcode'];
                $answer_check_code = $resultQuiz['answercode'];
                $query_system = $conn->query($result_check_code);

                while ($row_system = $query_system->fetch_assoc()) {
                    foreach ($row_system as $key => $value) {
                        $system_item[] = $value;
                    }
                }

                while ($row_user = $queryUserCode->fetch_assoc()) {
                    foreach ($row_user as $key => $value) {
                        $user_item[] = $value;
                    }
                }

                $code = preg_replace("/\s+/", " ", $code);
                $code = trim($code);

                if (count($system_item) != count($user_item)) {
                    echo json_encode(
                        array(
                            "status" => "error",
                            "title" => "ล้มเหลว",
                            "text" => "คำตอบของคุณไม่ถูกต้อง"
                        )
                    );
                } else {
                    for ($i = 0; $i < count($system_item); $i++) {
                        if ($system_item[$i] == $user_item[$i]) {
                            $array = array(
                                "status" => "success",
                                "title" => "สำเร็จ",
                                "text" => "คำตอบของคุณถูกต้อง"
                            );
                            continue;
                        } else {
                            $array = array(
                                "status" => "error",
                                "title" => "ล้มเหลว",
                                "text" => "คำตอบของคุณไม่ถูกต้อง"
                            );
                            break;
                        }
                    }

                    if ($array["status"] == "success") {
                        $check_score = "SELECT * FROM score WHERE userid = $_SESSION[userid] AND quizid = $quizId";
                        $query_check_score = $conn->query($check_score);
                        $check_score_result = $query_check_score->fetch_assoc();

                        if ($check_score_result['score'] != 2) {
                            if (strcasecmp($answer_check_code, $code) === 0) {
                                $score = 2;
                            } else {
                                $score = 1;
                            }
                            $score_update = "UPDATE score SET score = $score WHERE userid = $_SESSION[userid] 
                                        AND quizid = $quizId";
                            $stmt = $conn->prepare($score_update);
                            $stmt->execute();
                        } else {

                        }
                        echo json_encode($array);
                    } else {
                        echo json_encode($array);
                    }
                }
            } catch (Exception $e) {
                $array = array(
                    "status" => "error",
                    "title" => "ล้มเหลว",
                    "text" => "คำตอบของคุณไม่ถูกต้อง"
                );
                echo json_encode($array);
            }
        } else if ($typeId == 2) {
            include_once "create_temptable.php";
            $wordsToUpper = ["insert", "into", "values"];

            $modified = changeCase($code, $wordsToUpper);
            $modified = trimWhitespace($modified);

            if (stripos($modified, "INSERT") !== false) {
                $result_check_code = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $tableName = preg_replace('/INSERT INTO (\w+)\(.*/', '$1', $loadresult['answercode']);
                $insertinto_temptable_code = str_replace("INTO $tableName", "INTO $usertable", $modified);
                try {
                    $stmt = $conn->prepare($insertinto_temptable_code);

                    if ($stmt->execute()) {
                        $result_check = $conn->query($result_check_code);

                        if ($result_check->num_rows == 1) {
                            $array = array(
                                "status" => "success",
                                "title" => "สำเร็จ",
                                "text" => "คำตอบของคุณถูกต้อง"
                            );

                            $score_update = "UPDATE score SET score = 2 WHERE userid = $_SESSION[userid] AND quizid = $quizId";
                            $stmt = $conn->prepare($score_update);
                            $stmt->execute();
                        } else {
                            $array = array(
                                "status" => "error",
                                "title" => "ล้มเหลว",
                                "text" => "คำตอบของคุณไม่ถูกต้อง"
                            );
                        }
                    } else {
                        $array = array(
                            "status" => "error",
                            "title" => "ล้มเหลว",
                            "text" => "คำตอบของคุณไม่ถูกต้อง"
                        );
                    }
                } catch (Exception $e) {
                    $array = array(
                        "status" => "error",
                        "title" => "ล้มเหลว",
                        "text" => "คำตอบของคุณไม่ถูกต้อง"
                    );
                }
            } else {
                $array = array(
                    "status" => "error",
                    "title" => "ล้มเหลว",
                    "text" => "คำตอบของคุณไม่ถูกต้อง"
                );
            }
            $delete_temptable = $conn->query("DROP TABLE $usertable");
            echo json_encode(value: $array);
        } else if ($typeId == 3) {
            include_once "create_temptable.php";
            $wordsToUpper = ["delete", "from", "where"];

            $modified = changeCase($code, $wordsToUpper);
            $modified = trimWhitespace($modified);

            if (strpos($modified, "DELETE") !== false) {
                $result_check_code = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $tableName = extractTableName($loadresult['answercode']);
                $deletefrom_temptable_code = str_replace("FROM $tableName", "FROM $usertable", $modified);

                try {
                    $stmt = $conn->prepare($deletefrom_temptable_code);

                    if ($stmt->execute()) {
                        $result_check = $conn->query($result_check_code);

                        if ($result_check->num_rows == 0) {
                            $array = array(
                                "status" => "success",
                                "title" => "สำเร็จ",
                                "text" => "คำตอบของคุณถูกต้อง"
                            );

                            $score_update = "UPDATE score SET score = 2 WHERE userid = $_SESSION[userid] AND quizid = $quizId";
                            $stmt = $conn->prepare($score_update);
                            $stmt->execute();
                        } else {
                            $array = array(
                                "status" => "error",
                                "title" => "ล้มเหลว",
                                "text" => "คำตอบของคุณไม่ถูกต้อง"
                            );
                        }
                    } else {
                        $array = array(
                            "status" => "error",
                            "title" => "ล้มเหลว",
                            "text" => "คำตอบของคุณไม่ถูกต้อง"
                        );
                    }
                } catch (Exception $e) {
                    $array = array(
                        "status" => "error",
                        "title" => "ล้มเหลว",
                        "text" => "คำตอบของคุณไม่ถูกต้อง"
                    );
                }
            } else {
                $array = array(
                    "status" => "error",
                    "title" => "ล้มเหลว",
                    "text" => "คำตอบของคุณไม่ถูกต้อง"
                );
            }
            echo json_encode(value: $array);
            $delete_temptable = $conn->query("DROP TABLE $usertable");
        } else {
            include_once "create_temptable.php";
            $wordsToUpper = ["update", "set", "where"];

            $modified = changeCase($code, $wordsToUpper);
            $modified = trimWhitespace($modified);

            if (strpos($modified, "UPDATE") !== false) {
                $result_check_code = str_replace("\$usertable", $usertable, $loadresult['resultcode']);
                $tableName = extractTableName($loadresult['answercode']);
                $update_temptable_code = str_replace("UPDATE $tableName", "UPDATE $usertable", $modified);

                try {
                    $stmt = $conn->prepare($update_temptable_code);

                    if ($stmt->execute()) {
                        $result_check = $conn->query($result_check_code);

                        if ($result_check->num_rows == 1) {
                            $array = array(
                                "status" => "success",
                                "title" => "สำเร็จ",
                                "text" => "คำตอบของคุณถูกต้อง"
                            );

                            $score_update = "UPDATE score SET score = 2 WHERE userid = $_SESSION[userid] AND quizid = $quizId";
                            $stmt = $conn->prepare($score_update);
                            $stmt->execute();
                        } else {
                            $array = array(
                                "status" => "error",
                                "title" => "ล้มเหลว",
                                "text" => "คำตอบของคุณไม่ถูกต้อง"
                            );
                        }
                    } else {
                        $array = array(
                            "status" => "error",
                            "title" => "ล้มเหลว",
                            "text" => "คำตอบของคุณไม่ถูกต้อง"
                        );
                    }
                } catch (Exception $e) {
                    $array = array(
                        "status" => "error",
                        "title" => "ล้มเหลว",
                        "text" => "คำตอบของคุณไม่ถูกต้อง"
                    );
                }
            } else {
                $array = array(
                    "status" => "error",
                    "title" => "ล้มเหลว",
                    "text" => "คำตอบของคุณไม่ถูกต้อง"
                );
            }
            $delete_temptable = $conn->query("DROP TABLE $usertable");
            echo json_encode(value: $array);
        }
    }
}
?>