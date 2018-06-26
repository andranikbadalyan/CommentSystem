<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['name', 'comment', 'parent_id'];

    public function childComment(){
        return $this->hasMany('App\Comment', 'parent_id');
    }


    public function parentComment(){
        return $this->belongsTo('App\Comment', 'parent_id');
    }


    public function reply(Comment $parent){
        if( !$this->isNestedThreeLevels() ){
            return $this->update(['parent_id' => $parent->id]);
        }
    }

    protected function isNestedThreeLevels(){
        if($this->parentComment && $this->parentComment->parentComment && $this->parentComment->parentComment->parentComment) {
            return true;
        }
        return false;
    }
}
