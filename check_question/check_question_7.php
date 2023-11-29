<?php
    session_start();

    include_once('../dbconnect.php');

    $code = $_POST['sqlCode'];

    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        try {
            $questionID = 7;
            $sql = "SELECT * FROM question WHERE questionID = '$questionID'";
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
                    if ($aRow['personID'] != $bRow['personID']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['firstname'] != $bRow['firstname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['lastname'] != $bRow['lastname']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['weight'] != $bRow['weight']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['height'] != $bRow['height']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else if ($aRow['genderID'] != $bRow['genderID']) {
                        echo json_encode(array('status' => 'error', 'msg' => 'Your result is incorrect!'));
                        break;
                    } else {
                        if ($count < mysqli_num_rows($aResult)) {
                            $count++;
                            continue;
                        } else {
                            echo json_encode(array('status' => 'success', 'msg' => 'Your result is correct!'));

                            if (isset($_SESSION['userID'])) {
                                $userID = $_SESSION['userID'];
                                $checkscore = "SELECT * FROM score WHERE userID = '$userID' AND questionID = '$questionID'";
                                $queryscore = mysqli_query($conn, $checkscore);
                                
                                if (mysqli_num_rows($queryscore) == 0) {
                                    $score = 1;
                                    $insertScore = "INSERT INTO score(score, userID, questionID) VALUES('$score', '$userID', '$questionID')";
                                    $queryscore = mysqli_query($conn, $insertScore);
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    }
?>