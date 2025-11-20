<div class="container content-boxes">
    <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>   
            
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background-color: #0a2558; color:white;">
                    <tr>
                        <th scope="col">Numéro facture</th>
                        <th scope="col">Date de facturation</th>
                        <th scope="col">Prescripteur</th>
                        <th scope="col">Agent</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Service</th>
                        <th scope="col">Prestation</th>
                        <th scope="col">Net ï¿½ payer</th>
                        <th scope="col">Prise en charge</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach($factures as $k => $v): ?>

                                    <tr>
                
                                        <td><?php echo $v->num; ?></td>
                                        <td>
                                            <?php
                                            // Suppose que $v->date_creation est dans le format 'Y-m-d' ou 'Y-m-d H:i:s'
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->date_creation);
                                            // Si la date ne contient pas de temps (juste 'Y-m-d')
                                            if (!$date) {
                                                $date = DateTime::createFromFormat('Y-m-d', $v->date_creation);
                                            }
                                            // Affiche la date au format jj/mm/aaaa si la conversion a rï¿½ussi
                                            if ($date) {
                                                echo $date->format('d/m/Y');
                                            } else {
                                                echo "Date invalide"; // Gï¿½rer les dates invalides
                                            }
                                            ?>
                                        </td>
                                            <?php foreach($prescripteurs as $k => $w): ?>
                                                <?php if ($v->prescripteur_id == $w->id): ?>
                                                    <td><a href="<?php echo Router::url("admin/prescripteurs/detail/{$w->id}"); ?>"><?php echo "$w->prenom_prescripteur $w->nom_prescripteur"; ?></a></td>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            
                                            <?php foreach($users as $k => $w): ?>
                                                <?php if ($v->user_id == $w->id): ?>
                                                    <td><?php echo "$w->prenom_user $w->nom_user"; ?></td>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            
                                            <?php foreach($patients as $k => $w): ?>
                                                <?php if ($v->patient_id == $w->id): ?>
                                                    <td><?php echo "$w->prenom_patient $w->nom_patient"; ?></td>
                                                <?php endif ?>
                                            <?php endforeach ?>
                
                                            <?php foreach($prestations as $k => $w): ?>
                                                <?php if ($v->prestation_id == $w->id): ?>
                                                    <?php foreach($services as $k => $u): ?>
                                                        <?php if ($w->service_id == $u->id): ?>
                                                            <td><?php echo $u->intitule_serv; ?></td>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            <?php endforeach ?>
                
                                            <?php foreach($prestations as $k => $w): ?>
                                                <?php if ($v->prestation_id == $w->id): ?>
                                                    <td><?php echo $w->intitule_prestat." <b>...<b>"; ?></td>
                                                <?php endif ?>
                                            <?php endforeach ?>
                
                                            <td><?php echo number_format($v->montant_global,0,',',' ')." Fcfa"; ?></td>
                                            <td><?php echo number_format($v->pec,0,',',' ')." Fcfa"; ?></td>
                
                                        <td>
                                            <a href="<?php echo Router::url("admin/factures/detail/{$v->num}"); ?>">Visualiser &rarr;</a><span> | </span>
                                            <a  onclick="return confirm('Voulez vous vraiment supprimer cet facture');" href="<?php echo Router::url("admin/factures/delete_definitive/{$v->num}"); ?>">Supprimer definitivement</a>
                                        </td>
                                        </tr>
                            
                    <?php endforeach ?>
                </tbody>
            </table>
            </div>
            <div class="pagination">
                <ul>
                    <?php for ($i=1; $i <= $page ; $i++): ?>
                        <li <?php if($i==$this->request->page) echo 'class="active"';  ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>    
                </ul>
            </div>
    </div>
</div>