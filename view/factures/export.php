<?php
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=my-data_" . date('Y-m-d') . ".xls");  
header("Pragma: no-cache"); 
header("Expires: 0"); 

// 🔹 Indexation des tableaux pour accès direct par ID
$usersById = [];
foreach ($users as $u) $usersById[$u->id] = $u;

$patientsById = [];
foreach ($patients as $p) $patientsById[$p->id] = $p;

$prescripteursById = [];
foreach ($prescripteurs as $pr) $prescripteursById[$pr->id] = $pr;

$prestationsById = [];
foreach ($prestations as $pr) $prestationsById[$pr->id] = $pr;

$servicesById = [];
foreach ($services as $s) $servicesById[$s->id] = $s;

$output  = "
<table>
    <thead>
        <tr>
            <th>N° facture</th>
            <th>Date création</th>
            <th>Agent</th>
            <th>Patient</th>
            <th>Prescripteur</th>
            <th>Type de patient</th>
            <th>Prestation</th>
            <th>Service</th>
            <th>Réduction</th>
            <th>Charge de réduction</th>
            <th>Net à payer</th>
            <th>Montant global</th>
            <th>Projet</th>
        </tr>
    </thead>
    <tbody>
";

foreach ($factures as $v) {
    // 🔹 Calcul réduction
    switch ($v->reduction) {
        case 100:
        case 101:
            $reduction = 100;
            break;
        default:
            $reduction = $v->reduction * 100;
            break;
    }

    // 🔹 Préparer données liées
    $user = $usersById[$v->user_id] ?? null;
    $patient = $patientsById[$v->patient_id] ?? null;
    $prescripteur = $prescripteursById[$v->prescripteur_id] ?? null;
    $prestation = $prestationsById[$v->prestation_id] ?? null;
    $service = $servicesById[$v->service_id] ?? null;

    $net_a_payer = $mont_reduite = 0;
    if ($prestation) {
        switch ($v->reduction) {
            case 0:
                $net_a_payer = $prestation->montant_prestat;
                $mont_reduite = 0;
                break;
            case 100:
            case 101:
                $net_a_payer = 0;
                $mont_reduite = $prestation->montant_prestat;
                break;
            default:
                $mont_reduite = $v->reduction * $prestation->montant_prestat;
                $net_a_payer = $prestation->montant_prestat - $mont_reduite;
                break;
        }
    }

    // 🔹 Projet si réduction 101
    $projet = ($v->reduction == 101) ? "Oui" : "";

    // 🔹 Construction de la ligne
    $output .= "<tr>
        <td>{$v->num}</td>
        <td>{$v->date_creation}</td>
        <td>".($user ? $user->prenom_user." ".$user->nom_user : "")."</td>
        <td>".($patient ? $patient->prenom_patient." ".$patient->nom_patient : "")."</td>
        <td>".($prescripteur ? $prescripteur->prenom_prescripteur." ".$prescripteur->nom_prescripteur : "")."</td>
        <td>".($patient ? $patient->type_client : "")."</td>
        <td>".($prestation ? $prestation->intitule_prestat : "")."</td>
        <td>".($service ? $service->intitule_serv : "")."</td>
        <td>{$reduction}%</td>
        <td>{$mont_reduite}</td>
        <td>{$net_a_payer}</td>
        <td>".($prestation ? $prestation->montant_prestat : "")."</td>
        <td>{$projet}</td>
    </tr>";
}

$output .= "
    </tbody>
</table>
";

echo $output;
?>
