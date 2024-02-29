<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('role:system|admin');
    } 
    
    public function index(Request $request) {
        $data = User::latest()->paginate(10);

        return $request->wantsJson()
            ? response()->json(['list' => $data], 200)
            : redirect()->view('users.index', compact('data'));
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

        $transaction = Transaction::create([
            'dept_id' => $request->user()->id,
            'user_id' => $request->user()->id,
            'status' => 1
        ]);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            'employee_id' => $attributes['employee_id'],
        ]);

        $user->assignRole($attributes['roles']);

        return $request->wantsJson()
            ? response()->json(['message' => 'user created'], 201)
            : redirect()->view('users.index');
    }

    public function show(string $id) {
        //
    }


    public function edit(string $id) {
        //
    }

    public function update(Request $request, string $id) {

        $attributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id)],
            'password' => ['same:confirm-password'],
            'roles' => ['required'],
        ]);

        if(!empty($attributes['password'])){ 
            $attributes['password'] = Hash::make($attributes['password']);
        }else{
            $attributes = Arr::except($attributes,array('password'));    
        }

        $user = User::find($id);
        $user->update($attributes);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($attributes['roles']);

        return $request->wantsJson()
            ? response()->json(['message' => 'user updated'], 201)
            : redirect()->back();          
    }

    public function destroy(Request $request, string $id) {

        User::find($id)->delete();

        return $request->wantsJson()
            ? response()->json(['message' => 'user deleted'], 200)
            : redirect()->route('users.index');
    }

}
