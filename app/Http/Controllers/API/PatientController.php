<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Phpml\Regression\LeastSquares;
use Phpml\CrossValidation\CrossValidation;
use Illuminate\Support\Facades\Storage;

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
        $prediction = null;
        // dd($request);
        // abort_if(Gate::denies('list permission'), 403, 'You do not have the required authorization.');
        $this->validate($request, [
            'type_of_disease' => 'required',
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
        // $randomforestResult = (new RandomForestPrediction('C:\Users\Mark Bangcaya\Downloads\Data.csv', ['Malaria', 'Measles']))->predictResult();

        $filePath = public_path('Data.csv');
        // $file = $request->file($filePath); // Assuming input name is 'csv_file'

        if (file_exists($filePath)) {
            // Validate the file if necessary
            // $validatedData = $request->validate([
            //     'csv_file' => 'required|file|mimes:csv,xlsx'
            // ]);
            // Read the CSV file
            // $data = Excel::toArray(new YourImport, $file);

            $file = fopen($filePath, 'r');
            $header = fgetcsv($file); // Read header row
            while (($row = fgetcsv($file)) !== false) {
                $alldataset[] = array_combine($header, $row);
            }

            fclose($file);

            // dd($alldataset);
            foreach ($alldataset as $row) {
                if ($row['Disease'] === $request->type_of_disease['name']) {
                    $dataset[] = $row;
                }
            }

            // dd($dataset);
            // Split data into training and testing sets
            $trainSize = floor(count($dataset) * 0.8);
            $trainData = array_slice($dataset, 0, $trainSize);
            $testData = array_slice($dataset, $trainSize);

            // Prepare training data
            $trainSamples = [];
            $trainTargets = [];
            for ($i = 1; $i < count($trainData); $i++) {
                $trainSamples[] = [$trainData[$i - 1]['Number of reported cases']];
                $trainTargets[] = $trainData[$i]['Number of reported cases'];
            }

            // dd($trainSamples, $trainTargets);

            // Create and train the model
            $model = new LeastSquares();
            $model->train($trainSamples, $trainTargets);

            // Prepare test data
            $testSamples = [];
            $testTargets = [];
            for ($i = 1; $i < count($testData); $i++) {
                $testSamples[] = [$testData[$i - 1]['Number of reported cases']];
                $testTargets[] = $testData[$i]['Number of reported cases'];
            }

            // Make predictions
            $prediction = $model->predict($testSamples);

            // Calculate MSE
            $mse = 0;
            for ($i = 0; $i < count($prediction); $i++) {
                $error = $prediction[$i] - $testTargets[$i];
                $mse += $error * $error;
            }
            $mse /= count($prediction);

            // dd($mse, $prediction);
            // return response()->json(['message' => 'CSV imported successfully'], 200);
        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }

        // if ($request->search) {
        //     $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        // }

        // $data = $data->paginate($request->length);

        return response(['data' => $data, 'prediction' => round($prediction[0], 2)], 200);
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
