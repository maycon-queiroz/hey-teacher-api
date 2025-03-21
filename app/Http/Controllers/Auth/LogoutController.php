<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        auth()->guard('web')->logout();

        return response()->noContent();
    }
}
