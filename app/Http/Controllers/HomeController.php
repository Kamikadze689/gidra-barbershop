<?php
namespace App\Http\Controllers;
use App\Models\Master;
use App\Models\Service;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = Review::where('approved', true)->latest()->get();

         
        $services = Service::orderBy('sort_order')->get();

        return view('pages.home', [
            'masters'  => Master::all(),
            'services' => $services,
            'reviews'  => $reviews
        ]);
    }
}