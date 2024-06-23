<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];

if (!empty($type) && !empty($table)) {
    if ($type == 1) {
        include_once "../select_generator.php";
    } else if ($type == 2) {
        include_once "../insert_generator.php";
    } else if ($type == 3) {
        include_once "../delete_generator.php";
    } else {
        include_once "../update_generator.php";
    }
}
?>

<script>
    $('#all-request').click(function () {
        $('.request-data').prop('disabled', $('#all-request').is(':checked'));
    });
</script>