let table = document.getElementById('table');

table.addEventListener('change', function() {
    let tableName = table.value;
    
    $.ajax({
        type: 'POST',
        url: 'form_storage/select-data.php',
        data: {
            tableName: tableName
        },
        success: function (data) {
            if (tableName == "") {
                $('#selectData').html("");
            } else {
                $('#selectData').html(data);
            }
        }
    })
});