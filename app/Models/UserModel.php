<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nik', 'nama', 'password', 'role', 'status_verifikasi', 'no_hp', 'alamat'];
    protected $useTimestamps    = true;
}