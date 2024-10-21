<?php

session_start();

function redirect(string $path) {
    header("Location: $path");
    die();
}

function has_validation_error(string $field_name) {
    return isset($_SESSION['validation'][$field_name]);
}

function validation_error_attr(string $field_name) {
    echo isset($_SESSION['validation'][$field_name]) ? 'aria-invalid="true"' : '';
}

function validation_error_message(string $field_name) {
    echo $_SESSION['validation'][$field_name] ?? '';
}

function clear_validation() {
    $_SESSION['validation'] = [];
}

function add_validation_error(string $field_name, string $message) {
    $_SESSION['validation'][$field_name] = $message;
}