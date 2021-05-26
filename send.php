<?php
/* Codigo php por Paredes Fernando para el curso de Programacion en PHP en PoloTIC Misiones, 2021.
*
*  En lugar de utilizar el metodo mail() convencional para php, este codigo utiliza la libreria PHPMailer que
*  es una forma mas moderna de enviar emails en servidores que provean un servicio de correo electronico. De 
*  ser asi, lo unico que habria que cambiar es el Host, puerto y credenciales a utilizar en $mail. */
$_name = $_POST['name'];
$_phone = $_POST['phone'];
$_subject = $_POST['subject'];
$_email = $_POST['email'];
$_msg = $_POST['message'];

//No se ejecuta codigo si no existe un input de tipo email
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');

    require './PHPMailer/PHPMailerAutoload.php';

    //Crear instancia de PHPMailer
    $mail = new PHPMailer;

    //Decir a PHPMailer que use el protocolo SMTP. Requiere un servidor de correo local.
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->Port = 25;
    $mail->Username = 'username'; 
    $mail->Password = 'mysecretpassword';

    $mail->setFrom($_email, $_name);
    //Mi correo electronico
    $mail->addAddress('fernandoivanparedes.99@gmail.com', 'Fernando Paredes');
    if ($mail->addReplyTo($_email, $_name)) {
        $mail->Subject = $_subject;
        $mail->isHTML(false);

        //Generar el cuerpo del correo en texto plano.
        $mail->Body = <<<EOT
        Email: {$_email}
        Name: {$_name}
        Phone: {$_phone}
        Message: {$_msg}
        EOT;

        //Envia el mensaje y comprueba errores
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Message sent! Thanks for contacting us.';
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
}
?>