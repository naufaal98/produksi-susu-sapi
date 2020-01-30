<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokPakan extends Model
{
    protected $table = 'stok_pakan';
    protected $primaryKey = 'id_penyetokan';

    public function sapi ()
    {
        return $this->belongsToMany('App\Sapi', 'pemberian_pakan');
    }
}