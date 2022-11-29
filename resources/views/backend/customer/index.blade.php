@extends('backend.layouts.master')

@section('title')
    Profiles Clients
@endsection

@section('content')
    
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Liste des Clients</h1> --}}

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{route('customer.index')}}">Profile Client</a></li>
              <li class="breadcrumb-item active" aria-current="page">Liste des clients</li>
            </ol>
        </nav>
        
        <div>
            @include('backend.layouts.notification')
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Clients (total : {{\App\Models\Customer::count()}})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Numéro de téléphone</th>
                                <th>Numéro de compte contribuable</th>
                                <th>Activité Principale</th>
                                <th>Intermédiaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="text-align: center">{{$customer->name}}</td>
                                    <td style="text-align: center">
                                        @if ($customer->address == "")
                                            <span >-</span>
                                        @else 
                                        {{$customer->address}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if ($customer->phone == "")
                                            <span >-</span>
                                        @else 
                                        {{$customer->phone}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if ($customer->num_compte == "")
                                            <span >-</span>
                                        @else 
                                        {{$customer->num_compte}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if ($customer->activity == "")
                                            <span >-</span>
                                        @else 
                                        {{$customer->activity}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if ($customer->intermediaire == "")
                                            <span >-</span>
                                        @else 
                                        {{$customer->intermediaire}}
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <a href="{{route('customer.edit',$customer->id)}}" class="float-left mr-1 btn btn-sm btn-outline-warning" data-toggle="tooltip" title="modifier" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        
                                        <form class="float-left" action="{{route('customer.destroy',$customer->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="" class="dltBtn btn btn-sm btn-outline-danger" data-id="{{$customer->id}}" data-toggle="tooltip" title="supprimer" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
                                        </form>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <!-- Page level plugins -->
    <script src="{{asset("backend/vendor/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("backend/vendor/datatables/dataTables.bootstrap4.min.js")}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset("backend/js/demo/datatables-demo.js")}}"></script>

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
                text : "Cet client sera supprimé de la base de donnée",
                icon : "warning",
                buttons : true,
                dangerMode : true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    form.submit();
                    swal("Client supprimé avec succès", {
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

@section('css_add')
    <link href="{{asset("backend/vendor/datatables/dataTables.bootstrap4.min.css")}}" rel="stylesheet">
@endsection