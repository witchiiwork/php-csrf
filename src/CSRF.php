<?php
namespace W2W\CSRF;

class CSRF {
	public const conTOKNAMTXT = "_CSRF_mCzwh300xSkbiO2A1HS27VaDmBHRC5_FRSC_";
	
	public static function funGETTOKNAM(string $strTOKNAMTXT = self::conTOKNAMTXT): string {
		return $strTOKNAMTXT;
	}
	
	public static function funVLDTOKDAT(array $arrREQTOKDAT = [], string $strTOKNAMTXT = self::conTOKNAMTXT): bool {
		if(empty($_SESSION[$strTOKNAMTXT])) {
			static::funGENTOKXXX($strTOKNAMTXT);
			
			return false;
		}
		
		if(empty($arrREQTOKDAT[$strTOKNAMTXT])) {
			return false;
		}
		
		if(static::funCPRTOKTXT($arrREQTOKDAT[$strTOKNAMTXT], static::funGETTOKTXT($strTOKNAMTXT))) {
			static::funGENTOKXXX($strTOKNAMTXT);
			
			return true;
		}

		return false;
	}
	
	public static function funGENTOKXXX(string $strTOKNAMTXT = self::conTOKNAMTXT): void {
		$strSLTRIPUNQ = !empty($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : uniqid();
		$_SESSION[$strTOKNAMTXT] = sha1(uniqid(sha1($strSLTRIPUNQ), true));
	}
	
	public static function funCPRTOKTXT(string $numINTCNTHST = "", string $numINTCNTNDE = ""): bool {
		$numINTCNTHNE = strlen($numINTCNTHST) ^ strlen($numINTCNTNDE);
		$numMINSTRLEN = min(strlen($numINTCNTHST), strlen($numINTCNTNDE));
		$numINTCNTHST = substr($numINTCNTHST, 0, $numMINSTRLEN);
		$numINTCNTNDE = substr($numINTCNTNDE, 0, $numMINSTRLEN);
		
		for($numINTCNTMIN = 0, $numINTCNTMAX = strlen($numINTCNTHST); $numINTCNTMIN < $numINTCNTMAX; $numINTCNTMIN++) {
			$numINTCNTHNE += !(ord($numINTCNTHST[$numINTCNTMIN]) === ord($numINTCNTNDE[$numINTCNTMIN]));
		}
		
		return !$numINTCNTHNE;
	}
	
	public static function funGETTOKTXT(string $strTOKNAMTXT = self::conTOKNAMTXT): string {
		if(empty($_SESSION[$strTOKNAMTXT])) {
			static::funGENTOKXXX($strTOKNAMTXT);
		}
		
		return $_SESSION[$strTOKNAMTXT];
	}
	
	public static function funGETFRMHIS(string $strTOKNAMTXT = self::conTOKNAMTXT): string {
		return sprintf("<input type=\"hidden\" name=\"%s\" value=\"%s\">", $strTOKNAMTXT, static::funGETTOKTXT($strTOKNAMTXT));
	}
}
