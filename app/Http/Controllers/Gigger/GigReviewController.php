<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigReviewController extends Controller
{
    public function view(Request $request)
    {
        $gigPlaybook = GigPlaybook::with('review', 'review.reviewer', 'review.reviewee')->find($request['id']);
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigReviewDetail', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigReview' => $gigPlaybook->review,
        ]);
    }
}
