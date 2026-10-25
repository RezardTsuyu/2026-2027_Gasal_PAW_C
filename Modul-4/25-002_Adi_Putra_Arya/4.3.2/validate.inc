<?php
// Langkah 4 (modul): validasi surname, pesan error disimpan di array $errors
function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet)
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

// ---------------------------------------------------------------
// Langkah 9: validasi server-side untuk field masukan yang lain
// ---------------------------------------------------------------
function validateEmail(&$errors, $field_list, $field_name)
{
    $pattern = '/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i'; // format email
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (!preg_match($pattern, $field_list[$field_name]))
        $errors[$field_name] = 'invalid';
}

function validatePassword(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
        $errors[$field_name] = 'required';
    else if (strlen($field_list[$field_name]) < 6)
        $errors[$field_name] = 'too short (minimum 6 characters)';
}

function validateAddress(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '')
        $errors[$field_name] = 'required';
}

function validateState(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || $field_list[$field_name] === '-1')
        $errors[$field_name] = 'required (please choose your state)';
    else if (!in_array($field_list[$field_name], array('1', '2', '3', '4', '5', '6', '7', '8'), true))
        $errors[$field_name] = 'invalid';
}

function validateGender(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]))
        $errors[$field_name] = 'required (please choose one)';
    else if (!in_array($field_list[$field_name], array('male', 'female'), true))
        $errors[$field_name] = 'invalid';
}
?>
