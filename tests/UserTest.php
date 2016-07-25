<?php

use \PHPUnit\Framework\TestCase;

class UserTest extends TestCase{
    protected static $instagram;

    public static function setUpBeforeClass()
    {
        if (file_exists (__DIR__."/../.env")){
            $dotenv = new Dotenv\Dotenv(__DIR__."/../");
            $dotenv->load();
        }
        self::$instagram = new \marvinosswald\Instagram\Instagram(['accessToken' => getenv('INSTAGRAM_ACCESS_TOKEN')]);
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