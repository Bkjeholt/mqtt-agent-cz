<?php

class VPerror {
	
	public function write($str) {
		$errorLogFileName = "/var/www/php/CZ50/errorLog.txt";
		
		if (!$fh = fopen($errorLogFileName, 'a')) {
			echo "Cannot open file ($errorLogFileName)\n";
		}
		$errorMsg = 'Msg (' . time() .'): ' . $str . '\n';
		
		if (fwrite($fh, $errorMsg) === FALSE) {
			echo "Cannot write to file ($errorLogFileName)\n";
		}
		
		fclose($fh);
	}
}