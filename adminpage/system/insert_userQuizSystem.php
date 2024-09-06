<?php
session_start();

include_once "../../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['userId']) && !is_array($_POST['userId'])) {
        header("location: ../home");
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
        }
    }
} else {
    echo "No interests selected.";
}
?>