<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Grader</title>
</head>
    
<body class="">
    <div class="row bg-warning" style="height:10vh; width: 100.8%"></div>
    <div class="row" style="height: 90vh; width: 100.8%">
        <div class="col-3 bg-primary" >
            <a href="#" class="link-a"><i class="bi bi-house-fill"></i> Home</a>
            <a href="#" class="link-a">Home</a>
            <a href="#" class="link-a">Home</a>
            <a href="#" class="link-a">Home</a>
        </div>
        <div class="col bg-success">
            <div class="graph col bg-danger"></div>
            <div class="row">
                <a href="grader_question.php" class="graph1 col mx-3"><div class="div-1">SQL</div></a>
                <a href="" class="graph2 col mx-3"><div class="div-2">ss</div></a>
            </div>
        </div>
        <div class="col-3 bg-danger">
            <h2>Column 3</h2>
            <p>Test</p>
        </div>
    </div>
</body>

</html>