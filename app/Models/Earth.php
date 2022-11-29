<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earth extends Model
{
    use HasFactory;
    protected $fillable = ['nature_marchandise','mode_transport','depart','arrive','distance','moyen_transport','val_voyage','conditionnement','nbre_cam_voy','garantie_chargement','transp_prof','etat_route','prime_nette','prime','accessoire','taxes','classe', 'customer_id','user_id','status'];

}
