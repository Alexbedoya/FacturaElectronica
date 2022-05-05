<?php
// inclusion de la source de la classe
include('class.mail.php');
// creation de l'instance
$mail = new simplemail;
//ajout du destinataire
$mail -> addrecipient('tetsuo@xxx.com','tetsuo');
// ajout de l'expediteur
$mail -> addfrom('gwbush@neobagdad.com','gwbush');
//ajout du sujet
$mail -> addsubject('yyy yyy');
// le message plaintext
$mail -> text = 'plain text etc. etc. bla bla ...';
// envoie du message
if ( $mail -> sendmail() ) { echo "envoyé"; } else { echo "erreur"; echo $mail->error_log; }
?>
