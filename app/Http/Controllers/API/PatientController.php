<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function forecast(Request $request)
    {
        // dd($request);
        // abort_if(Gate::denies('list permission'), 403, 'You do not have the required authorization.');
        $this->validate($request, [
            'barangay' => 'required',
            'date' => 'required',
        ]);

        $data = Patient::selectRaw('FLOOR(patients.latitude * 1000) / 1000 AS latitude, FLOOR(patients.longitude * 1000) / 1000 AS longitude, COUNT(*) as count, STDDEV(patients.latitude) * 111300 AS radius, "green" as color')
            // ->with('barangay', 'disease')
            ->groupBy('latitude', 'longitude')
            ->where('patients.barangay', $request->barangay['id'])
            ->whereBetween('patients.created_at', $request->date)
            ->get();

        //
        $randomforestResult = (new RandomForestPrediction('C:\Users\Mark Bangcaya\Downloads\Data.csv', ['Malaria', 'Measles']))->predictResult();
        dd($randomforestResult);
        // if ($request->search) {
        //     $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        // }
        // dd($data);
        // $data = $data->paginate($request->length);

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
        $user = Auth::User();

        $this->validate($request, [
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'occupation' => 'required|string',
            'civil_status' => 'required|string',
            'nationality' => 'required|string',
            'contact_number' => 'required|numeric',
            // 'email' => 'required|email|unique:email',
            'email' => 'required|email',
            'type_of_disease.id' => 'required|numeric',

            //Patient Address
            'streetpurok' => 'required|string',
            'barangay.id' => 'required|numeric',
            'city' => 'required|string',
            'province' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        // dd($request->barangay['id']);
        Patient::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'civil_status' => $request->civil_status,
            'nationality' => $request->nationality,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'type_of_disease' => $request->type_of_disease['id'],

            //Patient Address
            'street/purok' => $request->streetpurok,
            'barangay' => $request->barangay['id'],
            'city' => $request->city,
            'province' => $request->province,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'last_modified_by' => $user->id,
        ]);

        return response(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
