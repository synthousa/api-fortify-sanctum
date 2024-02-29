<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class PostController extends Controller {

    public function __construct() {
        $this->authorizeResource(Article::class);
    }

    public function index(Request $request) {
        $data = Article::latest()->paginate(10);

        return $request -> wantsJson()
            ? response() -> json(['list' => $data], 200)
            // : redirect() -> view('posts.index', compact('data'));
            : redirect('/');
    }

    public function create() {

        //
    }

    public function store(Request $request) {

        //
    }

    public function show(string $id) {
        //
    }

    public function edit(string $id) {
        //
    }

    public function update(Request $request, string $id) {

        //
    }

    public function destroy(string $id) {

        //
    }
}
