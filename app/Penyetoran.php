<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyetoran extends Model
{
    protected $table = 'penyetoran';
    protected $primaryKey = 'kode_setoran';

    public function perahan()
    {
        return $this->hasMany('App\HasilPerahan', 'kode_setoran');
    }
}
