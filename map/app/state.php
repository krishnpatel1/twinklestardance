<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

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
    protected $fillable = ['name', 'latitude','longitude','country'];
    
    public function countryRelationship() {
        return $this->belongsTo('App\country', 'country');
    }

    
}
