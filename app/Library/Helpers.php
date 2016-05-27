<?php namespace App\Library;
use App\Appointments;
use App\PaymentPipe;
use App\User;
use Illuminate\Support\Facades\Auth;

class Helpers {

    /**
     * get client IP Address
     */
    public static function get_ip_address() {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && self::validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (self::validate_ip($ip))
                        return $ip;
                }
            } else {
                if (self::validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && self::validate_ip($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && self::validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && self::validate_ip($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];

        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns an encrypted & utf8-encoded
     */
    public static function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '!@#$%^&*';
        $secret_iv = '!@%^#$&*';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
            $output = str_replace(array('+','/','='),array('-','_','.'),$output);
        }
        else if( $action == 'decrypt' ){
            $string = str_replace(array('-','_','.'),array('+','/','='),$string);
            $string = base64_decode($string);
            $output = openssl_decrypt($string, $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    /*
     *  Get Custom Token for App user...
     * */

    public static function generateToken() {
        $token = md5(rand());
        return $token;
    }


    /**
     * @param $url
     * @return mixed
     */
    public static function shortURl($url){
        $username = env('SHORTURL_USERNAME');
        $password = env('SHORTURL_PASSWORD');
        $api_url =  env('SHORTURL_URL');

        $data = [     // Data to POST
            'format'   => 'json',
            'action'   => 'shorturl',
            'keyword'  => substr(str_shuffle(time()."abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5),
            'username' => $username,
            'password' => $password,
            'url'      => $url,
        ];

        $response = \Curl::to($api_url)
            ->withData($data)
            ->post();

        // Do something with the result. Here, we return the short URL
        $data = json_decode( $response );
        return $data->shorturl;
    }
}