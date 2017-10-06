<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use marvinosswald\Instagram\Instagram;

class MediaTest extends TestCase{
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
        $res = $this::$instagram->media('503364100596583201_45913985')->get();
        $this->assertEquals('503364100596583201_45913985',$res->data->id);
    }
    public function testGetByShortcode()
    {
        $res = $this::$instagram->media()->getByShortcode('b8TvuIvksh');
        $this->assertEquals('503364100596583201_45913985',$res->data->id);
    }

    public function testGetLikes()
    {
        $res = $this::$instagram->media('503364100596583201_45913985')->likes();
        $this->assertEquals(200,$res->meta->code);
    }
    public function testGetClientException()
    {
        $this->expectException(ClientException::class);
        $this::$instagram->media('dummy_media_id')->get();
    }
    public function testGetAPIError400()
    {
        $instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')], ['http_errors' => false]);
        $res = $instagram->media('dummy_media_id')->get();
        $this->assertEquals($res->meta->code,'400');
        $this->assertInternalType('string', $res->meta->error_type);
        $this->assertInternalType('string', $res->meta->error_message);
    }
}