<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class Media {
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
    const API_SEGMENT='media/';

    /**
     * Media constructor.
     * @param Instagram $instagram
     * @param string $id
     */
    public function __construct(Instagram $instagram,$id = '')
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
        if ($id){
            $this->id = $id;
        }
        $res = $this->instagram->get(Media::API_SEGMENT.$this->id);
        $this->data = $res->data;
        return $res;
    }

    /**
     * @param $shortcode
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getByShortcode($shortcode)
    {
        $res = $this->instagram->get(Media::API_SEGMENT.'shortcode/'.$shortcode);
        $this->id = $res->data->id;
        $this->data = $res->data;
        return $res;
    }

    /**
     * @param $lat
     * @param $lng
     * @param $distance (optional)
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function search($lat,$lng,$distance)
    {
        return $this->instagram->get(Media::API_SEGMENT.'search',[
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance ?: ''
        ]);
    }
    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function comments()
    {
        if (!$this->id){
            return "No Media id set";
        }
        return $this->instagram->get(Media::API_SEGMENT.$this->id.'/comments');
    }

    /**
     * @param $text
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function comment($text)
    {
        if (!$this->id){
            return "No Media id set";
        }
        return $this->instagram->post(Media::API_SEGMENT.$this->id.'/comments',['text' => $text]);
    }

    /**
     * @param $commentId
     * @return mixed
     */
    public function deleteComment($commentId)
    {
        if (!$this->id){
            return "No Media id set";
        }
        return $this->instagram->delete(Media::API_SEGMENT.$this->id.'/comments/'.$commentId);
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function likes()
    {
        return $this->instagram->get(Media::API_SEGMENT.$this->id.'/likes');
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function like()
    {
        return $this->instagram->post(Media::API_SEGMENT.$this->id.'/likes');
    }

    /**
     * @return mixed
     */
    public function unlike()
    {
        return $this->instagram->delete(Media::API_SEGMENT.$this->id.'/likes');
    }
}