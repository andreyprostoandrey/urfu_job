<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'job-create':
                redirect('/job-create.php');
                break;
            case 'jobs':
                redirect('/jobs.php');
                break;
            case 'logout':
                logout();
                break;
            default:
            redirect('/');
                break;
        }
    }
}