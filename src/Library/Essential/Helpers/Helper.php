<?php


namespace tinkle\framework\Library\Essential\Helpers;


use tinkle\framework\Request;
use tinkle\framework\Tinkle;

class Helper
{



    public  function is_https()
    {
        if($_ENV['URL_SCHEME'] === 'https')
        {
            if(Request::$loaded->getScheme() === 'https')
            {
                return true;
            }
        }
        return false;
    }




    public function generatetoken()
    {
        $token = hex2bin(openssl_random_pseudo_bytes(16));
        Tinkle::$app->session->set('token',$token);
        return true;
    }



    public  function ObjectToArray($object, $assoc=1, $empty=''){

        $output = array();
        $assoc = (!empty($assoc)) ? TRUE : FALSE;

        if (!empty($object)) {
            $ArrayOrObject = is_object($object) ? get_object_vars($object) : $object;
            $i=0;
            foreach ($ArrayOrObject as $key => $value) {
                $key = ($assoc !== FALSE) ? $key : $i;
                if (is_array($value) || is_object($value)) {
                    $output[$key] = (empty($value)) ? $empty : $this->ObjectToArray($value);
                }
                else {
                    $output[$key] = (empty($value)) ? $empty : (string)$value;
                }
                $i++;
            }
        }
        return $output;
    }



    public function JsonToArray($arg){
        if (!empty($arg)){
            if (is_object($arg)){
                // current arg is already json decode and result is an object
                return $this->ObjectToArray($arg);
            }else{
                // json need to decode and current arg is an encode json data
                $json_data = json_decode($arg);
                return $this->ObjectToArray($json_data);
            }
        }else{
            return false;
        }
    }








}