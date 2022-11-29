<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerProfile extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id')->get();
        //return $customers;
        return view('backend.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customer.create');
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
            'name' => 'string|required',
            'address' => 'string|nullable',
            'phone' => 'string|nullable',
            'num_compte' => 'string|nullable',
            'intermediaire' => 'string|nullable',
            'activity' => 'string|nullable',
        ]);

        $data = $request->all();
        // return $data;
        $status = Customer::create($data);
        if ($status){
            return redirect()->route('customer.index')->with('success', 'Client crée avec succès');
        }
        else{
            return back()->with('error', 'Une erreur a été détecté, veuillez réessayer s\'il vous plait');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        if($customer){
            return view('backend.customer.edit', compact('customer'));
        }
        else{
            return back()->with('error','Données introuvables');
        }
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
        $customer = Customer::find($id);
        if($customer){
            $this->validate($request, [
                'name' => 'string|required',
                'address' => 'string|nullable',
                'phone' => 'string|nullable',
                'num_compte' => 'string|nullable',
                'intermediaire' => 'string|nullable',
                'activity' => 'string|nullable',
            ]);
    
            $data = $request->all();
            $status = $customer->fill($data)->save();
            if ($status){
                return redirect()->route('customer.index')->with('success', 'Client mis à jour avec succès');
            }
            else{
                return back()->with('error', 'Une erreur a été détecté, veuillez réessayer s\'il vous plait');
            }            
        }
        else{
            return back()->with('error','Données introuvables');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if($customer){
            $status = $customer->delete();
            if ($status){
                return redirect()->route('customer.index')->with('success', 'Client supprimé avec succès');
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
