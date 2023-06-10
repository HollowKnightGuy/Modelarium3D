<?php

    namespace Lib;
    use PHPMailer\PHPMailer\PHPMailer;

    class Email{

        private string $email;
        private string $token;

        /*public function __construct($email,$token){

            $this -> email = $email;
            $this -> token = $token;

        }*/

        public function __construct()
        {
            
        }

        public function enviarCorreoRegistro($email, $nombre){

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '8aa69c861f0fc8';
            $mail->Password = '2ce2a537889f8c';

            $mail -> setFrom('modelarium3d@gmail.com','Modelarium 3D');
            $mail -> addAddress("$email");

            $mail -> isHTML(TRUE);
            $mail -> CharSet = "UTF-8";
            $mail -> Subject = "Correo de confirmación";
            $contenido = "<html>
                            <p>
                                Hola ".$nombre." bienvenido al Proyecto de cursos, logueate ya en nuestra página y comienza a gestionar!
                            </p>
                            <p>
                                Presiona aquí: <a href = ".$_ENV['BASE_URL']."usuario/login>Log in</a>
                            </p>
                        </html>";

            $mail -> Body = $contenido;
            $mail -> send();


        }
    }



?>