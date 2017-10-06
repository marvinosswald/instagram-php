<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use marvinosswald\Instagram\Instagram;

class LocationTest extends TestCase{
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
        $res = $this::$instagram->location(213385402)->get();
        $this->assertEquals(213385402,$res->data->id);

    }

    public function testRecentMedia()
    {
        $res = $this::$instagram->location(213385402)->recentMedia();
        $this->assertEquals(200,$res->meta->code);
    }

    public function testSearchByFbPlacesId()
    {
        $res = $this::$instagram->location()->searchByFbPlacesId('106078429431815');
        $this->assertEquals(213385402,$res->data[0]->id);
    }

    public function testSearchByCoordinates()
    {
        $res = $this::$instagram->location()->searchByCoordinates('51.518732','-0.129756');
        $this->assertEquals(213385402,$res->data[2]->id);
    }
    public function testGetClientException()
    {
        $this->expectException(ClientException::class);
        $this::$instagram->location(12345)->get();
    }
    public function testGetAPIError400()
    {
        $instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')], ['http_errors' => false]);
        $res = $instagram->location(12345)->get();
        $this->assertEquals($res->meta->code,'400');
        $this->assertInternalType('string', $res->meta->error_type);
        $this->assertInternalType('string', $res->meta->error_message);
    }
}