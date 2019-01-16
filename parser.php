<?php
require "generator.php";

$arguments = $_SERVER['argv'];
if(empty($arguments[1]) === true)
{
    echo "Usage: php parser.php FILENAME",PHP_EOL;
    exit();
}
elseif(file_exists($arguments[1]) === false)
{
    echo "You know there's no file called '".$arguments[1]."', ".get_current_user().'.',PHP_EOL;
    exit();
}

echo "Starting generator... Process PID: ".getmypid(),PHP_EOL;

$f = readTheFile($arguments[1]);

foreach ($f as $killingram)
{
    // DONT TOUCH THIS *music starts playing*
}



?>