<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\Task');
        //非省略の場合は$this->hasMany('App\Task', 'folder_id', 'id');
    }
}
