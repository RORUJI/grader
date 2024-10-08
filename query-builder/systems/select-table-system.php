<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];

if (!empty($type) && !empty($table)) {
    if ($type == 1) {
        include_once "../forms/select-builder-form.php";
    } else if ($type == 2) {
        include_once "../forms/insert-builder-form.php";
    } else if ($type == 3) {
        include_once "../forms/delete-builder-form.php";
    } else {
        include_once "../forms/update-builder-form.php";
    }
}
?>

<script>
    $('#all-request').click(function () {
        $('.request-data').prop('disabled', $('#all-request').is(':checked'));
    });
</script>