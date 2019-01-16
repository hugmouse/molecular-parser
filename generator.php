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
    fwrite($handleOutput, "MolID;Target;Ligand;Run;Pose;Rank;dG;VS;Atom;X;Y;Z;".PHP_EOL);
    $i=0;
    $b=-1; // wish granted
    $atomsamount = 0;
    while(!feof($handle)) {
         $replaced = preg_replace('/\s\s+/', ',', fgets($handle)); // maybe replace with strtr?
         foreach(explode('\x0A', $replaced) as $line) // "\n"
         {
           $c = strlen($line);
           $parsedMolLine = explode(",", $line);
           $test = strlen($line);
            switch ($c) {
                case $c<=4:
                    $i++;
                    $atomsamount += (int)$c;
                    break;
                case $c>96:
                    //Temporary fix of undefined offsets (line 34)
                    if($test > 50)
                    {
                        $p = explode("-", $parsedMolLine[0]); // parsed from $parsedMolLine with "-"
                        $b++;
                        $form = $b.';'.$p[0].';'.$p[1].';'.$p[4].';'.$p[6].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$parsedMolLine[3].';';
                        break;
                    }
                case ($c>20 && $c<90):
                    //Temporary fix of undefined offsets (line 42)
                    if($test != 0)
                    {
                        $ughjeez = trim($parsedMolLine[3]);
                        $at   = $parsedMolLine[0].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$ughjeez;
                        break;
                    }
            }

            @$array .= $form.$at.';'.PHP_EOL; // this is a string ok very cool

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
    fwrite($handleOutput, $array); // Saving last info into a file.

    fclose($handle);
    fclose($handleOutput);
    echo "Amount of atoms:     ".$atomsamount,PHP_EOL;
    echo "Amount of molecules: ".$i,PHP_EOL;
    echo "Peak RAM usage:      ".formatBytes(memory_get_peak_usage()),PHP_EOL;
    echo "Data saved in 'output.txt'";
}

?>
