<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Earth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earths = Earth::orderBy('id')->get();
        //return $customers;
        return view('backend.earth.index', compact('earths'));
    }


    public function earthStatus(Request $request)
    {
        if ($request->mode == "true"){
            DB::table('earths')->where('id', $request->id)->update(['status' => 'valide']);
        }
        else{
            DB::table('earths')->where('id', $request->id)->update(['status' => 'soumis']);
        }
        return response()->json(['msg' => 'Status mis à jour avec succès', 'status' => true]);
    }

    public function downloadPDF($id)
    {
        $earth = Earth::find($id);

        $pdf = PDF::loadView('backend.earth.myPdf', compact('earth'));
        return $pdf->download('Cotation_Terrestre.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.earth.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        #return $request->all();
        #$data = $request->all();

        // Classe 1
        if ($request->input('classe') == 1 ){
            $this->validate($request, [
                'nature_marchandise' => 'string|required',
                'moyen_transport' => 'string|required',
                'classe' => 'string|required',
                'val_voyage' => 'string|required',
                'nbre_cam_voy' => 'string|required',
                'conditionnement' => 'string|nullable',
                'depart' => 'string|required',
                'arrive' => 'string|required',
                'customer_id' => 'required|exists:customers,id',
                'distance' => 'string|required',
                'garantie_chargement' => 'sometimes|in:1',
                'transp_prof' => 'sometimes|in:1',
                'etat_route' => 'sometimes|in:1',
                'status' => 'nullable|in:valide,soumis',
            ]);
            $data = $request->all();
            $data['mode_transport'] = "terrestre";
            $id = Auth::user()->id;
            $data['user_id'] = $id;

            // Moins de 100 Km
            if ($data['distance'] <= 100){

                $prime_nette = $data['val_voyage'] * (0.15/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }  
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }
            }

            // Entre 100 et 200 Km
            elseif ($data['distance'] > 100 and $data['distance'] <= 200){

                $prime_nette = $data['val_voyage'] * (0.2/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.530;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }  
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }
            
            // plus de 200 Km
            elseif ($data['distance'] > 200){
                
                $prime_nette = $data['val_voyage'] * (0.30/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }  
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }

        }

        //Classe 2
        elseif ($request->input('classe') == 2 ){
            $this->validate($request, [
                'nature_marchandise' => 'string|required',
                'moyen_transport' => 'string|required',
                'classe' => 'string|required',
                'val_voyage' => 'string|required',
                'nbre_cam_voy' => 'string|required',
                'conditionnement' => 'string|nullable',
                'depart' => 'string|required',
                'arrive' => 'string|required',
                'customer_id' => 'required|exists:customers,id',
                'distance' => 'string|required',
                'garantie_chargement' => 'sometimes|in:1',
                'transp_prof' => 'sometimes|in:1',
                'etat_route' => 'sometimes|in:1',
                'status' => 'nullable|in:valide,soumis',
            ]);
            $data = $request->all();
            $data['mode_transport'] = "terrestre";
            $id = Auth::user()->id;
            $data['user_id'] = $id;

            // Moins de 100 Km
            if ($data['distance'] <= 100){

                $prime_nette = $data['val_voyage'] * (0.2/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }   
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }
            }

            // Entre 100 et 200 Km
            elseif ($data['distance'] > 100 and $data['distance'] <= 200){

                $prime_nette = $data['val_voyage'] * (0.3/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.80;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }   
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }
            
            // plus de 200 Km
            elseif ($data['distance'] > 200){
                
                $prime_nette = $data['val_voyage'] * (0.4/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }  
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }

        }

        //Classe 3
        elseif ($request->input('classe') == 3 ){
            $this->validate($request, [
                'nature_marchandise' => 'string|required',
                'moyen_transport' => 'string|required',
                'classe' => 'string|required',
                'val_voyage' => 'string|required',
                'nbre_cam_voy' => 'string|required',
                'conditionnement' => 'string|nullable',
                'depart' => 'string|required',
                'arrive' => 'string|required',
                'taux' => 'string|required',
                'customer_id' => 'required|exists:customers,id',
                'distance' => 'string|required',
                'garantie_chargement' => 'sometimes|in:1',
                'transp_prof' => 'sometimes|in:1',
                'etat_route' => 'sometimes|in:1',
                'status' => 'nullable|in:valide,soumis',
            ]);
            $data = $request->all();
            $data['mode_transport'] = "terrestre";
            $id = Auth::user()->id;
            $data['user_id'] = $id;

            // Moins de 100 Km
            if ($data['distance'] <= 100){

                $prime_nette = $data['val_voyage'] * (floatval($data['taux'])/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            } 
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }
            }

            // Entre 100 et 200 Km
            elseif ($data['distance'] > 100 and $data['distance'] <= 200){

                $prime_nette = $data['val_voyage'] * (floatval($data['taux'])/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.80;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }  
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }
            
            // plus de 200 Km
            elseif ($data['distance'] > 200){
                
                $prime_nette = $data['val_voyage'] * (floatval($data['taux'])/100) * $data['nbre_cam_voy'];

                if($data['garantie_chargement'] == 1){
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.50;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.40;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.35;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                        }
                        else {
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.30;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.15;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                        }
                    }
                    else {
                        if($data['nbre_cam_voy'] < 10){
                            $prime_nette = $prime_nette * 1.10;
                        }
                        elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                            $prime_nette = $prime_nette * 1;   
                        }
                        elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                            $prime_nette = $prime_nette * 0.95;   
                        }
                        elseif ($data['nbre_cam_voy'] > 100) {
                            $prime_nette = $prime_nette * 0.90;   
                        }
                    }
                }
                else{
                    if($data['transp_prof'] == 1){
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.40;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.30;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.25;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1.20;   
                            }
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }
                        }
                    }
                    else{
                        if($data['etat_route'] == 1){
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1.20;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 1.10;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 1.05;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 1;   
                            }   
                        }
                        else{
                            if($data['nbre_cam_voy'] < 10){
                                $prime_nette = $prime_nette * 1;
                            }
                            elseif ($data['nbre_cam_voy'] >= 10 && $data['nbre_cam_voy'] <= 50) {
                                $prime_nette = $prime_nette * 0.90;   
                            }
                            elseif ($data['nbre_cam_voy'] >= 50 && $data['nbre_cam_voy'] <= 100) {
                                $prime_nette = $prime_nette * 0.85;   
                            }
                            elseif ($data['nbre_cam_voy'] > 100) {
                                $prime_nette = $prime_nette * 0.80;   
                            }
                        }
                    }
                }

                $accessoire = 2500 * $data['nbre_cam_voy'];

                $taxes = (14.5/100) * ($prime_nette + $accessoire);

                $prime = $prime_nette + $accessoire + $taxes;

                $data['prime_nette'] = $prime_nette;
                $data['accessoire'] = $accessoire;
                $data['taxes'] = $taxes;
                $data['prime'] = $prime;

                $status = Earth::create($data);

                if($status){
                    return redirect()->route('earth.index')->with('success', 'Cotation réalisé avec succès');
                }
                else {
                    return back()->with('error', 'Une erreur s\'est produite');
                }

            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $earth = Earth::find($id);
        if($earth){
            return view('backend.earth.show', compact('earth'));
        }
        else{
            return back()->with('error', 'Cotation non trouvée');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $earth = Earth::find($id);
        // if($earth){
        //     return view('backend.earth.edit', compact('earth'));
        // }
        // else{
        //     return back()->with('error','Données introuvables');
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $earth = Earth::find($id);
        if($earth){
            $status = $earth->delete();
            if ($status){
                return redirect()->route('earth.index')->with('success', 'Cotation supprimé avec succès');
            }
            else{
                return back()->with('error', 'Une erreur s\'est produite, veuillez réessayer');
            }
        }
        else{
            return back()->with('error','Données introuvables');
        }
    }
}
