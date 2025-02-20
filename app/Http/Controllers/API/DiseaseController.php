<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = Disease::latest();

        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);
        return response(['data' => $data], 200);
    }
    public function index_all()
    {
        $data = Disease::all();
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
        //
        $user = Auth::User();

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        Disease::create([
            'name' => $request->name,
        ]);

        return response(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // abort_if(Gate::denies('edit permission'), 403, 'You do not have the required authorization.');
        $this->validate($request, [
            'name' => 'required|string|unique:diseases,name,' . $request->id,
        ]);
        $disease = Disease::findOrFail($id);
        $disease->update([
            'name' => $request->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $disease = Disease::findOrFail($id);
        $disease->delete();
        return response(['message' => 'success'], 200);
    }
}
