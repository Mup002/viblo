<?php

namespace App\Http\Controllers;

use App\Services\PrivacyService;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    //
    protected $privacyService;
    public function __construct(PrivacyService $privacyService)
    {
        $this->privacyService = $privacyService;
    }
    public function getAll()
    {
        return response()->json($this->privacyService->getAll());
    }
}
