<?php
/*** 
    Este script se encarga de controlar las sesiones, y tiene como principal objetivo evitar el reenvio de formularios
**/

class SessionManager {

   private $FIELD_NAME = "random";  //nombre del campo de $_SESSION
   private $array_size = 50;  //cantidad maxima de valores permitidos

   private function push($value) {
	
	if (count($_SESSION[$this->FIELD_NAME]) >= $this->array_size)
		array_pop($_SESSION[$this->FIELD_NAME]);
	array_unshift($_SESSION[$this->FIELD_NAME],$value);
   }

   private function add2Session($value) {
	if (!isset($_SESSION[$this->FIELD_NAME])) 	
		$_SESSION[$this->FIELD_NAME] = array();

	$this->push($value);
	return $value;
   }

   private function removeFromSession($value) { 
	$pos = array_search($value,$_SESSION[$this->FIELD_NAME]);
	if ($pos !== FALSE) {
		unset($_SESSION[$this->FIELD_NAME][$pos]);
		return true;
	} 
	return false;
    }
  /*
   function que genera un valor aleatorio y lo guarda en la sesion
  */
   public function init_form() {
	session_start();
	$random=md5(uniqid(rand(), true));
	return $this->add2session($random);

   }

  /*
     verifica que un valor aleatorio este efectivamente en la session. Si es asi, tambien lo quita de la sesion
  */
   public function validate_session($value) {
	session_start();
	$result = false;
	if (isset($_SESSION[$this->FIELD_NAME]) ) 
		$result = $this->removeFromSession($value,$_SESSION[$this->FIELD_NAME]);

	return $result;

   }

}
?>
