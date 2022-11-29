@extends('backend.layouts.master')

@section('content')
    

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Profile Client</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
            </ol>
        </nav>

        <div class="row">
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
        </div>
        
    </div>

@endsection

@section('title')
    Ajouter un client
@endsection

