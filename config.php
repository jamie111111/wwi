<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

ini_set('sendmail_from', 'jesse.spenkelink@gmail.com');
ini_set('smtp_port', '587');
ini_set('SMTP', 'smtp.gmail.com');
ini_set('sendmail_path', "/usr/sbin/sendmail -t -i");

$config = array(
    "mollie" => array(
        "key" => "test_gTT7NU33MBzu5pCgV9qfa472FjuBaA",
    ),
    "db" => array(
        "user" => "root",
        "password" => "",
        "port" => 3306,
        "host" => "localhost",
        "name" => "wideworldimporters",
        "driver" => "mysql",
    ),
);
