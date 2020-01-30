<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPerahan extends Model
{
    protected $table = 'hasil_perahan';
    protected $primaryKey = 'id_pemerahan';
    public $timestamps = false; 

    public function setoran()
	{
	    return $this->belongsTo('App\Penyetoran');
	}
}
