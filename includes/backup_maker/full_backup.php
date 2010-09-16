<?php
     $mailto = 'kioscocollacciani@gmail.com';
     $smtp_host = 'ssl://smtp.gmail.com:465';
     $smtp_username = $mailto;
     $smtp_password = 'backupMailSystem';

     $dl_type = 'all'; //db ; all
     $conv_type = 'zip'; // zip, bz2, none
     $lang = 'es_cr';

     $mailto_name = 'Backup completo';
     $mailto_subject = 'Backup del sistema (base de datos y directorio del sistema): '.date('d/m/Y');

     include('make_backup.php');
?>
