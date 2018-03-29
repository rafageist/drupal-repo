<?php

/**
 * Create a repository of Drupal's packages
 *
 * @author rafageist [rafageist@hotmail.com]
 * @version 1.0
 */
 
$filter = null;
$letter = null;

if (isset($_SERVER['argv'][1])) $filter = $_SERVER['argv'][1];
if (isset($_SERVER['argv'][2])) $letter = $_SERVER['argv'][2];

$f = fopen("./projects", "r");

@mkdir("./drupal/");

$f2 = fopen("download.bat", "w");

$lastletter = null;
while (!feof($f)) {
    $s = fgets($f);
    if (stripos($s, "<a ")!==false){
		$p1 = strpos($s, '"');
		$p2 = strpos($s, '"', $p1+1);
		$n = substr($s,$p1+1,$p2-$p1-1);
		
		$l = $n[0];
		
		/*
		if (strpos($n, '-dev-') !== false 
			|| strpos($n, '-dev.') !== false 
			|| strpos($n, '-beta') !== false 
			|| strpos($n, '-alpha')!== false 
			|| strpos($n,'-core.tar.gz') !== false 
			|| strpos($n,'-rc') !== false 
			|| strpos($n, '-unstable') !== false) continue;
		*/
		if (strpos($n, '.tar.gz') !== false && (is_null($filter) || strpos($n, $filter)!==false) && (is_null($letter) || $l === $letter)){

			if ($l != $lastletter) echo $l."\t";
			$lastletter = $l;
			@mkdir("./drupal/$l");
			fputs($f2, "wget -c -O ./drupal/$l/$n https://ftp.drupal.org/files/projects/$n\n");
		}
    }
}
fclose($f2);
fclose($f);
exit();