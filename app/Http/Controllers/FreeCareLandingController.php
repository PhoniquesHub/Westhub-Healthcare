<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FreeCareLandingController extends Controller
{
    public function __invoke(): View
    {
        return view('landing.free-care');
    }

    public function thanks(): View
    {
        // The conversion event fires only right after a real submission
        // (flash data), so refreshing the page doesn't count a second lead.
        return view('landing.free-care-thanks', [
            'justSubmitted' => (bool) session('free_care_submitted', false),
        ]);
    }
}
