<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/10/16
 * Time: 5:02 PM
 */

namespace RTMatt\MonthlyService\Tests;


use RTMatt\MonthlyService\RedtrainApiKeys;

class RTAPIGuardTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /** @test */
    public function it_parses_auth_input_into_name_and_key(){
        $name = str_random(15);
        $key = uniqid();
        $input = $this->createHeader($name, $key);
        $guard = new \RTMatt\MonthlyService\Middleware\RTAPIGuard();
        $guard->check($input);

        $this->assertEquals($name,$guard->auth_name);
        $this->assertEquals($key,$guard->auth_key);
    }
    /** @test */
    public function it_retrieves_possible_keys_by_name(){
        $api_key = $this->createAPIKey();
        $input = $this->createHeader($api_key->api_name,$api_key->api_secret_key);
        $guard = new \RTMatt\MonthlyService\Middleware\RTAPIGuard();
        $guard->check($input);
        $match=false;
        foreach($guard->matched_keys as $key){
            if($key->id==$api_key->id){
                $match=true;
            }
        }
        $this->assertTrue($match);
    }
    /** @test */
    public function it_compares_hashed_api_key_to_stored_secret(){
        $api_key = $this->createAPIKey();
        $hashed_key = \Hash::make($api_key->api_secret_key);
        $input = $this->createHeader($api_key->api_name,$hashed_key);
        $guard = new \RTMatt\MonthlyService\Middleware\RTAPIGuard();
        $this->assertNotFalse($guard->check($input));
    }


    /**
     * @param $name
     * @param $key
     *
     * @return string
     */
    private function createHeader($name, $key)
    {
        $encoded = base64_encode("{$name}:{$key}");
        $input   = "Basic {$encoded}";

        return $input;
    }


    /**
     * @return mixed
     */
    private function createAPIKey()
    {
        return factory(RedtrainApiKeys::class)->create();
    }
}