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
    public $data;
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
        return $res;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function self()
    {
        $res = $this->instagram->get(User::API_SEGMENT.'self');
        $this->data = $res->data;
        return $res;
    }

    /**
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getMediaRecent(array $params=[])
    {
        return $this->instagram->get(User::API_SEGMENT.$this->id.'/media/recent',$params);
    }

    /**
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaRecent(array $params = [])
    {
        return $this->instagram->get(User::API_SEGMENT.'self/media/recent',$params);
    }

    /**
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaLiked(array $params=[])
    {
        return $this->instagram->get(User::API_SEGMENT.'self/media/liked',$params);
    }

    /**
     * @param $q
     * @param bool $count
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function search($q,$count = false)
    {
        return $this->instagram->get(User::API_SEGMENT.'search',[
            'q' => $q,
            'count' => $count ?: ''
        ]);
    }
}