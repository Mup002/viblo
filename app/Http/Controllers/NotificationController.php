<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    protected $noti;
    public function __construct(NotificationService $noti)
    {
        $this->noti = $noti;
    }
}
