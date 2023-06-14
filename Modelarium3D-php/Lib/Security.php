<?php   

    namespace Lib;

    use Dotenv\Dotenv;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use PDOException;

    class Security{


    /**
     * Devuelve la clave secreta almacenada en el .env
     * @access public
     * @return string
     */
        final public static function clavesecreta():string{
            $dotenv = Dotenv::createImmutable(__DIR__.'/..');
            $dotenv -> safeLoad();
            return $_ENV['SECRET_KEY'];
        }





    /**
     * Encripta la contraseña pasada y la devuelve hasheada
     * @access public
     * @param string La contraseña a encriptar
     * @return string
     */
        final public static function encriptaPassw(string $passw): string {
            $passw = password_hash($passw, PASSWORD_DEFAULT);
            return $passw;
        }
    





    /**
     * Comprueba que la contraseña que hemos ingresado en el login 
     * concuerda con la contraseña encriptada en la base de datos
     * @access public
     * @param string La contraseña a verificar
     * @param string La contraseña encriptada
     * @return bool
     */
        final public static function validaPassw(string $passw, string $passwash): bool {
            if (password_verify($passw, $passwash)) {
                return true;
            }
            else {
                echo "contraseña incorrecta";
                return false;
            }
        }






    /**
     * Se encarga de crear el token a partir de la secret key
     * y los datos de l usuario registrados
     * @access public
     * @param string La secret key del .env
     * @param array Datos de Usuario
     * @return array
     */

        final public static function crearToken(string $key, array $data):array{
            $time = strtotime("now");
            $token =array(
                "iat"=>$time,//tiempo en el que creamos el JWT, cuando se inicia el token
                "exp"=>$time + 3600, // el token expira en 1 hora
                "data"=> $data
                );
                return $token;
               }
               





               
    /**
     * Se encarga de asignar el token al usuario y de llamar al modelo para 
     * que meta el token en la base d datos
     * @access public static
     * @param Usuario Un objeto usuario con los datos del registro
     * @param string Email del usuario
     * @return string
     */
        final public static function createToken($usuario, $email): string{
            $key = Security::clavesecreta();
            $token = Security::crearToken($key, [$email]);
            $encodedToken = JWT::encode($token, $key, 'HS256');
            $usuario -> setToken($encodedToken);
            $usuario -> setEmail($email);
            $usuario -> updateToken($token['exp']);
            return $encodedToken;
        } 






    /**
     * Se encarga de validar el token
     * @access public static
     * @return bool|array
     */
        final public static function validateToken(): bool|array{
            $info = self::getToken();

            return $info -> data ?? false;
        }





    /**
     * Se encarga de devolver el token de un suuario
     * @access public static
     * @return \stdClass|string
     */
        final public static function getToken()
        :\stdClass|string{
            $headers = apache_request_headers(); // recoger las cabeceras en el servidor Apache
            if (!isset($headers['Authorization'])) { // comprobamos que existe la cabecera authoritation
                return $response['message'] = json_decode(ResponseHttp::statusMessage(403, 'Acceso denegado'));
            }
            try {
                $authorizationArr = explode(' ', $headers['Authorization']);
                $token = $authorizationArr[1];
                $decodeToken = JWT::decode($token, new Key(Security::clavesecreta(), 'HS256'));
                return $decodeToken;
            } catch (PDOException $exception) {
                return $response['message'] = json_encode(ResponseHttp::statusMessage(401, 'Token expirado o invalido'));
            }
        }
           



    }
