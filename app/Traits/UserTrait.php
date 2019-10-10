<?php
namespace App\Traits;
use Storage;
use Auth;
trait UserTrait {
    public function getProfilelinkAttribute()
    {
        return route('admin.users.edit', ['user' => $this->id]);
    }

    public function getAvatarlinkAttribute()
    {
        if(!is_null($this->avatar) && asset($this->avatar))
        {
            return asset($this->avatar);
        }
        return asset('assets/img/p-50.png');
    }

    public function getIsmeAttribute()
    {
        if(Auth::check() && Auth::id() == $this->id)
        {
            return true;
        }
        return false;
    }
}
