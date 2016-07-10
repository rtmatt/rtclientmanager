<?php
namespace RTMatt\MonthlyService\Middleware;

use RTMatt\MonthlyService\Contracts\RTGuardContract;

class RTAPIGuard implements RTGuardContract
{




    public function check($authorization_input)
    {

        try {
          list($this->auth_name,$this->auth_key) =   \RTMatt\MonthlyService\Helpers\RTBasicAuthorizationParser::create($authorization_input)->getParsedValues();
        } catch (\Exception $e) {
            return false;
        }
        $this->getKeysByName();

        return $this->checkForValidKey();

    }


    private function getKeysByName()
    {
        $this->matched_keys = \RTMatt\MonthlyService\RedtrainApiKeys::byName($this->auth_name);
    }


    private function checkForValidKey()
    {
        foreach ($this->matched_keys as $key) {
            $check = \Hash::check($key->api_secret_key, $this->auth_key);
            if ($check) {
                $this->client_id = $key->client_id;

                return true;
            }
        }

        return false;
    }

}