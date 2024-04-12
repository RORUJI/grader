const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwtich = body.querySelector(".toggle-switch")
    modeText = body.querySelector(".mode-text");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    modeSwtich.addEventListener("click", () => {
        body.classList.toggle("dark");

        if(body.classList.contains("dark")){
            modeText.innerText = "Light Mode"
        }else{
            modeText.innerText = "Drak Mode"
        }
    });

    $(document).ready(function () {
        $('#codeForm').submit(function (e) {
            e.preventDefault();
            let formUrl = $(this).attr('action');
            let reqMethod = $(this).attr('method');
            let formData = $(this).serialize();
            $.ajax ({
                type: reqMethod,
                url: formUrl,
                data: formData,
                success: function (data) {
                    let result = JSON.parse(data);
                    if (result.status == 'success') {
                        Swal.fire ({
                            icon: result.status,
                            title: 'สำเร็จ!',
                            text: result.msg
                        });
                    } else {
                        Swal.fire ({
                            icon: result.status,
                            title: 'สำเร็จ!',
                            text: result.msg
                        });
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $('#type, #table').on('change', function (e) {
            e.preventDefault();
            let type = $('#type').val();
            let table = $('#table').val();
            $.ajax({
                type: 'POST',
                url: 'system_storage/selection_table.php',
                data: {
                    type: type,
                    table: table
                },
                success: function (data) {
                    if (type == "" || table == "") {
                        $('#input-field').html('');
                    } else {
                        $('#input-field').html(data);
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $('#generatorForm').submit(function (e) {
            e.preventDefault();
            let formUrl = $(this).attr('action');
            let reqMethod = $(this).attr('method');
            let formData = $(this).serialize();

            $.ajax({
                type: reqMethod,
                url: formUrl,
                data: formData,
                success: function (data) {
                    let result = JSON.parse(data);

                    if (result.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: result.msg,
                            showConfirmButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'ดูผลลับ',
                            cancelButtonText: 'แก้ไข',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33'
                        }).then(function (r) {
                            if (r.isConfirmed) {
                                if (result.type == 1) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'form_storage/question_detail_form.php',
                                        data: {
                                            type: result.type,
                                            question: result.question,
                                            selectSQL: result.selectSQL
                                        },
                                        success: function (data) {
                                            $('#input-field').html(data);
                                            $('#type-select').remove();
                                            $('#table-select').remove();
                                        }
                                    });
                                } else if (result.type == 2) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'form_storage/question_detail_form.php',
                                        data: {
                                            type: result.type,
                                            question: result.question,
                                            selectSQL: result.selectSQL,
                                            insertSQL: result.insertSQL,
                                            deleteSQL: result.deleteSQL
                                        },
                                        success: function (data) {
                                            $('#input-field').html(data);
                                            $('#type-select').remove();
                                            $('#table-select').remove();
                                        }
                                    });
                                } else if (result.type == 3) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'form_storage/question_detail_form.php',
                                        data: {
                                            type: result.type,
                                            question: result.question,
                                            selectSQL: result.selectSQL,
                                            insertSQL: result.insertSQL,
                                            deleteSQL: result.deleteSQL
                                        },
                                        success: function (data) {
                                            $('#input-field').html(data);
                                            $('#type-select').remove();
                                            $('#table-select').remove();
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'form_storage/question_detail_form.php',
                                        data: {
                                            type: result.type,
                                            question: result.question,
                                            selectSQL: result.selectSQL,
                                            beforeSQL: result.beforeSQL,
                                            insertSQL: result.insertSQL,
                                            updateSQL: result.updateSQL
                                        },
                                        success: function (data) {
                                            $('#input-field').html(data);
                                            $('#type-select').remove();
                                            $('#table-select').remove();
                                        }
                                    });
                                }
                            } else {

                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ล้มเหลว!',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });
    });