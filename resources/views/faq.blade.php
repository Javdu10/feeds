@extends('layouts.app')

@section('content')
<div class="accordion" id="accordionExample">
    <div class="card">
        <button id="headingOne" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            Pourquoi poster un article est payant ?
        </button>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                Cette mesure permet de décourager les personnes cherchant à nuire aux autres usagés mais aussi de reduire considerablement le spam, ce qui permet d'avoir des articles de meilleur qualité
            </div>
        </div>
    </div>
    <div class="card">
        <button id="headingTwo" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Pourquoi utiliser FranceConnect ?
        </button>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                FranceConnect nous permet d'assurer que les personnes qui vote sont des personnes réelle.
            </div>
        </div>
    </div>
</div>
@endsection