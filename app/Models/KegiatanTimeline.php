<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanTimeline extends Model
{
    use SoftDeletes;
    protected $table = 'kegiatan_timelines';

    protected $fillable = [
        'nama_kegiatan',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
