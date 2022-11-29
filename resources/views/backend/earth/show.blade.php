@extends('backend.layouts.master')

@section('content')
    

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('earth.index')}}">Cotation Terrestre</a></li>
            <li class="breadcrumb-item active" aria-current="page">Détails</li>
            </ol>
        </nav>

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
        <div class="contentbar">                
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-2"></div>
                <div class="col-lg-8 shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card m-b-30">
                        <div class="card-body py-5">
                            <h3 class="justify text-center text-primary">Détails de la Cotation</h3>
                            <div class="row">
                                <div class="col-lg-3 text-center">
                                   
                                </div>
                                <div class="col-lg-9">
                                    <h4>{{\App\Models\Customer::where('id', $earth->customer_id)->value('name')}}</h4>
                                    <p>{{\App\Models\Customer::where('id', $earth->customer_id)->value('address')}}</p>
                                    <p>{{\App\Models\Customer::where('id', $earth->customer_id)->value('activity')}}</p>
                                    <p>{{\App\Models\Customer::where('id', $earth->customer_id)->value('intermediaire')}}</p>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="p-1">Nature de la Marchandise :</th>
                                                    <td class="p-1">{{$earth->nature_marchandise}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Moyen de Transport :</th>
                                                    <td class="p-1">{{$earth->moyen_transport}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Conditionnement :</th>
                                                    <td class="p-1">{{$earth->conditionnement}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Territorialité :</th>
                                                    <td class="p-1">{{strtoupper($earth->depart)}} - {{strtoupper($earth->arrive)}} ({{$earth->distance}} Km)</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Classe :</th>
                                                    <td class="p-1">{{$earth->classe}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Nombre de camions ou de voyages :</th>
                                                    <td class="p-1">{{$earth->nbre_cam_voy}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Valeur assurée par voyage :</th>
                                                    <td class="p-1">{{$earth->val_voyage}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Prime nette :</th>
                                                    <td class="p-1">{{round($earth->prime_nette,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Accessoires :</th>
                                                    <td class="p-1">{{$earth->accessoire}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Taxes de prime :</th>
                                                    <td class="p-1">{{round($earth->taxes,2)}}</td>
                                                </tr>
                                                <tr class="text-warning">
                                                    <th scope="row" class="p-1">Prime totale :</th>
                                                    <td class="p-1">{{round($earth->prime)}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1"><a href="{{route('earth.pdf', $earth->id)}}" class="btn btn-lg btn-block btn-outline-success" data-toggle="tooltip" title="pdf" data-placement="bottom"><i class="fas fa-print"></i> Imprimer</a></th>
                                                    <td class="p-1">
                                                        <form class="" action="" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <a href="" class="dltBtn btn btn-lg btn-block btn-outline-danger" data-id="" data-toggle="tooltip" title="supprimer" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
                                                        </form>
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>

    </div>

@endsection

@section('title')
    Cotation Terrestre détails
@endsection

@section('script')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                titre : "Confirmation",
                text : "Cette cotation sera supprimé de la base de donnée",
                icon : "warning",
                buttons : true,
                dangerMode : true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    form.submit();
                    swal("Cotation supprimée avec succès", {
                        icon : "success",
                        
                    });
                }
                else {
                    swal("Action de suppression annulé");
                }
            })
        });
    </script>

@endsection