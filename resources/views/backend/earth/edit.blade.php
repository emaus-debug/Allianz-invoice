@extends('backend.layouts.master')

@section('content')
    

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('earth.index')}}">Cotation Terrestre</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
            </ol>
        </nav>

        {{-- <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 ">
                <div class="card">

                        <form action="{{route('customer.store')}}" method="post">
                            @csrf
                            <!-- 2 column grid layout with text inputs for the first and last names -->
                            <div class="row">
                
                                <div class="col-2"></div>
                                <div class="col-8">

                                    <div class="col-md-12">
                                        @if ($errors -> any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control"/>
                                        <label class="form-label" for="name">Nom <span class="text-danger">*</span></label>
                                    </div>
                                
                                    <!-- Text input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" name="address" id="address" value="{{old('address')}}" class="form-control" />
                                        <label class="form-label" for="adress">Adresse</label>
                                    </div>
                                
                                    <!-- Text input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" name="phone" value="{{old('phone')}}" id="phone" class="form-control" />
                                        <label class="form-label" for="phone">Numéro de Téléphone</label>
                                    </div>
                                
                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <input type="texte" name="num_compte" value="{{old('num_compte')}}" id="num_compte" class="form-control" />
                                        <label class="form-label" for="num_compte">Numéro Compte Contribuable</label>
                                    </div>
                                
                                    <!-- Number input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" name="intermediaire" value="{{old('intermediaire')}}" id="intermediaire" class="form-control" />
                                        <label class="form-label" for="intermediaire">Intermédiaire</label>
                                    </div>
                                
                                    <!-- Message input -->
                                    <div class="form-outline mb-4">
                                        <textarea class="form-control" name="activity" id="activity" rows="2">{{old('activity')}}</textarea>
                                        <label class="form-label" for="activity">Activité Principale</label>
                                    </div>
                    
                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Valider</button>
                                </div>
                                <div class="col-2"></div>
                
                            </div>
                        
                        </form>

                </div>
            </div>
            <div class="col-md-2"></div>
        </div> --}}

        <div class="col-md-12">
            @if ($errors -> any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form class="form-horizontal row" action="{{route('earth.store')}}" method="post">
            @csrf
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">Nature de la Marchandise</label>
                    <div class="col-sm-8">
                        <input type="text" name="nature_marchandise" value="{{old('nature_marchandise')}}" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-4">Moyen de Transport</label>
                    <div class="col-sm-8">
                        <input type="text" name="moyen_transport" value="{{old('moyen_transport')}}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-sm-8">
                        <label class="col-sm-4 control-label">Classe</label>
                        <select id="classe_id" name="classe" class="form-control" aria-label="Default select example">
                            <option value="">-- Classe --</option>
                            <option value="1" {{old('classe') == '1' ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('classe') == '2' ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('classe') == '3' ? 'selected' : ''}}>3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group d-none" id="taux_cl3">
                    <label class="control-label col-sm-5">Taux</label>
                    <div class="col-sm-8">
                        <input name="taux" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5">Valeur Assurée par voyage</label>
                    <div class="col-sm-8">
                        <input name="val_voyage" type="text" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Nombre Camion / Voyage</label>
                    <div class="col-sm-8">
                        <input name="nbre_cam_voy" type="text" class="form-control" placeholder="nombre de camion ou de voyage">
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Conditionnement</label>                    
                    <div class="col-sm-8">
                        <input name="conditionnement" type="text" class="form-control">
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Ville départ</label>
                    <div class="col-sm-8">
                        <input name="depart" type="text" class="form-control" placeholder="Départ">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Ville Arrivée</label>
                    <div class="col-sm-8">
                        <input name="arrive" type="text" class="form-control" placeholder="Arrivée">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Distance (Km)</label>
                    <div class="col-sm-8">
                        <input name="distance" type="text" class="form-control" placeholder="distance en kilomètres">
                    </div>
                </div>
            </div>

            <div class="col-sm-10">
                <div class="form-group">
                    <label class="control-label col-sm-4">Client</label>
                    <div class="col-sm-12">
                        <select name="customer_id" id="customer" class="form-control" aria-label="Default select example">
                            <option value="">-- Client --</option>
                            @foreach (\App\Models\Customer::get() as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-12 col-form-label">Etat de la Bannière</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="status">
                            <option value="">-- statut --</option>
                            <option value="valide" {{old('status') == 'valide' ? 'selected' : ''}}>Validé</option>
                            <option value="soumis" {{old('status') == 'soumis' ? 'selected' : ''}}>Soumis</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-sm-10">
                <h4 class="">Garantie & Majoration</h3>
                <div class="row">

                    <div class="col-sm-4">
                
                        <div class="form-check">
                            <input class="form-check-input" name="garantie_chargement" value="1" type="checkbox"  >
                            <label class="form-check-label" for="flexCheckDefault">
                                Chargement/Déchargement
                            </label>
                        </div>
                    </div>
    
                    <div class="col-sm-4">
                        <div class="form-check">
                            <input class="form-check-input" value="1" name="transp_prof" type="checkbox" >
                            <label class="form-check-label" for="flexCheckDefault">
                                Transporteur non Professionnel
                            </label>
                        </div>
                        
                    </div>

                    <div class="col-sm-4">
                        <div class="form-check">
                            <input class="form-check-input" name="etat_route" type="checkbox" value="1" >
                            <label class="form-check-label" for="flexCheckDefault">
                                Mauvais état de la Route
                            </label>
                        </div>
                    </div>

                </div>
                
                
            </div>

            <div class="col-sm-2"></div>
            <div class="col-4"></div>
            <div class="p-2">
                <button class="btn btn-primary waves-effect waves-light" id="btn-submit">Save</button>
            </div>
            <input type="hidden" name="action" id="action" value="event_dialog_add_newpartnerdata" />
        </form>

    </div>

@endsection

@section('title')
    Ajouter une Cotation Terrestre
@endsection

@section('script')
    <script>
        $('#classe_id').change(function(){
            var classe_id = $(this).val();
            // alert(classe_id);
            if(classe_id == 3) 
            {
                $('#taux_cl3').addClass('d-block');
            }
            else{
                $('#taux_cl3').removeClass('d-block');
            }
        })
    </script>
@endsection