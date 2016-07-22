<?php

use \PHPUnit\Framework\TestCase;

class MediaTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new \marvinosswald\Instagram\Instagram(getenv('INSTAGRAM_ACCESS_TOKEN'));
    }

    public function testGet()
    {
        $res = $this::$instagram->media('503364100596583201_45913985')->get();
        $this->assertEquals('503364100596583201_45913985',$res->id);
    }
    public function testGetByShortcode()
    {
        $res = $this::$instagram->media()->getByShortcode('b8TvuIvksh');
        $this->assertEquals('503364100596583201_45913985',$res->id);
    }

    public function testGetLikes()
    {
        $res = $this::$instagram->media('503364100596583201_45913985')->likes();
        $this->assertEquals(200,$res->meta->code);
    }
}