<?php

require_once 'config.php';

/** @var $message Error Message */
$message = "";

// open remote file and get version number
$file = fopen(REMOTE_VERSION_NUMBER, "r");
$remoteVersion = fgets($file);
fclose($file);
if ($remoteVersion === false) {
    $message .= "Failed to read the remote version number. ";
}

// check local file for version number
$file = fopen(LOCAL_VERSION_NUMBER, "r");
$localVersion = fgets($file);
fclose($file);
if ($localVersion === false) {
    $message = "Failed to read the local version number.";
}

$result = ($localVersion === $remoteVersion)
    ? array("version" => 0)
    : array("version" => $remoteVersion);

// success
if ($remoteVersion !== false) {
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}

// error
header('HTTP/1.1 500 Internal Server Error');
header('Content-Type: application/json; charset=UTF-8');
die(json_encode(array('message' => $message, 'code' => 1337)));
