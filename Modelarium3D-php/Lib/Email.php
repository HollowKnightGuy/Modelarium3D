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

        public function contacto($nombre, $email, $contenido){

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '8aa69c861f0fc8';
            $mail->Password = '2ce2a537889f8c';

            $mail -> setFrom("$email",'User');
            $mail -> addAddress('modelarium3d@gmail.com', 'Modelarium 3D');

            $mail -> isHTML(TRUE);
            $mail -> CharSet = "UTF-8";
            $mail -> Subject = "User Contact Email";
            $contenido = "<html>
                            <p>
                            User name:".$nombre."
                            </p>
                            <p>
                            User email: ".$email."
                            </p>
                            <p>
                            Description: ".$contenido."
                            </p>
                        </html>";

            $mail -> Body = $contenido;
            $mail -> send();


        }
    }



?>