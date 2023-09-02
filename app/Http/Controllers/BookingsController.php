<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\bookings;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings=bookings::all();
        if (count($bookings) <= 0) {
            return response(["message" => "Il n'a pas trouvé cette reservation "], 200);
        }
        return response()->json($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pickup_date'=>['required','date'],
            'return_date'=>['required','date'],
            'pickup_location'=>['required','string'],
            'return_location'=>['required','string'],
            'total_price'=>['required','numeric'],
            'vehicule_id'=>['numeric'],
            'agency_id'=>['numeric'],
            'client_id'=>['numeric'],
        ]);

        $databookings = bookings::create([
            'pickup_date'=>$validatedData['pickup_date'],
            'return_date'=>$validatedData['return_date'],
            'pickup_location'=>$validatedData['pickup_location'],
            'return_location'=>$validatedData['return_location'],
            'total_price'=>$validatedData['total_price'],
            'vehicule_id'=>$validatedData['vehicule_id'],
            'agency_id'=>$validatedData['agency_id'],
            'client_id'=>$validatedData['client_id'],
        ]);
        return response()->json($databookings);

    }
           
      
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bookings =DB::table('bookings')
        ->join('clients','bookings.Client_id','=','clients.id')
        ->select('bookings.*','clients.first_name_client','clients.last_name_client')
        ->where('bookings.id','=',$id)
        ->get()
        ->first();
        return $bookings;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'pickup_date'=>['required','datetime'],
            'return_date'=>['required','datetime'],
            'pickup_location'=>['required','string'],
            'return_location'=>['required','string'],
            'total_price'=>['required','numeric'],
            'vehicule_id'=>['required','numeric'],
            'agency_id'=>['required','numeric'],
            'client_id'=>['required','numeric'],
        ]);

        $bookings = bookings::find($id);
        if (!$bookings) {
            return response(["message" => "Il n'a pas trouvé bookings id $id"], 200);
        }
        if($bookings->agency_id != $validatedData["agency_id"]){
          return response(['message'=>'action interdite'],403);
        }
        $bookings->update($validatedData);
        return response(['message'=>"bookings mise a jour "],201);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking =bookings::find($id);

        if (!$booking) {
            return response(["message" => "Il n'a pas trouvé bookings id $id"], 404);
        }
        $value= bookings::destroy($id);
        if(boolval($value)==false){
            return response(['message'=>"Il n'a pas trouvé bookings id $id"],404);
        }
        return response(['message'=>'vehicules a ete supprimer ']);
    }
}
