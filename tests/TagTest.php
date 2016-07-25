<?php

use \PHPUnit\Framework\TestCase;

class TagTest extends TestCase{
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
        $res = $this::$instagram->tag('cats')->get();
        $this->assertEquals('cats',$res->name);

    }

    public function testRecentMedia()
    {
        $res = $this::$instagram->tag('cats')->recentMedia();
        $this->assertEquals(200,$res->meta->code);
    }

    public function testSearch()
    {
        $res = $this::$instagram->tag()->search('cats');
        $this->assertEquals('cats',$res[0]->name);
    }
}