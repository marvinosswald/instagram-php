<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use marvinosswald\Instagram\Instagram;

class UserTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
    }
    public function testSelf()
    {
        $res = $this::$instagram->user()->self();
        $this->assertEquals('marv_____',$res->username);
    }
    public function testSelfMediaRecent()
    {
        $res = $this::$instagram->user()->selfMediaRecent();
        $this->assertEquals('marv_____',$res[0]->user->username);
    }
    public function testSelfMediaLiked()
    {
        $res = $this::$instagram->user()->selfMediaLiked();

        $this->assertInternalType('array',$res);
    }
    public function testGet()
    {
        $res = $this::$instagram->user()->get('45913985')->username;
        $this->assertEquals('marv_____',$res);
    }

    public function testGetClientException()
    {
        $this->expectException(ClientException::class);
        $res = $this::$instagram->user()->get('1');
    }


    public function testGetAPIError400()
    {
        $instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')], ['http_errors' => false]);
        $res = $instagram->user()->get('1');
        $this->assertEquals($res->meta->code,'400');
        $this->assertInternalType('string', $res->meta->error_type);
        $this->assertInternalType('string', $res->meta->error_message);
    }


    public function testGetMediaRecent()
    {
        $res = $this::$instagram->user('45913985')->getMediaRecent()[0]->user->username;
        $this->assertEquals('marv_____',$res);
    }

    public function testSearch()
    {
        $res = $this::$instagram->user()->search('marv_____');
        $this->assertEquals('marv_____', $res[0]->username);
    }
}