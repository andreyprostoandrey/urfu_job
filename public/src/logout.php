<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    logout();
}

redirect('/');