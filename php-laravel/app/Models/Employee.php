<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $primaryKey = 'id';

    public $timestamps = false; // karena tidak menggunakan created_at & updated_at standar

    protected $fillable = [
        'nomor',
        'nama',
        'jabatan',
        'talahir',
        'photo_upload_path',
        'created_on',
        'updated_on',
        'created_by',
        'updated_by',
        'deleted_on',
    ];

    // jika ingin meng-cast tanggal ke Carbon
    protected $casts = [
        'talahir'    => 'date',
        'created_on' => 'datetime',
        'updated_on' => 'datetime',
    ];
}
