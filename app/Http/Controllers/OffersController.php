<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\offers;
use Illuminate\Http\Request;

class OffersController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Offer=Offers::all();
        if (count($Offer) <= 0) {
            return response(["message" => "Il n'a pas trouvé Offers"], 200);
        }
        return response()->json($Offer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filename=null;
        $validatedData = $request->validate([
            "images" => ['required'],
            'offre_name'=>['required','string'],
            'Offre_description'=>['required','string'],
            'offre_dscount'=>['integer','required'],
            'start_date'=>['date','required'],
            'end_date'=>['required','date'],
            'agency_id'=>['numeric','required'],
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $filename = time() . '.' . $images->getClientOriginalExtension();
            $images->move(public_path('images/offers'), $filename);
            $images = $filename;
        }

        $dataOffers = Offers::create([
            "images" => $filename,
            'offre_name'=> $validatedData['offre_name'],
            'Offre_description'=> $validatedData[ 'Offre_description'],
            'offre_dscount'=> $validatedData['offre_dscount'],
            'start_date'=> $validatedData['start_date'],
            'end_date'=> $validatedData['end_date'],
            'agency_id'=> $validatedData['agency_id']
            
        ]);
        return response()->json(['Offers' =>  $dataOffers, 'message' => 'Offers ajoutée']);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $offer =DB::table('offers')
        ->join('agences','offers.agency_id','=','agences.id')
        ->select('offers.*','agences.agency_name')
        ->where('offers.id','=',$id)
        ->get()
        ->first();
        return $offer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'offre_name'=>['required','string'],
            'Offre_description'=>['required','string'],
            'offre_dscount'=>['integer','required'],
            'start_date'=>['date','required'],
            'end_date'=>['required','date'],
            'agency_id'=>['required','numeric'],
        ]);
        $Offer =Offers::find($id);
        if (!$Offer) {
            return response(["message" => "Il n'a pas trouvé d'Offers id $id"], 200);
        }
        if($Offer->agency_id != $validatedData["agency_id"]){

          return response(['message'=>'action interdite'],403);
        }
        $Offer->update($validatedData);
        return response(['message'=>"l'Offer mise a jour "],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $validatedData = $request->validate([
            "agency_id" => ['required', 'numeric']
        ]);
        $Offer =Offers::find($id);

        if (!$Offer) {
            return response(["message" => "Il n'a pas trouvé Offers id $id"], 404);
        }
        if($Offer->agency_id != $validatedData["agency_id"]){
          return response(['message'=>'action interdite'],403);
        }
        $value= Offers::destroy($id);
        if(boolval($value)==false){
            return response(['message'=>"Il n'a pas trouvé Offers id $id"],404);
        }
        return response(['message'=>'Offers a ete supprimer ']);
    }
}
