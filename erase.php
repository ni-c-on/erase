<?php
/**
 * Remove old files in folder
 *
 * @author nicon <nicon@newmail.ru>
 * @version 0.1.1
 */

if ($argc < 2) {
    error_log('usage: php erase.php path/to/folder/ [days]');
    exit(1);
}

$folder = $argv[1];
$age = isset($argv[2]) ? $argv[2] : 30; // days

if (!$dir = opendir($folder)) {
    error_log("Can't read directory $folder");
    exit(1);
}

$date = strtotime("-{$age} days");

while(($file = readdir($dir)) !== false) {
    if ($file == '.' or $file == '..') continue;

    if (filectime($folder . DIRECTORY_SEPARATOR . $file) < $date) {
        unlink($folder . DIRECTORY_SEPARATOR . $file);
    }
}

closedir($dir);

exit(0);
