<?php
namespace W2W\CSRF;

class CSRF {
	private $strNAMESPACE;
	
	public function __construct($strNAMESPACE = "_csrf") {
		$this->namespace = $strNAMESPACE;
		
		if(session_id() === "") {
			session_start();
		}
		
		$this->setToken();
	}
	
	public function getToken() {
		return $this->readTokenFromStorage();
	}
	
	public function isTokenValid($strUSERTOKEN) {
		return ($strUSERTOKEN === $this->readTokenFromStorage());
	}
	
	public function insertInputField() {
		$strCSRFTOKEN = $this->getToken();
		
		echo "<input type=\"hidden\" name=\"" . $this->namespace . "\" value=\"" . $strCSRFTOKEN . "\">";
	}
	
	public function verifyRequest() {
		if(!$this->isTokenValid($_POST[$this->namespace])) {
			die("CSRF validation failed.");
		}
	}
	
	private function setToken() {
		$storedToken = $this->readTokenFromStorage();
		
		if($storedToken === "") {
			$strCSRFTOKEN = md5(uniqid(rand(), true));
			$this->writeTokenToStorage($strCSRFTOKEN);
		}
	}
	
	private function readTokenFromStorage() {
		if(isset($_SESSION[$this->namespace])) {
			return $_SESSION[$this->namespace];
		} else {
			return "";
		}
	}
	
	private function writeTokenToStorage($strCSRFTOKEN) {
		$_SESSION[$this->namespace] = $strCSRFTOKEN;
	}
}