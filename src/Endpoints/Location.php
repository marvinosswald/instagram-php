<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class location {
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
     * @var
     */
    public $meta;
    /**
     *
     */
    const API_SEGMENT='locations/';

    /**
     * Location constructor.
     * @param Instagram $instagram
     * @param string $id
     */
    public function __construct(Instagram $instagram,$id = '')
    {
        $this->instagram = $instagram;
        $this->id = $id;
    }

    public function get($id = '')
    {
        if ($id){
            $this->id = $id;
        }
        $res = $this->instagram->get(Location::API_SEGMENT.$this->id);
        $this->data = $res->data;
        $this->meta = $res->meta;
        return $this;
    }

    /**
     * @param string $minTagId
     * @param string $maxTagId
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function recentMedia($minTagId='',$maxTagId='')
    {
        if(!$this->id){
            return "No Location id set";
        }
        $res = $this->instagram->get(Location::API_SEGMENT.$this->id.'/media/recent',[
            'min_tag_id' => $minTagId,
            'max_tag_id' => $maxTagId
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $tag = new Media($this->instagram,$item->id);
            $tag->setData($item);
            array_push($arr,$tag);
        }
        return $arr;
    }

    /**
     * @param $lat
     * @param $lng
     * @param int $distance
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function searchByCoordinates($lat, $lng, $distance=500)
    {
        $res = $this->instagram->get(Location::API_SEGMENT.'search',[
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $tag = new Location($this->instagram,$item->id);
            $tag->setData($item);
            array_push($arr,$tag);
        }
        return $arr;
    }

    /**
     * @param string $fb_places_id
     * @param int $distance
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function searchByFbPlacesId($fb_places_id='',$distance=500)
    {
        $res = $this->instagram->get(Location::API_SEGMENT.'search',[
            'facebook_places_id' => $fb_places_id,
            'distance' => $distance
        ]);
        $arr = [];
        foreach ($res->data as $item){
            $tag = new Location($this->instagram,$item->id);
            $tag->setData($item);
            array_push($arr,$tag);
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