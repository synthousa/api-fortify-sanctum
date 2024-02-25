<?php

/* command: php comments.php */
/* removing all comment at default */


$directories = [
    'app',
    'bootstrap',
    'config',
    'database',
    // 'modules',
    'public',
    'resources',
    'routes',
];

$base = './';

foreach ($directories as $dir) {
    $it = new RecursiveDirectoryIterator($base . $dir);
    foreach (new RecursiveIteratorIterator($it) as $file) {
        if ($file->getExtension() == 'php') {
            echo "Removing comments from: " . $file->getRealPath() . "\n";
            $contents = file_get_contents($file->getRealPath());
            $new = preg_replace('/^(\{?)\s*?\/\*(.|[\r\n])*?\*\/([\r\n]+$|$)/im', '$1', $contents);
            file_put_contents($file->getRealPath(), $new);
        }
    }
}