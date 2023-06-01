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

        public function enviarConfirmacion($email, $nombre, $apellidos){

            $mail = new PHPMailer();
            $mail -> isSMTP();
            $mail -> Host = 'sandbox.smtp.mailtrap.io';

            $mail -> SMTPAuth = true;
            $mail -> Username  =  '47e488037ff2c2';
            $mail -> Password  =  '1f9da0719464fc';

            $mail -> setFrom('proyectos-cursos@gmail.com','Modelarium');
            $mail -> addAddress("$email");

            $mail -> isHTML(TRUE);
            $mail -> CharSet = "UTF-8";
            $mail -> Subject = "Correo de confirmación";

            $contenido = "<html>
                            <p>
                                Hola ".$nombre." ".$apellidos." bienvenido al Proyecto de cursos, logueate ya en nuestra página y comienza a gestionar!
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