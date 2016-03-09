<?php
/**
 * Remove old files in folder
 *
 * @author nicon <nicon.work@gmail.com>
 * @version 0.1.1
 */

if ($argc < 2) {
    error_log("\nusage: php erase.php [options] path/to/folder/\n\nOptions:\n\t-v\t\tVerbose\n\t-a=age\t\tAge of old files (days)");
    exit(1);
}

array_shift($argv);

$folder = '';
$verbose = false;
$age = 30; // days

foreach ($argv as $arg) {
    $arg = explode('=', $arg, 2);
    switch ($arg[0]) {
        case '-a':
            if (!isset($arg[1])) {
                error_log("Wrong value for age\n");
                exit(1);
            }
            $age = $age[1];
            break;

        case '-v':
            $verbose = true;
            break;

        default:
            if (strpos($arg[0], '-') !== false) {
                error_log("Undefined option {$arg[0]}\n");
                exit(1);
            }
            $folder = $arg[0];
            break;
    }
}

if (!$folder) {
    error_log("Directory not specified\n");
    exit(1);
}

if (!is_dir($folder)) {
    error_log("No such file or directory in $folder\n");
    exit(1);
}

if (!$dir = opendir($folder)) {
    error_log("Can't read directory $folder\n");
    exit(1);
}

$date = strtotime("-{$age} days");

$count = 0;

while(($file = readdir($dir)) !== false) {
    if ($file == '.' or $file == '..') continue;

    if (filectime($folder . DIRECTORY_SEPARATOR . $file) < $date) {
        if ($verbose) echo 'Delete file: ' . $folder . DIRECTORY_SEPARATOR . $file . "\n";
        unlink($folder . DIRECTORY_SEPARATOR . $file);
        ++$count;
    }
}

if (!$count && $verbose) {
    echo "No files deleted\n";
} elseif ($verbose) {
    echo "Deleted $count filse\n";
}

closedir($dir);

exit(0);
