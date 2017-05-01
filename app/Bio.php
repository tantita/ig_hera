<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bios';

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
    protected $fillable = ['ig_username', 'bio', 'ig_usernameid'];

    
}
