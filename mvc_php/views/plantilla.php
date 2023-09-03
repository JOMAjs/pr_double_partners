<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>api rest</title>
    <link rel="stylesheet" href="views/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="views/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="views/plugins/toast/src/jquery.toast.css">
    <link href="views/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!--- script --->
    <script src="views/plugins/jquery/jquery.js"></script>
    <script src="views/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="views/plugins/toast/src/jquery.toast.js"></script>
    <script src="views/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="views/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="views/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="views/plugins/jquery-validation/additional-methods.min.js"></script>
</head>

<body>
    <?php
    include "pages/header.php";

    if (isset($_GET["pages"])) {

        if ($_GET["pages"] == "cuenta") {

            include "pages/cuenta.php";
        }

    } else {

        include "pages/cuenta.php";
    }
    ?>

</body>

</html>