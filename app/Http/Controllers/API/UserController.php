<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewUserCredentials;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = User::with('roles', 'permissions')->latest();
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $password = Str::random(10);
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            // 'password' => 'required|string',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => $request->password,
            'password' => Hash::make($password),
        ]);
        $user->assignRole($request->role['name']);
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
        }

        Mail::to($user->email)->send(new NewUserCredentials($user, $password));

        return response(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // abort_if(Gate::denies('edit user'), 403, 'You do not have the required authorization.');
        $data = User::with('roles', 'permissions')->where('id', Auth::user()->id)->get();

        return response(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->password);
        $this->validate($request, [
            'name' => 'required|string|unique:users,name,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'required|sometimes',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        // dd($user, $request->password);
        if ($request->password) {
            // $user->password = $request->password;
            $user->password = Hash::make($request->password);
            $user->save();
        }
        foreach ($user->permissions as $permission) {
            $user->revokePermissionTo($permission['name']);
        }
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
        }

        return response(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response(['message' => 'success'], 200);
    }
}
