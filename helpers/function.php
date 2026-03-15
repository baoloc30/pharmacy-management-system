<?php
function formatCurrency($number) {
    return number_format($number, 0, ',', '.') . 'đ';
}

function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

function generateCode($prefix) {
    return $prefix . date('YmdHis') . rand(100, 999);
}

function redirect($url) {
    header('Location: ' . BASE_URL . $url);
    exit();
}

function isAdmin() {
    return Session::get('role') == 'QuanLy';
}