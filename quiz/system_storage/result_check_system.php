<?php
session_start();

include_once "../../dbconnect.php";

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
        try {
            $queryUserCode = $conn->query($code);

            if ($typeId == 1) {
                $sqlQuiz = "SELECT * FROM quiz WHERE quizid = $quizId LIMIT 1";
                $queryQuiz = $conn->query($sqlQuiz);
                $resultQuiz = $queryQuiz->fetch_assoc();

                $result_check_code = $resultQuiz['resultcode'];
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
                    echo json_encode($array);
                }

            }
        } catch (Exception $e) {
            echo json_encode(
                array(
                    "status" => "error",
                    "title" => "ล้มเหลว",
                    "text" => "คำตอบของคุณไม่ถูกต้อง"
                )
            );
        }
    }
}
?>