<?php
/*
PARA QUE ESTO FUNCIONE, hay que editar /etc/sudores (sudo visudo) y agregar estas lineas:

www-data ALL =(ALL) NOPASSWD: /var/www/kiosco/includes/addons/custom_scripts/execrestart.sh
www-data  ALL=(ALL) NOPASSWD:/var/www/kiosco/includes/addons/custom_scripts/mysql_restart.php
*/

 system('sudo ./execrestart.sh',$output);
  print_r($output); 
?> 
 
