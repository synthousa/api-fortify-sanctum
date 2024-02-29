<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class PostController extends Controller {

    public function __construct() {
        $this->authorizeResource(Article::class, 'article');
        // $this->middleware(['permission:post_access|post_item|post_create|post_update|post_delete'], ['only' => ['index', 'show']]);
        // $this->middleware(['permission:post_create'], ['only' => ['create', 'store']]);
        // $this->middleware(['permission:post_update'], ['only' => ['edit', 'update']]);
        // $this->middleware(['permission:post_delete'], ['only' => ['destroy']]);        
    }

    public function index(Request $request) {
        $data = Article::latest()->paginate(69);

        return $request -> wantsJson()
            ? response() -> json(['list' => $data], 200)
            // : redirect() -> view('posts.index', compact('data'));
            : redirect('/');
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $articleAttributes = request() -> validate([
            'title' => ['required', 'max:99'],
            'slug' => ['required', 'max:99'],
            'img' => ['required', 'max:99'],
            'img_desc' => ['required', 'max:999'],
            'body' => ['required', 'max:16037'],
            'user_id' => ['max:5'],
        ]);
        
        Article::create([
            'title' => $articleAttributes['title'],
            'slug' => $articleAttributes['slug'],
            'img' => $articleAttributes['img'],
            'img_desc' => $articleAttributes['img_desc'],
            'body' => $articleAttributes['body'],
            'user_id' => $request->user()->id,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'article created'], 201);
        }

        return redirect()->route('posts.index');
    }

    public function show(Article $article) {
        return view('posts.show', compact('article'));
    }

    public function edit(Article $article) {
        return view('posts.edit', compact('article'));
    }

    public function update(Request $request, string $id) {
        $articleAttributes = request() -> validate([
            'title' => ['required', 'max:99'],
            'slug' => ['required', 'max:99'],
            'img' => ['required', 'max:99'],
            'img_desc' => ['required', 'max:999'],
            'body' => ['required', 'max:16037'],
        ]);
        
        $posts-> $product->update($articleAttributes);

        return $request->wantsJson()
            ? response()->json(['message' => 'article updated'], 202)
            : redirect()->route('posts.index');
    }

    public function destroy(Request $request, string $user_id) {

        $post = Article::where('id', $user_id)->firstOrFail();
        $post->delete();

        return $request->wantsJson()
            ? response()->json(['message' => 'article deleted'], 200)
            : redirect()->route('users.index');
            // : redirect('/');
    }
}