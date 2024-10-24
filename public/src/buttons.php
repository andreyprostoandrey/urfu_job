<?php

require_once 'functions.php';

// Переключатель кнопок на сайте
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'my-replies':
                redirect('/my-replies.php');
                break;
            case 'job-create':
                redirect('/job-create.php');
                break;
            case 'job-search':
                redirect('/job-search.php');
                break;
            case 'jobs':
                redirect('/jobs.php');
                break;
            case 'home':
                redirect('/home.php');
                break;
            case 'logout':
                logout();
                break;
            case 'admin':
                redirect('/admin.php');
                break;
            case 'jobs-admin':
                redirect('/jobs-admin.php');
                break;
            case 'replies-admin':
                redirect('/replies-admin.php');
                break;
            default:
            redirect('/');
                break;
        }
    }
}