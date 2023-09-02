<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ClientsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients=Clients::all();
        if (count($clients) <= 0) {
            return response(["message" => "Il n'a pas trouvé Clients"], 200);
        }
        return response()->json(['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mail'=>['required','string','email','max:100','unique:clients'],
            'first_name_client'=>['required','string'],
            'last_name_client'=>['required','string'],
            'password_client'=>['required','string','min:6'],
            'adress_client'=>['required','string'],
            'code_postal_client'=>['required','numeric'],
            'city_client'=>['required','string'],
            'country_client'=>['required','string'],
            'pays_client'=>['required','string'],
        ]);

        $dataClients = Clients::create([
            'mail'=>$validatedData['mail'],
            'first_name_client'=>$validatedData['first_name_client'],
            'last_name_client'=>$validatedData['last_name_client'],
            'password_client'=>$validatedData['password_client'],
            'adress_client'=>$validatedData['adress_client'],
            'code_postal_client'=>$validatedData['code_postal_client'],
            'city_client'=>$validatedData['city_client'],
            'country_client'=>$validatedData['country_client'],
            'pays_client'=>$validatedData['pays_client'],
            
        ]);
        return response()->json($dataClients);

    }

    /**
     * Display the specified resource.
     */
    public function detail($id)
    {
        $client= DB::table('clients')
        ->select('clients.*', 'bookings.pickup_date', "bookings.pickup_location", "bookings.return_location", "bookings.return_date",  "bookings.total_price", "bookings.vehicule_id", "bookings.agency_id", "bookings.client_id")
        ->leftJoin('bookings','clients.id', '=',  'bookings.client_id')
        ->where('clients.id','=',$id)
        ->whereNotNull('bookings.pickup_date')
        ->whereNotNull("bookings.pickup_location")
        ->whereNotNull("bookings.return_location")
        ->whereNotNull("bookings.total_price")
        ->whereNotNull("bookings.return_date")
        ->whereNotNull("bookings.client_id")
        ->whereNotNull("bookings.agency_id")
        ->whereNotNull("bookings.vehicule_id")
        ->get();
        if (count($client) <= 0) {
            return response(["message" => "No blocking clients"], 200);
        }
        
        return  $client;
    }



    public function show($id)
    {
        $clients = DB::table('clients')
        ->distinct()
        ->join('bookings', 'bookings.Client_id', '=', 'clients.id')
        ->join('agencies', 'agencies.id', '=', 'bookings.agency_id')
        ->where('agencies.id', '=', $id)
        ->select('clients.*','bookings.pickup_date', "bookings.pickup_location", "bookings.return_location", "bookings.return_date",  "bookings.total_price", "bookings.vehicule_id", "bookings.agency_id", "bookings.client_id")
        ->get();
        if (count($clients) <= 0) {
            return response(["message" => "No blocking clients"], 200);
        }
        return $clients;
        
    }
 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validatedData = $request->validate(array_merge([
            'mail'=>['required','string','email','max:100','unique:clients'],
            'first_name_client'=>['required','string'],
            'last_name_client'=>['required','string'],
            'password_client'=>['required','string','min:6'],
            'adress_client'=>['required','string'],
            'code_postal_client'=>['required','numeric'],
            'city_client'=>['required','string'],
            'country_client'=>['required','string'],
            'pays_client'=>['required','string'],
        ],
          ['password_client' => bcrypt($request->password_client)]
        ));
        $Client =Clients::find($id);
        if (!$Client) {
            return response(["message" => "Il n'a pas trouvé Client id $id"], 200);
        }
        $Client->update($validatedData);
        return response(['message'=>"Client mise a jour "],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $Client =Clients::find($id);

        if (!$Client) {
            return response(["message" => "Il n'a pas trouvé Client id $id"], 404);
        }
        $value= Clients::destroy($id);
        if(boolval($value)==false){
            return response(['message'=>"Il n'a pas trouvé Clients id $id"],404);
        }
        return response(['message'=>'Clients a ete supprimer ']);
    }
}
