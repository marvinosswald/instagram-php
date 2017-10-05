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
        $res = $this::$instagram->user()->get('299054539')->data->username;
        $this->assertEquals(getenv('INSTAGRAM_USERNAME'),$res);
    }
    public function testGetMediaRecent()
    {
        $res = $this::$instagram->user('299054539')->getMediaRecent()->data[0]->user->username;
        $this->assertEquals(getenv('INSTAGRAM_USERNAME'),$res);
    }
    public function testSearch()
    {
        $res = $this::$instagram->user()->search(getenv('INSTAGRAM_SEARCH'))->data[0]->username;
        $this->assertEquals(getenv('INSTAGRAM_SEARCH'),$res);
    }
}