<?php
function validateRequired($field, $value) {
    return !empty(trim($value)) ? '' : "$field không được để trống";
}

function validatePhone($phone) {
    if(empty($phone)) return '';
    return preg_match('/^[0-9]{10}$/', $phone) ? '' : 'Số điện thoại không hợp lệ';
}

function validateEmail($email) {
    if(empty($email)) return '';
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? '' : 'Email không hợp lệ';
}

function validatePrice($price) {
    return is_numeric($price) && $price > 0 ? '' : 'Giá phải là số dương';
}