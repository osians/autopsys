<?php

/** @const string REMOTE_VERSION_NUMBER Url to external verification of version number as a .TXT file */
define('REMOTE_VERSION_NUMBER', "http://sooho.com.br/version/current_version.txt");

/** @const string LOCAL_VERSION_NUMBER Users local version number **/
define('LOCAL_VERSION_NUMBER', "version" . DIRECTORY_SEPARATOR . "version.txt");

/** @const string VERSION_PATH Where the version path is */
define('LOCAL_NEW_VERSION_NUMBER', "version" . DIRECTORY_SEPARATOR . "new-version.txt");

/** @const string REMOTE_FILE_URL Location to download new version zip */
define('REMOTE_FILE_URL', 'http://sooho.com.br/version/System_1115-13.zip');

/** @const string LOCAL_FILE Rename version location/name */
define('LOCAL_FILE', 'version' . DIRECTORY_SEPARATOR . 'new-version.zip'); #example: version/new-version.zip
