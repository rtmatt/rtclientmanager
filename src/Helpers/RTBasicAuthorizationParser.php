<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/14/16
 * Time: 9:32 PM
 */
namespace RTMatt\MonthlyService\Helpers;
class RTBasicAuthorizationParser {

    public  $auth_name;
    public  $auth_key;

    function __construct($input)
    {
        $this->parse($input);

    }


    private function parse($input)
    {
        $base       = str_replace('Basic ', '', $input);
        $decoded    = base64_decode($base);
        $components = explode(':', $decoded);

        if (count($components) !== 2) {
            throw new \Exception();
        }
        $this->auth_name = $components[0];
        $this->auth_key  = $components[1];
        $this->input = [$this->auth_name,$this->auth_key];
        return $this->input;
    }


    public function getParsedValues(){
        return $this->input;
    }

    public static function create($input){
        return new static($input);
    }

}