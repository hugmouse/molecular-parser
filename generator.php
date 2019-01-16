<?php
/*
** --------------------
** ATTENTION: SHITCODE
** --------------------
*/

require "memory.php";
function readTheFile($path) {
    $handle       = fopen($path, 'r');
    $handleOutput = fopen('output.txt', 'w');
    $i=0;
    $b=0;
    $atomsamount = 0;
    while(!feof($handle)) {
         $replaced = preg_replace('/\s\s+/', ',', fgets($handle)); // maybe replace with strtr?
         foreach(explode('\x0A', $replaced) as $line) // "\n"
         {
           $c = strlen($line);
           $parsedMolLine = explode(",", $line);
            switch ($c) {
                case $c<=4:
                    //var_dump($line);
                    $i++;
                    $atomsamount += (int)$c;
                    break;
                case $c>90:
                    $p = explode("-", $parsedMolLine[0]); // parsed from $parsedMolLine with "-"
                    $b++;
                    $form = $b.';'.$p[0].';'.$p[4].';'.$p[6].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$parsedMolLine[3].';';
                    break;
                case ($c>20 && $c<90):
                    $ughjeez = trim($parsedMolLine[3]);
                    $at   = $parsedMolLine[0].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$ughjeez;
                    break;
            }

            @$array .= $form.$at.';'.PHP_EOL;

            $bytesize = strlen($array).PHP_EOL;
            if($bytesize < 64) // fixing weird 3 strings on start of algo
            {
                unset($array);
            }

            if($bytesize > 1000000) // unset array for less ram usage
            {
                fwrite($handleOutput, $array);
                unset($array, $bytesize);
            }
           
           yield $line;
         }
    }
    fclose($handle);
    fclose($handleOutput);
    echo "Amount of atoms:     ".$atomsamount,PHP_EOL;
    echo "Amount of molecules: ".$i,PHP_EOL;
    echo "Peak RAM usage:      ".formatBytes(memory_get_peak_usage()),PHP_EOL;
    echo "Data saved in 'output.txt'";
}

?>
