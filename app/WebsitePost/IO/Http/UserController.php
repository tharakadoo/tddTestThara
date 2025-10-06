<?php

namespace App\WebsitePost\IO\Http;

use App\WebsitePost\Entities\Website;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\WebsitePost\Entities\User;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $websites = User::select('id', 'email')->get();

        return response()->json($websites, 200);
    }
}
