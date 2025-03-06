<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\Patient_Assessment;
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
use Carbon\Carbon;

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
        $data = Patient::with('Barangay', 'Disease', 'Patient_Assessment')
            ->select('patients.*', 'tokenizeds.token', 'tokenizeds.originaldata')
            ->leftjoin('safetagumtokens.tokenizeds', 'patients.lastname', '=', 'tokenizeds.token')
            ->latest();

        if ($request->search) {
            $searchTerm = $request->search;

            $data = $data->where(function ($query) use ($searchTerm) {
                $query->where('lastname', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('Patient_Assessment', function ($query) use ($searchTerm) {
                        $query->where('epi_id', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhere('tokenizeds.originaldata', 'LIKE', '%' . $searchTerm . '%'); // Search in tokenizeds.originaldata
            });
        }
        // dd($data->latest());
        if ($request->barangay) {
            $data = $data->where('barangay_id',  $request->barangay);
        }
        if ($request->disease) {
            $data = $data->where('type_of_disease', $request->disease);
        }

        $data = $data->paginate($request->length);

        // dd($data);

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
            // 'barangay' => 'required',
            // 'date' => 'required',
        ]);
        //'data' => $data
        // $data = Patient::select('latitude', 'longitude')->with('barangay', 'disease')
        //     ->join('patient_assessments', 'patient_assessments.patient_id', '=', 'patients.id')
        //     // ->where('patients.barangay_id', $request->barangay['id'])
        //     ->where('patient_assessments.type_of_disease', $request->type_of_disease['id'])
        //     ->whereBetween('patient_assessments.date_onset_of_illness', [$request->date["startDate"], $request->date["endDate"]])
        //     ->get();

        // $cases = Patient::with('barangay', 'disease', 'patient_assessment')
        //     ->join('patient_assessments', 'patient_assessments.patient_id', '=', 'patients.id')
        //     ->where('patients.barangay_id', $request->barangay['id'])
        //     ->where('patient_assessments.type_of_disease', $request->type_of_disease['id'])
        //     ->whereBetween('patient_assessments.date_onset_of_illness', [$request->date["startDate"], $request->date["endDate"]])
        //     ->groupBy('barangay_id')
        //     ->selectRaw('barangay_id, 
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) as count_0_5,
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 ELSE 0 END) as count_6_10,
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 ELSE 0 END) as count_11_15,
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 ELSE 0 END) as count_16_above,
        //                  SUM(CASE WHEN patient_assessments.date_of_death IS NOT NULL THEN 1 ELSE 0 END) as total_deaths,
        //                  SUM(CASE WHEN patient_assessments.case_classification = "Confirmed" THEN 1 ELSE 0 END) as count_confirmed,
        //                  SUM(CASE WHEN patient_assessments.case_classification = "Probable" THEN 1 ELSE 0 END) as count_probable,
        //                  SUM(CASE WHEN patient_assessments.case_classification = "Suspected" THEN 1 ELSE 0 END) as count_suspected,
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) +
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 ELSE 0 END) +
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 ELSE 0 END) +
        //                  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 ELSE 0 END) as total_cases')
        //     ->orderBy('barangay_id', 'asc')
        //     ->get();

        $response = null;

        if (count($request->type_of_disease) > 1) {
            $formattedData = [];
            foreach ($request->type_of_disease as $disease) {
                $formattedData[$disease['name']] = $this->getDiseaseData($disease);
            }
            $baseUrl = env('FORECAST_API_URL', 'http://127.0.0.1:5000/forecastalldisease');
            $endpoint = '/forecastalldisease';
            $fullUrl = $baseUrl . $endpoint;
            $response = Http::post($fullUrl, ['diseases' => $formattedData]);
        } else {
            $baseUrl = env('FORECAST_API_URL', 'http://127.0.0.1:5000/forecast');
            $endpoint = '/forecast';
            $fullUrl = $baseUrl . $endpoint;
            $response = Http::post($fullUrl, [
                'data' => $this->getDiseaseData($request->type_of_disease[0]), // Send the formatted data
                'disease' => $request->type_of_disease[0]['name']
            ]);
        }
        $forecastData = $response->json();

        return response(['forecasting' => $forecastData], 200);
    }
    private function getDiseaseData($disease)
    {
        $formattedData = [];
        $data = Patient::select('patient_assessments.date_onset_of_illness')->with('barangay', 'disease')
            ->join('patient_assessments', 'patient_assessments.patient_id', '=', 'patients.id')
            // ->where('patients.barangay_id', $request->barangay['id'])
            ->where('patient_assessments.type_of_disease', $disease['id'])
            ->whereBetween('patient_assessments.date_onset_of_illness', ["2024-12-31T16:00:00.000Z", "2025-12-31T03:59:59.999Z"])
            ->get();


        foreach ($data as $item) {
            $dateOnset = Carbon::parse($item->date_onset_of_illness); // Use Carbon for date manipulation
            $year = $dateOnset->year;
            $weekNumber = $dateOnset->weekOfYear; // Carbon's weekOfYear gives you the ISO week number

            $formattedData[] = [
                'Year' => $year,
                'Morbidity_Week' => $weekNumber,
            ];
        }
        return $formattedData;
    }
    public function report(Request $request)
    {
        $this->validate($request, [
            'type_of_disease' => 'required',
            // 'barangay' => 'required',
            'date' => 'required',
        ]);

        $patient = Patient::select('latitude', 'longitude')
            ->join('patient_assessments', 'patient_assessments.patient_id', '=', 'patients.id')
            ->where('patient_assessments.type_of_disease', $request->type_of_disease['id'])
            ->whereBetween('patient_assessments.date_onset_of_illness', [$request->date["startDate"], $request->date["endDate"]])
            ->get();

        $cases = Patient::with('barangay', 'disease', 'patient_assessment')
            ->join('patient_assessments', 'patient_assessments.patient_id', '=', 'patients.id')
            ->where('patient_assessments.type_of_disease', $request->type_of_disease['id'])
            ->whereBetween('patient_assessments.date_onset_of_illness', [$request->date["startDate"], $request->date["endDate"]])
            ->groupBy('barangay_id')
            ->selectRaw('barangay_id, 
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) as count_0_5,
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 ELSE 0 END) as count_6_10,
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 ELSE 0 END) as count_11_15,
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 ELSE 0 END) as count_16_above,
                         SUM(CASE WHEN patient_assessments.date_of_death IS NOT NULL THEN 1 ELSE 0 END) as total_deaths,
                         SUM(CASE WHEN patient_assessments.case_classification = "Confirmed" THEN 1 ELSE 0 END) as count_confirmed,
                         SUM(CASE WHEN patient_assessments.case_classification = "Probable" THEN 1 ELSE 0 END) as count_probable,
                         SUM(CASE WHEN patient_assessments.case_classification = "Suspected" THEN 1 ELSE 0 END) as count_suspected,
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) +
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 6 AND 10 THEN 1 ELSE 0 END) +
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 11 AND 15 THEN 1 ELSE 0 END) +
                         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) > 15 THEN 1 ELSE 0 END) as total_cases')
            ->orderBy('barangay_id', 'asc')
            ->get();
        return response(['data' => $patient, 'cases' => $cases, 'user' => Auth::User()], 200);
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
            'streetpurok.name' => 'required|string',
            'barangay.id' => 'required|numeric',
            'city' => 'required|string',
            'province' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

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
            'street/purok' => $request->streetpurok['name'],
            'barangay_id' => $request->barangay['id'],
            'city' => $request->city,
            'province' => $request->province,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'last_modified_by' => $user->id,
        ]);

        return response(['message' => 'success'], 200);
    }
    public function assessment(Request $request, $id)
    {
        // dd($request);
        $user = Auth::User();

        $this->validate($request, [
            'case_id' => 'string',
            'epi_id' => 'required|string',
            'id' => 'required|numeric',
            'date_onset_of_illness' => 'required|date',
            'health_facility' => 'string',
            'patient_admitted' => 'date',
            'case_classification' => 'required|string',
            'date_of_death' => 'nullable|date',
            'type_of_disease.id' => 'required|numeric',
        ]);
        // dd($this->tokenize($request->firstname));
        $patient = Patient::findOrFail($id);
        Patient_Assessment::create([
            'case_id' => $request->case_id,
            'epi_id' => $request->epi_id,
            'patient_id' => $patient->id,
            'type_of_disease' => $request->type_of_disease['id'],
            'date_onset_of_illness' => $request->date_onset_of_illness,
            'health_facility' => $request->health_facility,
            'patient_admitted' => $request->patient_admitted,
            'case_classification' => $request->case_classification,
            'date_of_death' => $request->date_of_death,

            'assess_by' => $user->id,
        ]);

        return response(['message' => 'success'], 200);
    }
    public function updateassessment(Request $request, $id)
    {
        $user = Auth::User();

        $this->validate($request, [
            'case_id' => 'string',
            'epi_id' => 'required|string',
            // 'id' => 'required|numeric',
            'date_onset_of_illness' => 'required|date',
            'health_facility' => 'string',
            'patient_admitted' => 'date',
            'case_classification' => 'required|string',
            'date_of_death' => 'nullable|date',
            'type_of_disease.id' => 'required|numeric',
        ]);
        $patientassessment = Patient_Assessment::findOrFail($id);
        $patientassessment->update([
            'case_id' => $request->case_id,
            'epi_id' => $request->epi_id,
            // 'patient_id' => $patient->id,
            'type_of_disease' => $request->type_of_disease['id'],
            'date_onset_of_illness' => $request->date_onset_of_illness,
            'health_facility' => $request->health_facility,
            'patient_admitted' => $request->patient_admitted,
            'case_classification' => $request->case_classification,
            'date_of_death' => $request->date_of_death,

            'assess_by' => $user->id,
        ]);
        // dd($user, $request->password);
        // if ($request->password) {
        // $user->password = $request->password;
        // $user->password = Hash::make($request->password);

        // }
        $patientassessment->save();

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
            'streetpurok.name' => 'required|string',
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
            'street/purok' => $request->streetpurok['name'],
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
