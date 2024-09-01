<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function show(Destination $destination){

        return view('frontend.destination.detail',compact('destination'));
    }
}
