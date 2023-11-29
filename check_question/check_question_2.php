<?php
    include_once('../dbconnect.php');

    $code = $_POST['sqlCode'];

    if ($code == "") {
        echo json_encode(array('status' => 'error', 'msg' => 'Please enter your code.'));
    } else {
        try {
           
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'msg' => 'Something went wrong, please try again!'));
        }
    }
?>