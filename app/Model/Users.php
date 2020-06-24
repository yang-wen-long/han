<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //指定表名
    protected $table = "p_users";
    //指定主键pk
    protected $primaryKey = "user_id";
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
