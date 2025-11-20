<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="../../webroot/css/bootstrap.min.css">-->

    <title>UMRED</title>
    <link rel="icon" href="<?php echo Router::url('img/LOGO UMRED FAV.jpg'); ?>" type="image/jpeg">

</head>
<body>
    <div class="topbar" style="position:static">
    <div class="topbar-inner">
        <div class="container">
           
        </div>
    </div>
    </div>

    <div class="container">
    <?php echo $this->Session->flash(); ?>    
    <?php echo $content_for_layout; ?>
    </div>
    <script src="../webroot/js/app.js"></script>
</body>
</html>