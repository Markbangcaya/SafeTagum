<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purok;
use App\Models\Barangay;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = Purok::with('Barangay')->latest();

        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->barangay) {
            $data = $data->where('barangay_id',  $request->barangay);
        }
        $data = $data->paginate($request->length);

        return response(['data' => $data], 200);
    }

    public function index_all()
    {
        $data = Purok::all();

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
        $this->validate($request, [
            'name' => 'required|string',
            'barangay.id' => 'required|numeric',
        ]);

        Purok::create([
            'name' => $request->name,
            'barangay_id' => $request->barangay['id'],
        ]);

        return response(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purok  $purok
     * @return \Illuminate\Http\Response
     */
    public function show(Purok $purok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purok  $purok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // abort_if(Gate::denies('edit permission'), 403, 'You do not have the required authorization.');
        $this->validate($request, [
            'name' => 'required|string|unique:puroks,name,' . $request->id,
        ]);
        $purok = Purok::findOrFail($id);

        $purok->update([
            'name' => $request->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purok  $purok
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purok = Purok::findOrFail($id);
        $purok->delete();

        return response(['message' => 'success'], 200);
    }
}
