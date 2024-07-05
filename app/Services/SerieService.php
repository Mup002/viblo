<?php
namespace App\Services;

use App\Http\Resources\SerieResource;
use App\Repositories\SerieRepository;

class SerieService
{
    protected $serviceRepo;

    public function __construct(SerieRepository $serieRepo)
    {
        $this -> serviceRepo = $serieRepo;
    }
    public function getAllSerieByPage($page)
    {
        $serie = $this->serviceRepo->getSerieNewestByPage($page);
        $serieResource = SerieResource::collection($serie);
        return $serieResource;
    }
}
