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
use Illuminate\Support\Facades\DB;

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
        $data = User::with('roles', 'permissions', 'barangay')->latest();
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);
        // dd($data);
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
        // return DB::transaction(function () use ($request) {
        $password = Str::random(10);
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'role.name' => 'required|string',
            'barangay.id' => $request->role['name'] === 'user' ? 'required|numeric' : 'nullable|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => $request->password,
            'password' => Hash::make($password),
            'barangay_id' => $request->barangay['id'] ?? null,
        ]);

        $user->assignRole($request->role['name']);
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
        }

        Mail::to($user->email)->send(new NewUserCredentials($user, $password));

        // Rollback the transaction to prevent saving
        // DB::rollBack();

        return response(['message' => 'success'], 200);
        // });
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
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|unique:users,name,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'roles.name' => 'required|string',
            'barangay.id' => $request->roles['name'] === 'user' ? 'required|numeric' : 'nullable|numeric',
            'password' => 'required|sometimes',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'barangay_id' => $request->barangay['id'] ?? null,
        ]);
        // //wont safe if no barangay id and cant edit role
        // if ($request->barangay['id'] != null) {
        //     $user->barangay_id = $request->barangay['id'];
        // }
        if ($request->password) {
            // $user->password = $request->password;
            $user->password = Hash::make($request->password);
        }
        // Revoke old roles and assign the new role
        if ($request->roles['name']) {
            $user->syncRoles([$request->roles['name']]); // Sync the new role
        }

        // Revoke all permissions and assign the new ones
        $user->permissions()->detach(); // Detach all existing permissions
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission['name']);
            }
        }

        // Save the user
        $user->save();

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
