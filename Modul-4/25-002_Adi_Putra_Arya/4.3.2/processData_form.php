<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
<style>
  body { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
  fieldset { background-color: #ccccff; width: 460px; }
  .field { margin: 3px 0; }
  .field label { display: inline-block; width: 110px; text-align: right; margin-right: 6px; }
</style>
</head>
<body>
<h1>Register</h1>
<?php
  $errors = array();
  if (isset($_POST['surname']))
  {
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');

    // Langkah 9: validasi field masukan yang lain
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors)
    {
      echo '<h1>Invalid, correct the following errors:</h1>';
      foreach ($errors as $field => $error)
        echo "$field $error</br>";

      // tampilkan kembali form (dengan isian sebelumnya, lihat form.inc)
      include 'form.inc';
    }
    else
    {
      echo 'Form submitted successfully with no errors';
    }
  }
  else
    // tampilkan kembali form
    include 'form.inc';
?>
</body>
</html>
