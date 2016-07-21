<?php

namespace marvinosswald\Instagram;

use GuzzleHttp\Client;
use marvinosswald\Instagram\Endpoints\Location;
use marvinosswald\Instagram\Endpoints\Media;
use marvinosswald\Instagram\Endpoints\Relationships;
use marvinosswald\Instagram\Endpoints\Tag;
use marvinosswald\Instagram\Endpoints\User;

class Instagram {
    /**
     *
     */
    const API_URL = 'https://api.instagram.com/v1/';
    /**
     * @var string
     */
    protected $accessToken = '';
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var Media
     */
    public $media;
    /**
     * Instagram constructor.
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client = new Client([
            'base_uri' => Instagram::API_URL
        ]);
        $this->relationships = new Relationships($this);
    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($uri,$params = [])
    {
        $client = $this->client->request('GET',$uri,['query' => array_merge([
            'access_token' => $this->accessToken
        ],$params)]);

        return \GuzzleHttp\json_decode((string) $client->getBody());
    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function post($uri,$params = [])
    {
        $client = $this->client->request('POST',$uri,['form_params' => array_merge([
            'access_token' => $this->accessToken
        ],$params)]);
        return \GuzzleHttp\json_decode((string) $client->getBody());

    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed
     */
    public function delete($uri,$params = [])
    {
        $client = $this->client->request('DELETE',$uri,['query' => array_merge([
            'access_token' => $this->accessToken
        ],$params)]);
        return \GuzzleHttp\json_decode((string) $client->getBody());

    }

    /**
     * @param string $id
     * @return Media
     */
    public function media($id = '')
    {
        return new Media($this,$id);
    }

    /**
     * @param string $id
     * @return User
     */
    public function user($id = '')
    {
        return new User($this,$id);
    }

    /**
     * @param string $tagName
     * @return Tag
     */
    public function tag($tagName = '')
    {
        return new Tag($this,$tagName);
    }

    /**
     * @param string $id
     * @return Location
     */
    public function location($id = '')
    {
        return new Location($this,$id);
    }
}