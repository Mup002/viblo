<?php
namespace App\Services;
use App\Models\Tag;

class TagService
{
    protected $tag;
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
    public function findTag($tag)
    {
        $tags = $this->tag->select('tag_id','tagname')->where('tagname','LIKE','%' . $tag . '%')->get();
        $rs = $tags->map(function($tag){
            $tag->tagname = '@' . $tag->tagname;
            return $tag;
        });
        return  $rs;
    }
}