@extends('backend.layouts.master')

@section('content')
    
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Cotations Totale</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Earth::count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cotations validées</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Earth::where('status','valide')->count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total des primes
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{number_format(round(\App\Models\Earth::where('status','valide')->sum('prime')),0,","," ")}} Fcfa</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ratio</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{(\App\Models\Earth::where('status','valide')->count() / \App\Models\Earth::count()) * 100}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percent fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>N°</th>
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
                                    <td style="text-align: center">{{\App\Models\Customer::where('id', $item->customer_id)->value('name')}}</td>
                                    <td style="text-align: center">{{$item->nature_marchandise}}</td>
                                    <td style="text-align: center">{{number_format(round($item->prime),0,","," ")}}</td>
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

@endsection
