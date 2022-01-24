<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $PAGE_TITLE; ?></title>

    <!-- cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

    <!-- my css -->
    <link rel="stylesheet" href="<?php if (isset($MY_STYLE_PATH)) echo $MY_STYLE_PATH; else echo "";  ?>">

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/icon.png">
</head>

<body>
