<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use jcobhams\NewsApi\NewsApi;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsapi = new NewsApi(env('TOKEN_NEWS'));
        $blogs = $newsapi->getEverything('bitcoin');
        $blogs = $blogs->articles;
        $users = Http::get(env('URL_RAND'));
        $users = $users->json();

        return view('blogs', compact(['blogs', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogController $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogController $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogController $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogController $blog)
    {
        //
    }
}
