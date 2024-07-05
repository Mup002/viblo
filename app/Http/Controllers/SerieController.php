<?php

namespace App\Http\Controllers;

use App\Services\SerieService;
use Exception;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    //
    protected $serieService;
    public function __construct(SerieService $serieService){
        $this-> serieService = $serieService;
    }

    public function getAllSerieByPage(Request $request){
        $page = $request->query('page',1);

        try{
            $rs = $this ->serieService-> getAllSerieByPage($page);
            $page = [
                'current_page' => $rs->currentPage(),
                'total' => $rs -> total(),
                'last_page' => $rs ->lastPage(),
                'per_page' => $rs ->perPage(),
            ];
            $data = [
                'data' => $rs,
                'page' => $page
            ];

            return response()->json($data,200);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }
}
