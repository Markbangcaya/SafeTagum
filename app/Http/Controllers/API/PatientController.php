<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\Tokenized;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Phpml\Regression\LeastSquares;
use Phpml\Regression\ARIMA;
use Phpml\CrossValidation\CrossValidation;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = Patient::with('Barangay', 'Disease')->latest();

        if ($request->search) {
            $data = $data->where('email', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);
        return response(['data' => $data], 200);
    }
    private function detokenize($data)
    {
        //
        //https://github.com/shetabit/token-builder
        // $token = Str::random(60);
        //Check the get to first for blockchain implementation
        $token = Tokenized::select('originaldata')->where('token', $data)->first();

        return $token;
    }
    public function detokenized($id)
    {
        //Check the get to first for blockchain implementation
        $user = Patient::where('id', $id)->first();

        // abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        // $data = Patient::with('Barangay', 'Disease')->latest();
        // if ($request->search) {
        //     $data = $data->where('email', 'LIKE', '%' . $request->search . '%');
        // }
        // $data = $data->paginate($request->length);
        return response([
            'firstname' => $this->detokenize($user['firstname']),
            'middlename' => $this->detokenize($user['middlename']),
            'lastname' => $this->detokenize($user['lastname'])
        ], 200);
    }
    private function tokenize($data)
    {
        //
        //https://github.com/shetabit/token-builder
        $token = Str::random(60);

        Tokenized::create(['token' => $token, 'originaldata' => $data]);

        return $token;
    }
    public function forecast(Request $request)
    {
        $prediction = null;
        // dd($request);
        // abort_if(Gate::denies('list permission'), 403, 'You do not have the required authorization.');
        $this->validate($request, [
            'type_of_disease' => 'required',
            'barangay' => 'required',
            // 'date' => 'required',
        ]);

        $data = Patient::select('latitude', 'longitude')
            ->with('barangay', 'disease')
            ->groupBy('latitude', 'longitude')
            ->where('patients.barangay_id', $request->barangay['id'])
            ->where('patients.type_of_disease', $request->type_of_disease['id'])
            // ->whereBetween('patients.created_at', $request->date)
            ->get();

        $response = Http::get('http://127.0.0.1:5000/forecast');
        $forecastData = $response->json();

        return response(['forecasting' => $forecastData, 'data' => $data], 200);
    }
    public function report(Request $request)
    {
        $this->validate($request, [
            'type_of_disease' => 'required',
            // 'barangay' => 'required',
            'date' => 'required',
        ]);
        $patient = Patient::select('latitude', 'longitude')
            ->with('barangay', 'disease')
            // ->groupBy('latitude', 'longitude')
            // ->where('patients.barangay_id', $request->barangay['id'])
            ->where('patients.type_of_disease', $request->type_of_disease['id'])
            ->whereBetween('patients.created_at', [$request->date["startDate"], $request->date["endDate"]])
            ->get();

        $cases = Patient::with('barangay', 'disease')
            ->where('patients.type_of_disease', $request->type_of_disease['id'])
            ->whereBetween('patients.created_at', [$request->date["startDate"], $request->date["endDate"]])
            ->groupBy('barangay_id')
            ->selectRaw('barangay_id, 
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 
                            ELSE 0 
                         END) as count_0_5,
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 
                            ELSE 0 
                         END) as count_6_10,
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 
                            ELSE 0 
                         END) as count_11_15,
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 
                            ELSE 0 
                         END) as count_16_above,
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 
                            ELSE 0 
                         END) +
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 
                            ELSE 0 
                         END) +
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 
                            ELSE 0 
                         END) +
                         SUM(CASE 
                            WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 
                            ELSE 0 
                         END) as total_cases')
            ->orderBy('barangay_id', 'asc')
            ->get();
        // dd($cases);
        return response(['data' => $patient, 'cases' => $cases], 200);
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
        // dd($this->tokenize($request->firstname));

        Patient::create([
            'firstname' => $this->tokenize($request->firstname),
            'middlename' => $this->tokenize($request->middlename),
            'lastname' => $this->tokenize($request->lastname),
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
            'barangay_id' => $request->barangay['id'],
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
    public function update(Request $request, $id)
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
        $patient = Patient::findOrFail($id);
        $patient->update([
            // 'firstname' => $this->tokenize($request->firstname),
            // 'middlename' => $this->tokenize($request->middlename),
            // 'lastname' => $this->tokenize($request->lastname),
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
            'barangay_id' => $request->barangay['id'],
            'city' => $request->city,
            'province' => $request->province,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'last_modified_by' => $user->id,
        ]);
        // dd($user, $request->password);
        // if ($request->password) {
        // $user->password = $request->password;
        // $user->password = Hash::make($request->password);

        // }
        $patient->save();

        return response(['message' => 'success'], 200);
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
