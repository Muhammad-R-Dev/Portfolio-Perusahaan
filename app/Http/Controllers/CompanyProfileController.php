<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Gallery;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $services = \App\Models\Service::all();
        return view('pages.home', compact('services'));
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function about()
    {
        $teams     = Team::aktif()->orderBy('urutan')->get();
        $galleries = Gallery::latest()->get();

        return view('pages.about', compact('teams', 'galleries'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function login()
    {
        return view('pages.login');
    }
}
