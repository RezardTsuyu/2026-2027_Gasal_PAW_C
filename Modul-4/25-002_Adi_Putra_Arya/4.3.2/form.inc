<?php
// Langkah 7: bila validasi gagal, tiap field diisi kembali dengan data
// yang sebelumnya dikirim ($_POST). htmlspecialchars() mencegah tanda kutip
// atau tag HTML pada isian merusak tampilan form.
function oldValue($name)
{
    return (isset($_POST[$name]) && is_string($_POST[$name]))
        ? htmlspecialchars($_POST[$name], ENT_QUOTES) : '';
}

function isSelected($name, $value, $default = false)
{
    if (isset($_POST[$name]))
        return ($_POST[$name] === $value) ? ' selected' : '';
    return $default ? ' selected' : '';
}

function isChecked($name, $value)
{
    return (isset($_POST[$name]) && $_POST[$name] === $value) ? ' checked' : '';
}
?>
<fieldset>
<legend>Person Details</legend>
<form name="myForm" action="processData_form.php" method="POST">
  <div class="field">
    <label for="surname">Surname</label>
    <input type="text" name="surname" size="31" value="<?php echo oldValue('surname'); ?>"/>
  </div>
  <div class="field">
    <label for="email">Email address</label>
    <input type="text" name="email" size="31" value="<?php echo oldValue('email'); ?>"/>
  </div>
  <div class="field">
    <label for="passwd">Password</label>
    <input type="password" name="passwd" size="31"/>
  </div>
  <div class="field">
    <label for="address">Street Address</label>
    <textarea name="address" rows="3" cols="22"><?php echo oldValue('address'); ?></textarea>
  </div>
  <div class="field">
    <label for="state">State</label>
    <select name="state">
      <option value="-1"<?php echo isSelected('state', '-1', true); ?>>[choose your state]</option>
      <option value="1"<?php echo isSelected('state', '1'); ?>>Australian Capital Territory</option>
      <option value="2"<?php echo isSelected('state', '2'); ?>>Queensland</option>
      <option value="3"<?php echo isSelected('state', '3'); ?>>Victoria</option>
      <option value="4"<?php echo isSelected('state', '4'); ?>>New South Wales</option>
      <option value="5"<?php echo isSelected('state', '5'); ?>>Tasmania</option>
      <option value="6"<?php echo isSelected('state', '6'); ?>>South Australia</option>
      <option value="7"<?php echo isSelected('state', '7'); ?>>Western Australia</option>
      <option value="8"<?php echo isSelected('state', '8'); ?>>Northern Territory</option>
    </select>
  </div>
  <div class="field">
    <input type="hidden" name="country" value="Australia">
  </div>
  <div class="field">
    <label for="sex">Gender</label>
    <input type="radio" name="sex" value="male"<?php echo isChecked('sex', 'male'); ?>/>Male
    <input type="radio" name="sex" value="female"<?php echo isChecked('sex', 'female'); ?>/>Female
  </div>
  <div class="field">
    <label for="vegetarian">Vegetarian?</label>
    <input type="checkbox" name="vegetarian"<?php echo isChecked('vegetarian', 'on'); ?> />
  </div>
  <div class="field">
    <label>&nbsp;</label>
    <input type="submit" value="Submit" name="submit" /><input type="reset" value="Reset" name="reset" />
  </div>
</form>
</fieldset>
