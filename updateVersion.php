<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "config.php";

// checks if need to upgrade
$currentVersion = file_get_contents(LOCAL_VERSION_NUMBER);
$newVersion = file_get_contents(LOCAL_NEW_VERSION_NUMBER);

if ($currentVersion === $newVersion) {
    die(json_encode(array('result' => 0, 'message' => 'System is already updated.')));
}

// copy from remote to local
$copy = copy(REMOTE_FILE_URL, LOCAL_FILE);

if (!$copy) {
    // data message if failed to copy from external server
    die(json_encode(array("result" => 0, 'message' => 'Error: Failed to copy from external server')));
}

$path = pathinfo(realpath(LOCAL_FILE), PATHINFO_DIRNAME);

// unzip files
if (!class_exists('ZipArchive')) {
    die(json_encode(array('result' => 0, 'message' => 'Error: Class ZipArchive not found. It is a PHP Module and needs to be installed before continue.')));
}

$zip = new ZipArchive();
$result = $zip->open(LOCAL_FILE);

// on error
if ($result !== true) {
    unlink(LOCAL_FILE);
    die(json_encode(array("unzip" => 0)));
}

$zip->extractTo($path);
$zip->close();
unlink(LOCAL_FILE);

// update users local version number file
file_put_contents(LOCAL_VERSION_NUMBER, $newVersion);

echo json_encode(array("result" => 1, "message" => 'System has been successfully updated.'));
