<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Destination;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        $destinations = Destination::latest()->get();
        $testimonials = Testimonial::latest()->get();

        
        return view('frontend.home',compact('sliders','destinations','testimonials'));
    }
}
