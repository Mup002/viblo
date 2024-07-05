<?php
namespace App\Repositories;

use App\Models\Serie;

class SerieRepository
{
    protected $serie;

    public function __construct(Serie $serie){
        $this->serie = $serie;
    }
    public function getSerieNewestByPage($page = 1, $perpage = 20){
        return Serie::with('tags')
        ->orderBy('created_at','desc')
        ->paginate($perpage,['*'],'page',$page);
    }
}
