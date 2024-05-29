<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'setting';
    protected $primaryKey = 'id_setting';
    protected $allowedFields = ['nama_perusahaan', 'alamat', 'telepon', 'path_logo'];
    protected $useTimestamps = true;
}
