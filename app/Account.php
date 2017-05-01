<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        "followers" => 'array',
        "followings" => 'array' 
    ];


   

    public function getDuplicatesAttribute(){
        $followers = array_column(json_decode($this->attributes['followers'], true), 'ig_username');
        $followings = array_column(json_decode($this->attributes['followings'], true), 'ig_username');
        // return collect($followers);

        // return collect($followers)->intersect(collect($followings))->toArray();
        return array_intersect($followers, $followings);
    }


    public function getUniqueAttribute(){
        $followers = array_column(json_decode($this->attributes['followers'], true), 'ig_username');
        $followings = array_column(json_decode($this->attributes['followings'], true), 'ig_username');

        return array_unique(array_merge($followers, $followings));
    }


    public function getWithoutduplicatesAttribute(){
        $followers = array_column(json_decode($this->attributes['followers'], true), 'ig_username');
        $followings = array_column(json_decode($this->attributes['followings'], true), 'ig_username');

        return array_diff(array_unique(array_merge($followers, $followings))     , array_intersect($followers, $followings));
    }


    public function getFfollowersAttribute(){
        $followers = array_column(json_decode($this->attributes['followers'], true), 'ig_username');
        return $followers;
    }


    public function getFfollowingsAttribute(){
        $followings = array_column(json_decode($this->attributes['followings'], true), 'ig_username');
        return $followings;
    }


    
}
