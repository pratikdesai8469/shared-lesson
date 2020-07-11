<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserSession;


class ApiController extends Controller
{
    public function sendResponse($status, $message, $data, $httpStatus) {

    	return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $httpStatus);
    }

    public function getUser($token) {
        $userId = UserSession::whereToken($token)->value('user_id');
        $user = User::whereId($userId)->first();
        return $user;
    }
}
