<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class User {
    /**
     * @var Instagram
     */
    protected $instagram;
    /**
     * @var string
     */
    public $id;
    /**
     * @var
     */
    protected $data;
    /**
     * @var stdClass
     */
    public $meta;
    /**
     *
     */
    const API_SEGMENT='users/';

    /**
     * User constructor.
     * @param Instagram $instagram
     * @param bool $id
     */
    public function __construct(Instagram $instagram,$id = false)
    {
        $this->instagram = $instagram;
        $this->id = $id;
    }

    /**
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($id = false)
    {
        if($id){
            $this->id = $id;
        }
        $res = $this->instagram->get(User::API_SEGMENT.$this->id);
        $this->data = $res->data;
        $this->meta = $res->meta;
        return $this;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function self()
    {
        $res = $this->instagram->get(User::API_SEGMENT.'self');
        $this->data = $res->data;
        $this->meta = $res->meta;
        return $this;
    }

    /**
     * @param string $count
     * @param string $minId
     * @param string $maxId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getMediaRecent($count='',$minId='',$maxId='')
    {
        $res = $this->instagram->get(User::API_SEGMENT.$this->id.'/media/recent',[
            'count' => $count,
            'min_id' => $minId,
            'max_id' => $maxId
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $media = new Media($this->instagram,$item->id);
            $media->setData($item);
            array_push($arr,$media);
        }
        return $arr;
    }

    /**
     * @param string $count
     * @param string $minId
     * @param string $maxId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaRecent($count='',$minId='',$maxId='')
    {
        $res = $this->instagram->get(User::API_SEGMENT.'self/media/recent',[
            'count' => $count,
            'min_id' => $minId,
            'max_id' => $maxId
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $media = new Media($this->instagram,$item->id);
            $media->setData($item);
            array_push($arr,$media);
        }
        return $arr;
    }

    /**
     * @param string $count
     * @param string $maxLikeId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaLiked($count = '',$maxLikeId='')
    {
        $res = $this->instagram->get(User::API_SEGMENT.'self/media/liked',[
            'count' => $count,
            'max_like_id' => $maxLikeId
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $media = new Media($this->instagram,$item->id);
            $media->setData($item);
            array_push($arr,$media);
        }
        return $arr;
    }

    /**
     * @param $q
     * @param bool $count
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function search($q,$count = false)
    {
        $res = $this->instagram->get(User::API_SEGMENT.'search',[
            'q' => $q,
            'count' => $count ?: ''
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $user = new User($this->instagram,$item->id);
            $user->setData($item);
            array_push($arr,$user);
        }
        return $arr;
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (isset($this->data->{$name})) {
            return $this->data->{$name};
        }
        trigger_error(
            'Undefined Property for: ' . $name,
            E_USER_NOTICE);
        return null;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->data;
    }
}