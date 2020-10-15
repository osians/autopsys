<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";

// copy from remote to local
$copy = copy(REMOTE_FILE_URL, LOCAL_FILE);

if (!$copy) {
    // data message if failed to copy from external server
    die(json_encode(array("copy" => 0)));
}

$path = pathinfo(realpath(LOCAL_FILE), PATHINFO_DIRNAME);

// unzip files
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
$userfile = fopen("version/version.txt", "w");
$localVersionNumber = fgets($userfile);
fwrite($userfile, $_POST['vnum']);
fclose($userfile);

echo json_encode(array("unzip" => 1));
