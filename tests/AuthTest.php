<?php

use \PHPUnit\Framework\TestCase;

class AuthTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new \marvinosswald\Instagram\Instagram([
            'clientId' => '5c9fe446d7f64277a4328ade98550272',
            'clientSecret' => '41a63c2edc814097a975e3f59dc2d1d3',
            'redirectUri' => 'http://marvinosswald.de'
        ]);
    }

    public function testLoginUrl()
    {
        $loginUrl = $this::$instagram->getLoginUrl(['likes','comments']);
        $this->assertEquals('https://api.instagram.com/oauth/authorize/?client_id=5c9fe446d7f64277a4328ade98550272&redirect_uri=http://marvinosswald.de&response_type=code&scope=likes+comments',$loginUrl);
    }
}