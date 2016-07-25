<?php

use \PHPUnit\Framework\TestCase;

class RelationshipsTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new \marvinosswald\Instagram\Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
    }
    public function testFollows()
    {
        $res = $this::$instagram->relationships->follows();
        $this->assertEquals(200,$res->meta->code);
    }
    public function testFollower()
    {
        $res = $this::$instagram->relationships->follows();
        $this->assertEquals(200,$res->meta->code);
    }
    public function testFollowingRequests()
    {
        $res = $this::$instagram->relationships->followingRequests();
        $this->assertEquals(200,$res->meta->code);
    }
}