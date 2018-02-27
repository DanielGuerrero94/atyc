<html>
<head>
</head>
<body>
</body>
<script type="text/javascript">
	location.href = <?php
    preg_match_all('/\/(\w+)$/', __DIR__, $app_path);
    echo '"'.$app_path[0][0].'/public'.'"';
    ?>
</script>
</html>
