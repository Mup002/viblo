<?php
namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function getAllUser(){
        $result  = ['status' => 200];
        try{
            $result['data'] = $this -> userService->getAllUser();
        }catch(Exception $e){
            $result = [
                'status' => 500,
                'error'=> $e->getMessage()
            ];
        }
        return response()->json($result,$result['status']);
    }
    public function getProfile($id){
        return response()->json($this->userService->profile($id));
    }
}
