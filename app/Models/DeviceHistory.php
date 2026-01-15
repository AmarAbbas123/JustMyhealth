<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    protected $table = 'sys_device_details_history';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
