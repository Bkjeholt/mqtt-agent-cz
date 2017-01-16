<?php

class VPSendXml {
	
	/**
	 * @param $xmlMsg SimpleXmlElement
	 */
	 public function send($xmlMsg) {
		$url = 'http://127.0.0.1/test/receive.php/';
	 	$total = $url.'?msg='.urlencode($xmlMsg->asXML($xmlMsg));
	 	
	 	$fp = fopen ($total, "r");
	 	
	 	$resultstring = "";
	 	
	 	if ($fp) {
	 		while (($buffer = fgets($fp, 4096)) !== false) {
	 			$resultstring = $resultstring . $buffer;
	 		}
	 		if (!feof($fp)) {
	 			echo "Error: unexpected fgets() fail\n";
	 		}
	 	}
	 	fclose($fp);
	 	
	 	echo "<h3>Received data from the server</h3><p>" .
	 			htmlspecialchars($resultstring) .
	 			"</p><p>----------------------------------------------------------</p>";
	 	return true;
		
	}
}