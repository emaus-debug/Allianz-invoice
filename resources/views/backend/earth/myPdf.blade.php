<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>PDF</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAq046MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-expand-sm bg-white">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><img src="{{asset('img/logo.png')}}" alt=""></li>
    </ul>
  </nav>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="card" style="border: none;">
        <div class="card-title py-4 shadow-lg rounded bg-gray" style="background-color:darkgray">
          <h5 class="mb-0 text-center text-white"><strong>PROPOSITION D'ASSURANCE</strong></h5>
        </div>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>

  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
      {{-- Client --}}
      <h3 class="text-primary"> I. PROFIL DU CLIENT</h3>
      <div class="table-responsive">
        <table class="table table-borderless">
          <tbody class="text-primary">
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Nom :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('name')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Adresse :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('address')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Contact :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('phone')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1"style="width: 700px">Activité Principale :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('activity')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Numéro de compte contribuable :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('num_compte')}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Intermédiaire :</th>
                <td class="p-1">{{\App\Models\Customer::where('id', $earth->customer_id)->value('intermediaire')}}</td>
            </tr>  
          </tbody>
        </table>
      </div>
      <h3 class="text-primary"> II. DESCRIPTION DU RISQUE</h3>
      <div class="table-responsive">
        <table class="table table-borderless">
          <tbody class="text-primary">
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Nature marchandise :</th>
                <td class="p-1">{{$earth->nature_marchandise}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Mode de Transport :</th>
                <td class="p-1">{{$earth->mode_transport}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Territorialité :</th>
                <td class="p-1">{{strtoupper($earth->depart)}} - {{strtoupper($earth->arrive)}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Moyen de Transport :</th>
                <td class="p-1">{{$earth->moyen_transport}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Conditionnement :</th>
                <td class="p-1">{{$earth->conditionnement}}</td>
            </tr>
            <tr>
                <th scope="row" class="p-1" style="width: 700px">Valeur Assurée par voyage :</th>
                <td class="p-1">{{$earth->val_voyage}}</td>
            </tr>  
          </tbody>
        </table>
      </div>
      <h3 class="text-primary"> III. RISQUE GARANTIE & FRANCHISE</h3>
      <div class="table-responsive">
        <table class="table table-borderless">
          <tbody class="text-primary">
            <tr>
                <th scope="row" class="p-1" style="width: 700px">GARANTIE :</th>
                <td class="p-1"><< Accidents Caractérisés + Vols Consécutifs 
                  @if ($earth->garantie_chargement){
                    + Garantie Chargement/Déchargement
                  }
                  @endif 
                  @if ($earth->transp_prof)
                      + Transporteur non Professionnel
                  @endif
                  @if ($earth->etat_route)
                      + Route Accidenté
                  @endif
                  >>
                </td>
            </tr>
            <tr>
                <th class="p-1" style="width: 700px">FRANCHISE :</th>
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
            </tr>
          </tbody>
        </table>
      </div>

      <h3 class="text-primary"> IV. ETENDUE DES RISQUES</h3>
      <p>La garantie s'étend du site de {{strtoupper($earth->depart)}} à {{strtoupper($earth->arrive)}}</p>

      <h3 class="text-primary"> V. DUREE DES RISQUES</h3>
      <p>La garantie est offerte pour la durée du voyage et joue pendant deux mois</p>

      <h3 class="text-primary"> VI. TARIFICATION</h3>
      
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td>Prime HT</td>
            <td>{{round($earth->prime_nette,2)}}</td>
          </tr>
          <tr>
            <td>Accessoires</td>
            <td>{{$earth->accessoire}}</td>
          </tr>
          <tr>
            <td>Taxe (14.50%)</td>
            <td>{{round($earth->taxes,2)}}</td>
          </tr>
          <tr>
            <td>Prime TTC</td>
            <td>{{round($earth->prime)}}</td>
          </tr>
        </tbody>
      </table>
      
        <span style="float: right">Fait à Abidjan le {{date("d/m/Y H:i:s")}}</span>
        <br>
        <span style="float: right">{{\App\Models\User::where('id', $earth->user_id)->value('full_name')}}</span>
        <br>
        <span style="float: right">{{\App\Models\User::where('id', $earth->user_id)->value('email')}}</span>
        <br>
        <span style="float: right">{{\App\Models\User::where('id', $earth->user_id)->value('phone')}}</span>
        <br>
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
  

</body>