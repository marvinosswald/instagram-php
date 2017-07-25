<?php

namespace marvinosswald\Instagram\Endpoints;
use marvinosswald\Instagram\Instagram;

/**
 * Class Media
 * @package marvinosswald\Instagram
 */
class Tag {
    /**
     * @var Instagram
     */
    protected $instagram;
    /**
     * @var string
     */
    public $tagName;
    /**
     * @var
     */
    protected $data;
    /**
     *
     */
    const API_SEGMENT='tags/';

    /**
     * Tag constructor.
     * @param Instagram $instagram
     * @param string $tagName
     */
    public function __construct(Instagram $instagram,$tagName = '')
    {
        $this->instagram = $instagram;
        $this->tagName = $tagName;
    }

    public function get($tagName = '')
    {
        return $this->instagram->get(Tag::API_SEGMENT.$tagName);
    }

    /**
     * @param int $count
     * @param string $minTagId
     * @param string $maxTagId
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function recentMedia($count = '',$minTagId='',$maxTagId='')
    {
        if(!$this->tagName){
            return "No Tag name set";
        }
        return $this->instagram->get(Tag::API_SEGMENT.$this->tagName.'/media/recent',[
            'count' => $count,
            'min_tag_id' => $minTagId,
            'max_tag_id' => $maxTagId
        ]);
    }

    public function search($query)
    {
        return $this->instagram->get(Tag::API_SEGMENT.'search',['q' => $query]);
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