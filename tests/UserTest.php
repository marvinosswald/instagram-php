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
        $this->assertEquals(getenv('INSTAGRAM_USERNAME'),$res->data->username);
    }
    public function testSelfMediaRecent()
    {
        $res = $this::$instagram->user()->selfMediaRecent();
        $this->assertEquals(getenv('INSTAGRAM_USERNAME'),$res->data[0]->user->username);
    }
    public function testSelfMediaLiked()
    {
        $res = $this::$instagram->user()->selfMediaLiked();

        $this->assertInstanceOf('stdClass',$res);
    }
    public function testGet()
    {
        $res = $this::$instagram->user()->get('45913985')->data->username;
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
        $res = $this::$instagram->user('45913985')->getMediaRecent()->data[0]->user->username;
        $this->assertEquals('marv_____',$res);
    }
    public function testSearch()
    {
        $res = $this::$instagram->user()->search("marv_____")->data[0]->username;
        $this->assertEquals("marv_____",$res);
    }
}