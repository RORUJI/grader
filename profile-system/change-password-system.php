<?php
session_start();

include_once "../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../change-password.php");
} else {
    $userId = $_SESSION['userid'];
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];

    if ($old_password == "") {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "กรุณาใส่ password ของคุณ"
            )
        );
    } else if ($new_password == "") {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "กรุณาใส่ password ของคุณ"
            )
        );
    } else {
        $userData = "SELECT * FROM user WHERE userid = $userId";
        $queryUserData = $conn->query($userData);
        $currentUser = $queryUserData->fetch_assoc();
        $old_password = md5($old_password);

        if ($old_password != $currentUser['password']) {
            echo json_encode(
                array(
                    "status" => "error",
                    "msg" => "Password ของคุณไม่ถูกต้อง"
                )
            );
        } else {
            $new_password = md5($new_password);
            $sql = "UPDATE user SET password = ? WHERE userid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_password, $userId);
            $stmt->execute();

            if ($stmt) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "msg" => "เปลี่ยน Password สำเร็จ"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "msg" => "เปลี่ยน Password ไม่สำเร็จ"
                    )
                );
            }
        }
    }
}
?>