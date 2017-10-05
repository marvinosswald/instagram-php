<?php
namespace marvinosswald\Instagram\Laravel\Facade;
use Illuminate\Support\Facades\Facade;
class Instagram extends Facade {
    protected static function getFacadeAccessor(){
        return 'instagram';
    }
}