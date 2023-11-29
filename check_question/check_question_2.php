<?php
    include_once('../dbconnect.php');

    $code = $_POST['sqlCode'];

    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        try {
            $sql = "SELECT * FROM question WHERE questionID = 2";
            $query = mysqli_query($conn, $sql);
            $question = mysqli_fetch_assoc($query);

            $aResult = mysqli_query($conn, $question['code']);
            $bResult = mysqli_query($conn, $code);

            if (mysqli_num_fields($aResult) != mysqli_num_fields($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
            } else if (mysqli_num_rows($aResult) != mysqli_num_rows($bResult)) {
                echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
            } else {
                $count = 1;

                while (($aRow = mysqli_fetch_assoc($aResult)) && ($bRow = mysqli_fetch_assoc($bResult))) {
                    if ($aRow['firstname'] != $bRow['firstname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                    } else if ($aRow['lastname'] != $bRow['lastname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                    } else {
                        if ($count < mysqli_num_rows($aResult)) {
                            $count++;
                            continue;
                        } else {
                            echo json_encode(array('status' => 'success', 'msg' => 'Your result is correct!'));
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    }
?>