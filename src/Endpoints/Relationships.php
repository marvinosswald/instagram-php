<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class Relationships {
    /**
     * @var Instagram
     */
    protected $instagram;
    /**
     *
     */
    const API_SEGMENT='users/';
    /**
     * Media constructor.
     * @param Instagram $instagram
     */
    public function __construct(Instagram $instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function follows()
    {
        return $this->instagram->get(Relationships::API_SEGMENT.'self/follows');
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function followers()
    {
        return $this->instagram->get(Relationships::API_SEGMENT.'self/followed-by');
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function followingRequests()
    {
        return $this->instagram->get(Relationships::API_SEGMENT.'self/requested-by');
    }

    /**
     * @param $target
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function with($target)
    {
        return $this->instagram->get(Relationships::API_SEGMENT.$target.'/relationship');
    }

    /**
     * @param $target
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function follow($target)
    {
        return $this->instagram->post(Relationships::API_SEGMENT.$target.'/relationship',['action' => 'follow']);
    }

    /**
     * @param $target
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function unfollow($target)
    {
        return $this->instagram->post(Relationships::API_SEGMENT.$target.'/relationship',['action' => 'unfollow']);
    }

    /**
     * @param $target
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function approve($target)
    {
        return $this->instagram->post(Relationships::API_SEGMENT.$target.'/relationship',['action' => 'approve']);
    }

    /**
     * @param $target
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function ignore($target)
    {
        return $this->instagram->post(Relationships::API_SEGMENT.$target.'/relationship',['action' => 'ignore']);
    }
}