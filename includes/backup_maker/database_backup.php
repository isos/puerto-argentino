<?php
     $mailto = 'kioscocollacciani@gmail.com';
     $smtp_host = 'ssl://smtp.gmail.com:465';
     $smtp_username = $mailto;
     $smtp_password = 'backupMailSystem';

     $dl_type = 'db'; //db ; all
     $conv_type = 'zip'; // zip, bz2, none
     $lang = 'es_cr';
    
     $mailto_name = 'Backup base de datos';         
     $mailto_subject = 'Backup de la base de datos '.date('d/m/Y'); 
     $mailto_body = 'Se adjunta el backup completo de la base de datos';

     include('make_backup.php');
?>
