<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapPascaDaftungModel extends Model
{
    protected $table = 'rekap_pascabayar_daftung';
    protected $fillable = [
        'unit_ulp_pascabayar',
        'target_carry_over',
        'target_harian',
        'realisasi',
        'persen_pencapaian',
        'unit_ulp_daftung',
        'daftung_pagi',
        'cetak_pk_pagi',
        'cetak_pk_siang',
        'jumlah_peremajaan',
    ];

    public $timestamps = true;
}
