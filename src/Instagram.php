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
     *
     */
    const OAUTH_URL = 'https://api.instagram.com/oauth/authorize/';
    /**
     *
     */
    const ACCESS_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';
    /**
     * @var string
     */
    protected $accessToken = '';
    /**
     * @var string
     */
    protected $clientId = '';
    /**
     * @var string
     */
    protected $clientSecret = '';
    /**
     * @var mixed|string
     */
    protected $redirectUri = '';
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
     * @param array $params
     * @param array $config
     */
    public function __construct(array $params = [], array $config = [])
    {
        $this->accessToken = array_key_exists('accessToken',$params) ? $params['accessToken'] : '';
        $this->clientId = array_key_exists('clientId',$params) ? $params['clientId'] : '';
        $this->clientSecret = array_key_exists('clientSecret',$params) ? $params['clientSecret'] : '';
        $this->redirectUri = array_key_exists('redirectUri',$params) ? $params['redirectUri'] : '';

        $this->client = new Client(array_merge([
            'base_uri' => Instagram::API_URL
        ], $config));
        $this->relationships = new Relationships($this);
    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function get($uri,$params = [])
    {
        if(!$this->accessToken){
            throw new \Exception("No accessToken set");
        }
        $client = $this->client->request('GET',$uri,['query' => array_merge([
            'access_token' => $this->accessToken
        ],$params)]);

        return \GuzzleHttp\json_decode((string) $client->getBody());
    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function post($uri,$params = [])
    {
        if(!$this->accessToken){
            throw new \Exception("No accessToken set");
        }
        $client = $this->client->request('POST',$uri,['form_params' => array_merge([
            'access_token' => $this->accessToken
        ],$params)]);
        return \GuzzleHttp\json_decode((string) $client->getBody());

    }

    /**
     * @param $uri
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function delete($uri,$params = [])
    {
        if(!$this->accessToken){
            throw new \Exception("No accessToken set");
        }
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

    /**
     * @param array $scopes
     * @return string
     * @throws \Exception
     */
    public function getLoginUrl(array $scopes = [])
    {
        if(!$this->clientId){
            throw new \Exception("You need to set your client_id (clientId)");
        }
        if (!$this->redirectUri){
            throw new \Exception("You need to set a redirect URI (redirectUri)");
        }
        $url = Instagram::OAUTH_URL.'?client_id='.$this->clientId.'&redirect_uri='.$this->redirectUri.'&response_type=code';
        if ($scopes){
            $scopeParam = '&scope=';
            foreach ($scopes as $i => $scope){
                if ($i > 0){
                    $scopeParam .= '+'.$scope;
                }else{
                    $scopeParam .= $scope;
                }

            }
            $url .= $scopeParam;
        }
        return $url;
    }

    /**
     * @param $code
     * @return string
     * @throws \Exception
     */
    public function getAccessToken($code)
    {
        if(!$this->clientId){
            throw new \Exception("You need to set your client_id (clientId)");
        }
        if(!$this->clientSecret){
            throw new \Exception("You need to set your client_secret (clientSecret)");
        }
        if (!$this->redirectUri){
            throw new \Exception("You need to set a redirect URI (redirectUri)");
        }
        $client = new Client();
        $res = $client->post(Instagram::ACCESS_TOKEN_URL,['form_params' => [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
            'code' => $code
        ]]);
        $body = (string) $res->getBody();
        $this->accessToken = $body->access_token;
        return $this->accessToken;
    }
}