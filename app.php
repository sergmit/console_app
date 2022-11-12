<?php
require 'vendor/autoload.php';

try {
    $app = new \App\App($argv);

    $app->execute();
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}
