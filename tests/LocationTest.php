<?php

use \PHPUnit\Framework\TestCase;

class LocationTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new \marvinosswald\Instagram\Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
    }

    public function testGet()
    {
        $res = $this::$instagram->location(213385402)->get();
        $this->assertEquals(213385402,$res->id);

    }

    public function testRecentMedia()
    {
        $res = $this::$instagram->location(213385402)->recentMedia();
        $this->assertInternalType('array',$res);
    }

    public function testSearchByFbPlacesId()
    {
        $res = $this::$instagram->location()->searchByFbPlacesId('106078429431815');
        $this->assertEquals(213385402,$res[0]->id);
    }

    public function testSearchByCoordinates()
    {
        $res = $this::$instagram->location()->searchByCoordinates('51.518732','-0.129756');
        $this->assertEquals(213385402,$res[2]->id);
    }
}