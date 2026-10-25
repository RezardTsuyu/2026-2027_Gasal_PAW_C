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
<?php
require 'validate.inc';
$errors = array();
validateName($errors, $_POST, 'surname');
if ($errors)
{
    echo 'Errors:<br/>';
    foreach ($errors as $field => $error)
        echo "$field $error</br>";
}
else
    echo 'Data OK!';
?>
</body>
</html>
