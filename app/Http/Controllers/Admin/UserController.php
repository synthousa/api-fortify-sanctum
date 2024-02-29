<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('role:system|admin');
    } 
    
    public function index(Request $request) {
        $data = User::latest()->paginate(10);

        return $request -> wantsJson()
            ? response() -> json(['list' => $data], 200)
            : redirect() -> view('users.index', compact('data'));
    }

    public function create() {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('data'));
    }

    public function store(Request $request) {
        $attributes = request()->validate([
            'name' => ['required', 'max:64'],
            'email' => ['required', 'email', 'max:64', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8'],
            'employee_id' => ['required', 'max:5'],
            'roles' => ['required'],
        ]);

        $user = User::create($attributes);
        $user->assignRole($attributes['roles']);

        return $request->wantsJson()
            ? response() -> json(['message' => 'user created'], 201)
            : redirect() -> view('users.index');
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
