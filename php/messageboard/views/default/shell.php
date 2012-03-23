<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/parts/main.css" />

<?php
    echo "<title>" . $view['pagename'] . " | Message Board</title>";
?>
    <script type="text/javascript" src="/parts/jquery-1.5.2.min.js"></script>

    <?php echo $view['headerContent'] ?>

</head>
<body>
    <div id="header"><?php echo view::show('standard/header'); ?></div>
    <div id="body">
    <div class="sidebar">
    </div>
    <?php echo $view['body'] ?>
    </div>
    <div id="footer"><?php echo view::show('standard/footer'); ?></div>
</body>
</html>