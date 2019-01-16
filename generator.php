<?php
/*
** --------------------
** ATTENTION: SHITCODE
** --------------------
*/

require "memory.php";
function readTheFile($path) {
    $handle       = fopen($path, 'r');
    fgets($handle); // first line fix
    $handleOutput = fopen('output.txt', 'w');
    fwrite($handleOutput, "MolID;Target;Ligand;Run;Pose;Rank;dG;VS;Atom;X;Y;Z".PHP_EOL);
    $i=0;
    $b=0;
    $atomsamount = 0;
    $array = "";
    $at = "";
    $form = "";
    $replaced = preg_replace('/ +/', ',', fgets($handle)); // maybe replace with strtr?
    while(!feof($handle)) {
        
        foreach(explode('\x0A', $replaced) as $line) // "\n"
        {
            $c = strlen($line);
            $parsedMolLine = explode(",", $line);
            switch ($c) {
                case $c<=4: // atoms count
                    $i++;
                    $atomsamount += (int)$c;
                    break;
                case $c>90: // moleculaa
                    $p = explode("-", $parsedMolLine[0]); // parsed from $parsedMolLine with "-"
                    $form = $b.';'.$p[0].';'.$p[1].';'.$p[4].';'.$p[6].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$parsedMolLine[3].';';
                    $b++;
                    break;
                case ($c>20 && $c<90): //atom
                    $ughjeez = trim($parsedMolLine[3]);
                    $at   = $parsedMolLine[0].';'.$parsedMolLine[1].';'.$parsedMolLine[2].';'.$ughjeez;
                    $array .= $form.$at.PHP_EOL;
                    break;
            }
            
            $bytesize = strlen($array);
            if($bytesize > 1000000) // unset array for less ram usage
            {
                fwrite($handleOutput, $array);
                $array = "";
            }
            yield $line;
            $replaced = preg_replace('/ +/', ',', fgets($handle)); // maybe replace with strtr?
        }
    }
    fwrite($handleOutput, $array);
    fclose($handle);
    fclose($handleOutput);
    echo "Amount of atoms:     ".$atomsamount,PHP_EOL;
    echo "Amount of molecules: ".$i,PHP_EOL;
    echo "Peak RAM usage:      ".formatBytes(memory_get_peak_usage()),PHP_EOL;
    echo "Data saved in 'output.txt'";
}

?>
