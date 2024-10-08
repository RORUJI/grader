<?php
session_start();

include_once "../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../edit-profile.php");
} else {
    $userId = $_SESSION['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    if ($username == "") {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "กรุณาใส่ username ของคุณ"
            )
        );
    } else if ($email == "") {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "กรุณาใส่ email ของคุณ"
            )
        );
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "Email ของคุณไม่เป็นไปตามรูปแบบ"
            )
        );
    } else if ($tel == "") {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "กรุณาใส่เบอร์โทรศัพท์ของคุณ"
            )
        );
    } else if (substr($tel, 0, 1) != 0 || strlen($tel) != 10) {
        echo json_encode(
            array(
                "status" => "error",
                "msg" => "เบอร์โทรศัพท์ของคุณไม่เป็นไปตามรูปแบบ"
            )
        );
    } else {
        $userData = "SELECT * FROM user WHERE userid = $userId";
        $queryUserData = $conn->query($userData);
        $currentUser = $queryUserData->fetch_assoc();

        $isUsernameTaken = false;
        $isEmailTaken = false;
        $isTelTaken = false;

        if ($username !== $currentUser['username']) {
            $sql = "SELECT COUNT(*) FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $isUsernameTaken = $count > 0;
            $stmt->close();
        }

        if ($email !== $currentUser['email']) {
            $sql = "SELECT COUNT(*) FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $isEmailTaken = $count > 0;
            $stmt->close();
        }

        if ($tel !== $currentUser['tel']) {
            $sql = "SELECT COUNT(*) FROM user WHERE tel = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $tel);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $isTelTaken = $count > 0;
            $stmt->close();
        }

        if ($isUsernameTaken) {
            echo json_encode(
                array(
                    "status" => "error",
                    "msg" => "Username นี้ถูกใช้งานแล้ว"
                )
            );
        } elseif ($isEmailTaken) {
            echo json_encode(
                array(
                    "status" => "error",
                    "msg" => "Email นี้ถูกใช้งานแล้ว"
                )
            );
        } elseif ($isTelTaken) {
            echo json_encode(
                array(
                    "status" => "error",
                    "msg" => "เบอร์โทรศัพท์นี้ถูกใช้งานแล้ว"
                )
            );
        } else {
            $sql = "UPDATE user SET username = ?, email = ?, tel = ? WHERE userid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $tel, $userId);
            $stmt->execute();

            if ($stmt) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "msg" => "แก้ไข Profile สำเร็จ"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "msg" => "แก้ไข Profile ไม่สำเร็จ"
                    )
                );
            }
            $stmt->close();
        }
    }
}
?>