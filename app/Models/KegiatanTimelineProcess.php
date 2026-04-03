<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanTimelineProcess extends Model
{
    use SoftDeletes;
    protected $table = 'kegiatan_timeline_processes';

    protected $fillable = [
        'tahun',
        'order_data',
        'id_kegiatan',
        'nama_kegiatan',
        'tahun_start',
        'bulan_start',
        'tahun_end',
        'bulan_end',
        'tambahan_bulan',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
