<?php

class VPanalys {
	protected $vpSourceString ="";
	protected $vpstring = "";
	
	/**
	 * 
	 * @return SimpleXMLElement
	 */
	private function analyzeString() {
		$xmlDevDataInitialString = 
			"<?xml version='1.0' standalone='yes'?>" . 
			"<msg key='CoZo456123789'>" .
				"<devdata>" . 
				"</devdata>" . 
			"</msg>";

		$xmlDevDataMsg = new SimpleXMLElement($xmlDevDataInitialString);
		// Create an array based on the modified received string
		
		$arr = split('_',$this->vpstring);
		
		$xmlDevDataList = $xmlDevDataMsg->xpath('//devdata');
		$xmlDevData = $xmlDevDataList[0];
		
		$xmlDevData->addAttribute('uts', time());
		
		foreach ($arr as $key => $value) {
			$xmlData = $xmlDevData->addChild('data',$value);
			$xmlData->addAttribute('id',$key);
		}
		
		return $xmlDevDataMsg;
	}
	
	public function analyze($receivedChar) {
		$this->vpSourceString .= $receivedChar;
		
		switch($a  = ord($receivedChar)) {  // the ascii value och read character
			// check for stop criteria:
			case 10:   // LF
			case 13:   // CR
				// end of data log from heating system
				
				$xmlMsg = $this->analyzeString();
				
				VPSendXml::send($xmlMsg);

				break;
		
		
				// store expected characters
			case ($a > 47) && ($a < 58): // 0-9
			case ($a == 43):             // +
			case ($a == 45):             // -
			case ($a == 46):             // .
			case ($a == 58):             // :
			case ($a == 61):             // =
			case ($a == 69):             // E
				$this->vpstring .= $receivedChar; // add character to string
				break;
		
				// If the read character is any of the listed characters then
				// replace the character by a single '_'.
				// Only store one '_' character in sequence.
				// Don't store '_' characters if no data is collected,
				// that means the string shall not start with a '_' character.
			case ($a == 9):   // TAB
			case ($a == 32):  // SPACE
				$length = strlen($this->vpstring);
				if ($length > 0) {
					$lastChar = $this->vpstring[strlen($vpstring)-1];
					if ($lastChar != "_") {       // previous stored char not equal to ';'
						$this->vpstring .= "_";
					}
				}
				break;
			default:
				$errorMsg = "ERROR, unexpected character received: [$c,$a], [i=$i]\n";
				VPerror::write($errorMsg);
				break;
		}
	}
}