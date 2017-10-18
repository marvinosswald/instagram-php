<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use marvinosswald\Instagram\Instagram;

class RelationshipsTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
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
    public function testGetClientException()
    {
        $this->expectException(ClientException::class);
        $instagram = new Instagram(['accessToken' => "dummy_token"], ['http_errors' => true]);
        $instagram->relationships->follows();
    }
    public function testGetAPIError400()
    {
        $instagram = new Instagram(['accessToken' => "dummy_token"], ['http_errors' => false]);
        $res = $instagram->relationships->follows();
        $this->assertEquals($res->meta->code,'400');
        $this->assertInternalType('string', $res->meta->error_type);
        $this->assertInternalType('string', $res->meta->error_message);
    }
}