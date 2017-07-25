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
    public function get($id)
    {
        return $this->instagram->get(User::API_SEGMENT.$id);
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function self()
    {
        return $this->instagram->get(User::API_SEGMENT.'self');
    }

    /**
     * @param string $count
     * @param string $minId
     * @param string $maxId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getMediaRecent($count='',$minId='',$maxId='')
    {
        return $this->instagram->get(User::API_SEGMENT.$this->id.'/media/recent',[
            'count' => $count,
            'min_id' => $minId,
            'max_id' => $maxId
        ]);
    }

    /**
     * @param string $count
     * @param string $minId
     * @param string $maxId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaRecent($count='',$minId='',$maxId='')
    {
        return $this->instagram->get(User::API_SEGMENT.'self/media/recent',[
            'count' => $count,
            'min_id' => $minId,
            'max_id' => $maxId
        ]);
    }

    /**
     * @param string $count
     * @param string $maxLikeId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function selfMediaLiked($count = '',$maxLikeId='')
    {
        return $this->instagram->get(User::API_SEGMENT.'self/media/liked',[
            'count' => $count,
            'max_like_id' => $maxLikeId
        ]);
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