<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Formulaire Demande Stagiaire</title>

<style>

body{
font-family: DejaVu Sans, sans-serif;
font-size:12px;
}

h2{
text-align:center;
}

.section{
margin-bottom:15px;
}

.label{
font-weight:bold;
}

</style>

</head>

<body>

<h2>FORMULAIRE DE DEMANDE DE STAGIAIRE</h2>

<div class="section">
<span class="label">Département :</span> {{ $besoin->departement }}
</div>

<div class="section">
<span class="label">Demandeur :</span> {{ $besoin->poste }}
</div>

<div class="section">
<span class="label">Responsable :</span> {{ $besoin->responsable_nom }}
</div>

<div class="section">
<span class="label">Fonction :</span> {{ $besoin->fonction }}
</div>

<div class="section">
<span class="label">Date :</span> {{ $besoin->date_requete }}
</div>

<div class="section">
<span class="label">Type de demande :</span> {{ $besoin->type_demande }}
</div>

<div class="section">
<span class="label">Service :</span> {{ $besoin->service }}
</div>

<div class="section">
<span class="label">Encadrant :</span> {{ $besoin->encadrant }}
</div>

<div class="section">
<span class="label">Domaine :</span> {{ $besoin->domaine_formation }}
</div>

<div class="section">
<span class="label">Niveau :</span> {{ $besoin->niveau_etudes }}
</div>

<div class="section">
<span class="label">Compétences :</span> {{ $besoin->competences }}
</div>

<div class="section">
<span class="label">Durée :</span> {{ $besoin->duree }}
</div>

<div class="section">
<span class="label">Nombre stagiaires :</span> {{ $besoin->nombre_stagiaires }}
</div>

<div class="section">
<span class="label">Période :</span> {{ $besoin->periode }}
</div>

</body>
</html>