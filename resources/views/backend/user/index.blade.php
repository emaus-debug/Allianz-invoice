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
              <li class="breadcrumb-item"><a href="{{route('user.index')}}">Utilisateurs</a></li>
              <li class="breadcrumb-item active" aria-current="page">Liste des utilisateurs</li>
            </ol>
        </nav>
        
        <div>
            @include('backend.layouts.notification')
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Utilisateurs (total : {{\App\Models\User::count()}})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>E-Mail</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><img src="{{$user->photo}}" alt="user photo" style="border-radius: 50%; max-height:90px; max-width: 120px;"></td>
                                    <td style="text-align: center">{{$user->full_name}}</td>
                                    <td style="text-align: center">{{$user->email}}</td>
                                    <td style="text-align: center">{{$user->role}}</td>
                                    <td>
                                        <input type="checkbox" name="toogle" value="{{$user->id}}" data-toggle="switchbutton" {{$user->status=='active' ? 'checked' : ''}} data-onlabel="actif" data-offlabel="inactif" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                    <td style="text-align: center">
                                        <a href="{{route('user.edit',$user->id)}}" class="float-left mr-1 btn btn-sm btn-outline-warning" data-toggle="tooltip" title="modifier" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        
                                        <form class="float-left" action="{{route('user.destroy',$user->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="" class="dltBtn btn btn-sm btn-outline-danger" data-id="{{$user->id}}" data-toggle="tooltip" title="supprimer" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
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
    <script src="{{asset("backend/vendor/switch-button-bootstrap/src/bootstrap-switch-button.js")}}"></script>
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

    <script>
        $('input[name=toogle]').change(function (){
            var mode = $(this).prop('checked');
            var id = $(this).val();
            $.ajax({
                url: "{{route('user.status')}}",
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