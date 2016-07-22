# Endpoints

## Media

### Constructor($id)

Initalize a new Media Class with an Id or empty,

``` php
    $media = $instagram->media();
    
    // with id set:
    $media = $instagram->media(123);
```
##### Return
`Media` Returns new instance of Media Class
### Properties
- **id** `int` Media_Id
- **data** `StdClass` **protected** as soon as the object is synced with Instagram by `get()` this property holds the response data

If loaded you can access all properties send by Instagram like:
``` php
    $username = $media->user->username
```
### Methods
#### get($id)
Saves the result to the public parameter `data`
###### Parameter
- **id** (optional) only if not already set at initalization
``` php
    $media->get();
```
###### Return
`Media` Returns itself

#### getByShortcode($shortcode)
Saves the result to the public parameter `data`
##### Parameter
- **shortcode** 
``` php
    $media->getByShortcode($shortcode);
```
##### Return
`Media` Returns itself
#### search($latitude,$longitude,$distance)
##### Parameter
- **latitude**
- **longitude**
- **distance** (optional)
``` php
 $media->search($latitude,$longitude,$distance);
```
##### Return
`Array` Returns array of Media Objects
#### comments()
``` php
 $media->comments();
```
##### Return
`Array` Returns array of Comment Objects
#### comment($text)
Comments on the media object 
- **text** Comment text
``` php
 $media->comment($text);
```
##### Return
`StdClass` Returns Comment Object
#### deleteComment($id)
Delete commment by it's comment id
- **$id** Comment Id
``` php
 $media->deleteComment($id);
```
#### likes()
##### Parameter
``` php
 $media->likes();
```
##### Return
`Array` Returns array of Like Objects
#### like()
Likes this media Object by the current authorized user
##### Parameter
``` php
 $media->like();
```
##### Return
`StdClass` Returns Like Object
#### unlike()
Removes like from this media Object by the current authorized user
##### Parameter
``` php
 $media->unlike();
```
##### Return
`StdClass` Returns Like Object
## Users

### Constructor($id)

Initalize a new User Class with an Id or empty,

``` php
    $user = $instagram->user();
    
    // with id set:
    $user = $instagram->user(123);
```
##### Return
`User` Returns new instance of User Class
### Properties
- **id** `int` User_Id
- **data** `StdClass` **protected** as soon as the object is synced with Instagram by `get()` this property holds the response data

If loaded you can access all properties send by Instagram like:
``` php
    $username = $user->username
```
### Methods
#### get($id)
##### Properties
- **id** only if not already set at initalization
##### Return
`User` Returns itself
#### self()
Access authorized user
##### Return
`User` Returns itself
#### getMediaRecent($count,$minId,$maxId)
Requests recent media objects posted by the specified user
##### Parameter
- **count** (optional)
- **minId** (optional)
- **maxId** (optional)
``` php
 $user->getMediaRecent($count,$minId,$maxId);
```
##### Return
`Array` Returns array of Media Objects
#### selfMediaRecent($count,$minId,$maxId)
Requests recent media objects posted by the authorized user
##### Parameter
- **count** (optional)
- **minId** (optional)
- **maxId** (optional)
``` php
 $user->selfMediaRecent($count,$minId,$maxId);
```
##### Return
`Array` Returns array of User Objects
#### selfMediaLiked($count,$maxLikeId)
Requests liked media objects posted by the authorized user
##### Parameter
- **count** (optional)
- **maxLikeId** (optional)
``` php
 $user->getMediaLiked($count,,$maxLikeId);
```
##### Return
`Array` Returns array of User Objects
#### search($query,$count)
##### Properties
- **query** Search query
- **count** (optional) Limit result
##### Return
`Array` Returns array of User Objects
## Locations
### Constructor($id)

Initalize a new Location Class with an Id or empty,

``` php
    $location = $instagram->location();
    
    // with id set:
    $location = $instagram->location(123);
```
##### Return
`Location` Returns new instance of Location Class
### Properties
- **id** `int` Location_Id
- **data** `StdClass` **protected** as soon as the object is synced with Instagram by `get()` this property holds the response data

If loaded you can access all properties send by Instagram like:
``` php
    $latitude = $location->latitude
```
### Methods
#### get($id)
##### Parameter
- **id** only if not already set at initalization
##### Return
`Location` Returns itself
#### recentMedia($minTagId,$maxTagId)
##### Properties
- **minTagId** (optional)
- **maxTagId** (optional)
##### Return
`Array` Returns array of `Media` Objects
#### searchByCoordinates($lat,$lng,$distance)
##### Properties
- **latitude**
- **longitude**
- **distance** (optional) Limit radius, default is 500m
##### Return
`Array` Returns array of Location Objects

#### searchByFbPlaces($fb_places_id,$distance)
##### Properties
- **fb_places_id** A Place id issued by Facebook
- **distance** (optional) Limit radius, default is 500m
##### Return
`Array` Returns array of Location Objects
## Relationships
### Constructor()
Initalize a new Relationship Class,

``` php
    $relationship = $instagram->relationship();
```
##### Return
`Relationship` Returns new instance of Relationship Class
### Methods
#### follows()
Returns User the authorized User is following
##### Return
`Array` Returns array of User Objects
#### followers()
Returns User who are following the authorized User
##### Return
`Array` Returns array of User Objects
#### followingRequests()
Returns all open following requests.
#### with()
Get information about a relationship to another user. Relationships are expressed using the following terms in the response:
outgoing_status: Your relationship to the user. Can be 'follows', 'requested', 'none'.
incoming_status: A user's relationship to you. Can be 'followed_by', 'requested_by', 'blocked_by_you', 'none'.
#### follow($target)
##### Parameters
- **target** Id of user to follow

#### unfollow($target)
##### Parameters
- **target** Id of user not to follow anymore

#### approve($target)
##### Parameters
- **target** Id of user to approve request

#### ignore($target)
##### Parameters
- **target** Id of user to ignore request

## Tags
### Constructor($tagname)
### Properties
- **id** `int` Tag name
- **data** `StdClass` **protected** as soon as the object is synced with Instagram by `get()` this property holds the response data

If loaded you can access all properties send by Instagram like:
``` php
    $media_count = $tag->media_count
```
Initalize a new Tag Class with an Tagname or empty,

``` php
    $tag = $instagram->tag();
    
    // with id set:
    $tag = $instagram->tag(123);
```
##### Return
`Tag` Returns new instance of Tag Class
### Methods
#### get($id)
##### Parameter
- **id** only if not already set at initalization
##### Return
`Tag` Returns itself
#### recentMedia($count,$minTagId,$maxTagId)
##### Parameter
- **count** (optional)
- **minTagId** (optional)
- **maxTagId** (optional)
##### Return
`Array` Returns array of `Media` objects
#### search($query)
##### Parameter
- **query** Search query
##### Return
`Array` of `Tag` Objects
## Comments & Likes

Both of these Endpoints are embedded into the Media Class

