<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use marvinosswald\Instagram\Instagram;

class TagTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
    }

    public function testGet()
    {
        $res = $this::$instagram->tag('cats')->get();
        $this->assertEquals('cats',$res->data->name);

    }

    public function testRecentMedia()
    {
        $res = $this::$instagram->tag('cats')->recentMedia();
        $this->assertEquals(200,$res->meta->code);
    }

    public function testSearch()
    {
        $res = $this::$instagram->tag()->search('cats');
        $this->assertEquals('cats',$res->data[0]->name);
    }
    public function testGetClientException()
    {
        $this->expectException(ClientException::class);
        $res = $this::$instagram->tag('@$*')->get();
    }
    public function testGetAPIError400()
    {
        $instagram = new Instagram(['accessToken' => "dummy_token"], ['http_errors' => false]);
        $res = $instagram->tag('cats')->get();
        $this->assertEquals($res->meta->code,'400');
        $this->assertInternalType('string', $res->meta->error_type);
        $this->assertInternalType('string', $res->meta->error_message);
    }
}