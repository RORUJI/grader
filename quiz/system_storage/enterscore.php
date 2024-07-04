<?php
session_start();
include_once '../../dbconnect.php';
date_default_timezone_set('Asia/Bangkok');

$score = $_POST['score'];
$userid = $_POST['userid'];
$quizid = $_POST['quizid'];
$recordtime = date('Y-m-d h:i:sa');

$sql = "SELECT * FROM score WHERE userid = '$userid' AND quizid = '$quizid'";
$query = $conn->query($sql);

if ($query->num_rows == 0) {
    $sql = "INSERT INTO score(score, recordtime, userid, quizid) VALUES(?, ?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('isii', $score, $recordtime, $userid, $quizid);
    $result = $statement->execute();
} else {
    $result = $query->fetch_assoc();
    
    if ($result['score'] < 2) {
        
    } else {
        
    }
}

$sql = "UPDATE score SET score = $score, recordtime = '$recordtime' WHERE userid = '$userid' AND quizid = '$quizid'";
$query = $conn->query($sql);
?>