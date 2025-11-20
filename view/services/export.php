<?php
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=my-data_" . date('Y-m-d') . ".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0"); ?>

<?php $output .="

    <table >
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
        <tbody>"; ?>
            <?php foreach ($factures as $k => $v) : ?>
                <?php
                switch ($v->reduction) {
                    case 100:
                    case 101:
                        $reduction = 1 * 100;
                        break;
                    default:
                        $reduction = $v->reduction * 100 ;
                        break;
                }
                ?>

                        <?php $output .= "<tr>
                                <td>".$v->num."</td>
                                <td>".$v->date_creation."</td>" ?>
                                    <?php foreach($users as $k => $w): ?>
                                        <?php if ($v->user_id == $w->id): ?>
                                        <?php $output .= "<td>".$w->prenom_user." ".$w->nom_user."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php foreach($patients as $k => $x): ?>
                                        <?php if ($v->patient_id == $x->id): ?>
                                        <?php $output .= "<td>".$x->prenom_patient." ".$x->nom_patient."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php foreach($prescripteurs as $k => $o): ?>
                                        <?php if ($v->prescripteur_id == $o->id): ?>
                                        <?php $output .= "<td>".$o->prenom_prescripteur." ".$o->nom_prescripteur."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php foreach($patients as $k => $x): ?>
                                        <?php if ($v->patient_id == $x->id): ?>
                                        <?php $output .= "<td>".$x->type_client."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php foreach($prestations as $k => $y): ?>
                                        <?php if ($v->prestation_id == $y->id): ?>
                                                        <?php
                                                            switch ($v->reduction) {
                                                                case 0:
                                                                    $net_a_payer = $y->montant_prestat;
                                                                    $mont_reduite = 0;
                                                                    break;
                                                                case 100:
                                                                case 101:
                                                                    $net_a_payer = 0;
                                                                    $mont_reduite = $y->montant_prestat;
                                                                    break;
                                                                default:
                                                                    $mont_reduite = $v->reduction * $y->montant_prestat ;
                                                                    $net_a_payer = $y->montant_prestat - $mont_reduite;
                                                                    break;
                                                            }
                                                        ?>
                                                
                                        <?php $output .= "<td>".$y->intitule_prestat."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php foreach($services as $k => $z): ?>
                                        <?php if ($v->service_id == $z->id): ?>
                                        <?php $output .= "<td>".$z->intitule_serv."</td>" ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                        <?php $output .= "<td>".$reduction. '%'."</td>" ; ?>
                                        
                                        <?php $output .= "<td>".$mont_reduite."</td>" ;?>
                                        <?php $output .= "<td>".$net_a_payer."</td>"; ?>
                                        
                                        <?php foreach($prestations as $k => $y): ?>
                                            <?php if ($v->prestation_id == $y->id): ?>
                                                <?php $output .= "<td>".$y->montant_prestat."</td>" ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                <?php if ($v->reduction == 101): ?>
                                    <?php $projet = "Oui"; $output .= "<td>".$projet."</td>"; ?>
                                <?php endif ?>
                        <?php $output .= "</tr>"; ?>

            <?php endforeach ?>
        <?php $output .= "
        </tbody>
    </table>"; 
    
    echo $output
?>