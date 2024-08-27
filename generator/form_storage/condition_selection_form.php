<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['condition-checkbox'])) {
    $table = $_POST['table'];
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <input type="hidden" id="table" value="<?php echo $table; ?>">
        <div class="row">
            <div class="mb-3">
                <div class="input-group input-group-sm" style="width: 190px;">
                    <span class="input-group-text">จำนวนของเงื่อนไข</span>
                    <select name="clauseCount" id="clauseCount" class="form-select form-select-sm">
                        <option value="">?</option>
                        <?php
                        $clauseCount = 1;
                        while ($clauseCount <= 5):
                            ?>
                            <option value="<?php echo $clauseCount; ?>"><?php echo $clauseCount; ?></option>
                            <?php
                            $clauseCount++;
                        endwhile;
                        ?>
                    </select>
                </div>

            </div>
        </div>

        <div class="row" id="clauseField"></div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $('#clauseCount').change(function () {
                let table = document.getElementById('table');
                table = table.value;
                let clauseCountValue = clauseCount.value;
                console.log(clauseCountValue);
                $.ajax({
                    type: "POST",
                    url: "form_storage/clause-form.php",
                    data: {
                        count: clauseCountValue,
                        table: table
                    },
                    success: function (data) {
                        $('#clauseField').html(data)
                    }
                });
            });
        </script>
    </body>

    </html>

<?php } ?>