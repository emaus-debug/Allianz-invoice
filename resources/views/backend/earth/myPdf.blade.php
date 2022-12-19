<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>PDF</title>
  <link href="{{public_path('backend/css/sb-admin-2.css')}}" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-sm bg-white">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><img src="{{public_path('img/logo.png')}}" alt="" style="width: 15%"></li>
    </ul>
  </nav>
  <div class="row">
    <div class="col-sm-12">
      <div class="card" style="border: none;">
        <div class="card-title py-4 shadow-lg rounded bg-gray" style="background-color:darkgray">
          <h5 class="mb-0 text-center text-white"><strong>PROPOSITION D'ASSURANCE</strong></h5>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-8">
      {{-- Client --}}
      <h5 class="text-primary"> I. PROFIL DU CLIENT</h5>
      <div class="table-responsive">
        <table class="table table-borderless">
          <tbody class="text-primary" style="font-size:15px">
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Nom :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('name')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Adresse :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('address')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Contact :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('phone')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1"style="width: 400px">Activité Principale :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('activity')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Numéro de compte contribuable :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('num_compte')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Intermédiaire :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('intermediaire')}}</td>
            </tr>  
          </tbody>
        </table>
      </div>
      <h5 class="text-primary"> II. DESCRIPTION DU RISQUE</h5>
      <div class="table-responsive">
        <table class="table table-borderless">
          <tbody class="text-primary" style="font-size:15px">
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Nature marchandise :</th>
                <td class="p-1">{{$earth->nature_marchandise}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Mode de Transport :</th>
                <td class="p-1">{{$earth->mode_transport}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Territorialité :</th>
                <td class="p-1">{{strtoupper($earth->depart)}} - {{strtoupper($earth->arrive)}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Moyen de Transport :</th>
                <td class="p-1">{{$earth->moyen_transport}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Conditionnement :</th>
                <td class="p-1">{{$earth->conditionnement}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 400px">Valeur Assurée par voyage :</th>
                <td class="p-1">{{$earth->val_voyage}}</td>
            </tr>  
          </tbody>
        </table>
      </div>
      <h5 class="text-primary"> III. RISQUE GARANTIE & FRANCHISE</h5>
      <span class="text-primary">GARANTIE :</span>
      <p>
        "<mark>Accidents Caractérisés + Vols Consécutifs</mark> 
        @if ($earth->garantie_chargement)
          + <mark>Garantie Chargement/Déchargement</mark> 
        @endif 
        @if ($earth->transp_prof)
            + <mark>Transporteur non Professionnel</mark>
        @endif
        @if ($earth->etat_route)
            + <mark>Route Accidenté</mark>
        @endif
        "
      </p>

      <span class="text-primary">FRANCHISE :</span>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">VALEUR ASSUREE</th>
            <th scope="col">FRANCHISE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Moins de 5 000 000 Fcfa</td>
            <td>10% de dommage avec un minimum de 250 000 Fcfa</td>
          </tr>
          <tr>
            <td>Entre 5 000 000 et 10 000 000 Fcfa</td>
            <td>10% de dommage avec un minimum de 500 000 Fcfa</td>
          </tr>
          <tr>
            <td>Plus de 10 000 000 Fcfa</td>
            <td>Minimum au cas par cas</td>
          </tr>
        </tbody>
      </table>


      <h5 class="text-primary"> IV. ETENDUE DES RISQUES</h5>
      <p>La garantie s'étend du site de {{strtoupper($earth->depart)}} à {{strtoupper($earth->arrive)}}</p>

      <h5 class="text-primary"> V. DUREE DES RISQUES</h5>
      <p>La garantie est offerte pour la durée du voyage et joue pendant deux mois</p>

      <h5 class="text-primary"> VI. TARIFICATION</h5>
      
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td>Prime HT</td>
            <td>{{number_format(round($earth->prime_nette,2),0,","," ")}}</td>
          </tr>
          <tr>
            <td>Accessoires</td>
            <td>{{number_format($earth->accessoire,0,","," ")}}</td>
          </tr>
          <tr>
            <td>Taxe (14.50%)</td>
            <td>{{number_format(round($earth->taxes,2),0,","," ")}}</td>
          </tr>
          <tr>
            <td>Prime TTC</td>
            <td>{{number_format(round($earth->prime),0,","," ")}}</td>
          </tr>
        </tbody>
      </table>
      
        <span >Fait à Abidjan le {{date("d/m/Y H:i:s")}}</span>
        <br>
        <span >{{\App\Models\User::where('id', $earth->user_id)->value('full_name')}}</span>
        <br>
        <span >{{\App\Models\User::where('id', $earth->user_id)->value('email')}}</span>
        <br>
        <span >{{\App\Models\User::where('id', $earth->user_id)->value('phone')}}</span>
        <br>
      </div>
    </div>
  </div>
  

</body>