<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Process Data</title>
<style>
  body { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
</style>
</head>
<body>
<!-- Data form diterima sebagai array asosiatif $_POST, diproses dengan FOREACH -->
<div>
<h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";

//$surname = $_POST['surname'];
?>
</div>
</body>
</html>
