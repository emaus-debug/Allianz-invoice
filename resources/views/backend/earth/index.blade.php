@extends('backend.layouts.master')

@section('title')
    Cotation Terrestre
@endsection

@section('content')
    
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Liste des Clients</h1> --}}

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{route('earth.index')}}">Cotations Terrestre</a></li>
              <li class="breadcrumb-item active" aria-current="page">Liste des Cotations</li>
            </ol>
        </nav>
        
        <div>
            @include('backend.layouts.notification')
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Cotations (total : {{\App\Models\Earth::count()}})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Fait par</th>
                                <th>Client</th>
                                <th>Nature de la marchandise</th>
                                <th>Prime</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($earths as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="text-align: center">{{\App\Models\User::where('id', $item->user_id)->value('full_name')}}</td>
                                    <td style="text-align: center">{{\App\Models\Customer::where('id', $item->customer_id)->value('name')}}</td>
                                    <td style="text-align: center">{{$item->nature_marchandise}}</td>
                                    <td style="text-align: center">{{round($item->prime)}}</td>
                                    <td>
                                        <input type="checkbox" name="toogle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='valide' ? 'checked' : ''}} data-onlabel="valide" data-offlabel="soumis" data-size="sm" data-onstyle="success" data-offstyle="warning">
                                    </td>
                                    <td style="text-align: center">
                                        <div class="button-list">
                                            <a href="{{route('earth.show',$item->id)}}" data-toggle="tooltip" title="Voir" class="float-left mr-1 btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                        
                                            {{-- <a href="{{route('earth.edit',$item->id)}}" class="float-left mr-1 btn btn-sm btn-outline-warning" data-toggle="tooltip" title="modifier" data-placement="bottom"><i class="fas fa-edit"></i></a> --}}
                                        
                                            <form class="float-left" action="{{route('earth.destroy',$item->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="" class="dltBtn btn btn-sm btn-outline-danger" data-id="{{$item->id}}" data-toggle="tooltip" title="supprimer" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
                                            </form>
                                        </div>
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

    <script src="{{asset("backend/vendor/switch-button-bootstrap/src/bootstrap-switch-button.js")}}"></script>

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

    <script>
        $('input[name=toogle]').change(function (){
            var mode = $(this).prop('checked');
            var id = $(this).val();
            $.ajax({
                url: "{{route('earth.status')}}",
                type: "POST",
                data:{
                    _token:'{{csrf_token()}}',
                    mode:mode,
                    id:id,
                },
                success:function (response) {
                    if(response.status){
                        alert(response.msg)
                    }
                    else{
                        alert('Réessayez dans quelques instant s\'il vous plait...')
                    }
                }
            })
        });
    </script>

@endsection

@section('css_add')
    <link href="{{asset("backend/vendor/datatables/dataTables.bootstrap4.min.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("backend/vendor/switch-button-bootstrap/css/bootstrap-switch-button.css")}}">
@endsection