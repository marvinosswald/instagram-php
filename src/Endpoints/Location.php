<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class Location {
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
        return $this->instagram->get(Location::API_SEGMENT.$this->id);
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
        return $this->instagram->get(Location::API_SEGMENT.$this->id.'/media/recent',[
            'min_tag_id' => $minTagId,
            'max_tag_id' => $maxTagId
        ]);
    }

    /**
     * @param $lat
     * @param $lng
     * @param int $distance
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function searchByCoordinates($lat, $lng, $distance=500)
    {
        return $this->instagram->get(Location::API_SEGMENT.'search',[
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance
        ]);
    }

    /**
     * @param string $fb_places_id
     * @param int $distance
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function searchByFbPlacesId($fb_places_id='',$distance=500)
    {
        return $this->instagram->get(Location::API_SEGMENT.'search',[
            'facebook_places_id' => $fb_places_id,
            'distance' => $distance
        ]);
    }
}