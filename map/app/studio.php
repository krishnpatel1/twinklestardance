<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class studio extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'studios';

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
    protected $fillable = ['name','address','country','state','latitude','longitude','phone','email','website','zip'];

    public function countryRelationship() {
        return $this->belongsTo('App\country', 'country');
    }


    
}
