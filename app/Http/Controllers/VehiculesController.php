<?php

namespace App\Http\Controllers;

use App\Models\vehicules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicule = vehicules::all();
        if (count($vehicule) <= 0) {
            return response(["message" => "Il n'a pas trouvé Vehicules"], 200);
        }
        return response()->json($vehicule);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filename = null;
        $validatedData = $request->validate([
            "images" => ['required'],
            "model" => ['required', 'string'],
            'year' => 'required|date',
            "color" => ['required', 'string'],
            "mileage" => ['required', 'numeric'],
            "fuel_type" => ['required', 'string'],
            "daily_price" => ['required', 'numeric'],
            "weekly_price" => ['required', 'numeric'],
            "monthly_price" => ['required', 'numeric'],
            "agency_id" => ['required', 'numeric'],
        ]);
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $filename = time() . '.' . $images->getClientOriginalExtension();
            $images->move(public_path('images/vehicules'), $filename);
            $images = $filename;
        }

        $dataVehicules = vehicules::create([
            "images" => $filename,
            "model" => $validatedData['model'],
            'year' => $validatedData['year'],
            "color" => $validatedData['color'],
            "mileage" => $validatedData['mileage'],
            "fuel_type" => $validatedData['fuel_type'],
            "daily_price" => $validatedData['daily_price'],
            "weekly_price" => $validatedData['weekly_price'],
            "monthly_price" => $validatedData['monthly_price'],
            "agency_id" => $validatedData['agency_id'],
        ]);
        return response()->json($dataVehicules);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Vehicule = DB::table('vehicules')
            ->join('agencies', 'vehicules.agency_id', '=', 'agencies.id')
            ->select('vehicules.*', 'agencies.agency_name')
            ->where('vehicules.id', '=', $id)
            ->get()
            ->first();
        return $Vehicule;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            "images" => ['required', 'mimes:png,jpeg,jpg'],
            "model" => ['required', 'string'],
            'year' => 'required|date',
            "color" => ['required', 'string'],
            "mileage" => ['required', 'numeric'],
            "fuel_type" => ['required', 'string'],
            "daily_price" => ['required', 'numeric'],
            "weekly_price" => ['required', 'numeric'],
            "monthly_price" => ['required', 'numeric'],
            "agency_id" => ['required', 'numeric'],
        ]);

        $Vehicule = vehicules::findOrFail($id);
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $filename = time() . '.' . $images->getClientOriginalExtension();
            if ($Vehicule->images && file_exists(public_path($Vehicule->images))) {
                unlink(public_path($Vehicule->image));
            }
            $images->move(public_path('images/vehicules'), $filename);
            $Vehicule->images = $filename;
        }
        $Vehicule->model = $request->input('model');
        $Vehicule->year = $request->input('year');
        $Vehicule->color = $request->input('color');
        $Vehicule->mileage = $request->input('mileage');
        $Vehicule->fuel_type = $request->input('fuel_type');
        $Vehicule->daily_price = $request->input('daily_price');
        $Vehicule->weekly_price = $request->input('weekly_price');
        $Vehicule->monthly_price = $request->input('monthly_price');
        $Vehicule->agency_id = $request->input('agency_id');
        $Vehicule->save();
        return $Vehicule;


        // print_r($request);
        // $Vehicule = vehicules::find($id);
        // $Vehicule->model = $request->input('model');
        // $Vehicule->year = $request->input('year');
        // $Vehicule->color = $request->input('color');
        // $Vehicule->mileage = $request->input('mileage');
        // $Vehicule->fuel_type = $request->input('fuel_type');
        // $Vehicule->daily_price = $request->input('daily_price');
        // $Vehicule->weekly_price = $request->input('weekly_price');
        // $Vehicule->monthly_price = $request->input('monthly_price');
        // $Vehicule->agency_id = $request->input('agency_id');


        // print_r($Vehicule);
        // if (!$Vehicule) {
        //     return response(["message" => "Il n'a pas trouvé Vehicule id $id"], 200);
        // }
        // if ($Vehicule->agency_id != $request["agency_id"]) {

        //     return response(['message' => 'action interdite'], 403);
        // }
        // $Vehicule->save();

        // return response(['message' => $id], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $vehicule = vehicules::find($id);

        if (!$vehicule) {
            return response(["message" => "Il n'a pas trouvé vehicules id $id"], 404);
        }
        $value = vehicules::destroy($id);
        if (boolval($value) == false) {
            return response(['message' => "Il n'a pas trouvé vehicules id $id"], 404);
        }
        return response(['message' => 'vehicules a ete supprimer ']);
    }
}
