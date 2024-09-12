<?php
session_start();

include_once "../../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['userId'])) {
        echo json_encode(array(
            'status' => 'error',
            'title' => 'ผิดพลาด',
            'text' => 'กรุณาเลือกนักเรียนที่ต้องการให้ทำโจทย์นี้ด้วย'
        ));
    } else {
        $quizId = $_POST['quizId'];
        $userId = $_POST['userId'];
        $sql = "INSERT INTO score (userid, quizid) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        } else {
            for ($i = 0; $i < count($userId); $i++) {
                $stmt->bind_param("ii", $userId[$i], $quizId);
                $stmt->execute();
            }

            $stmt->close();
            $conn->close();

            echo json_encode(array(
                'status' => 'success',
                'title' => 'สำเร็จ',
                'text' => 'กำหนดนักเรียนที่จะทำโจทย์นี้เรียบร้อยแล้ว'
            ));
        }
    }
} else {
    echo "No interests selected.";
}
?>