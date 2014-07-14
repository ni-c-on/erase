<?php
/**
 * Скрипт удаляет старые файлы из папки.
 *
 * @date 19.06.14
 * @author nicon <nicon@newmail.ru>
 * @version 0.1
 */

$folder = 'C:\\Users\\техпром\\Downloads\\';
$age = 30; // days

if (!$dir = opendir($folder)) exit(1);

$date = strtotime("-{$age} days");

while(($file = readdir($dir)) !== false) {
    if ($file == '.' or $file == '..') continue;

    if (filectime($folder . DIRECTORY_SEPARATOR . $file) < $date) {
        unlink($folder . DIRECTORY_SEPARATOR . $file);
    }
}

closedir($dir);

exit(0);