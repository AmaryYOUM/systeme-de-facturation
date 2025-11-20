<div class="bloc-content">
    <div class="patient-box">
        <div style="padding: 10px"><h4>NOUVEAU PATIENT</h4></div>
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
        <br>            
            <form action="<?php echo Router::url('admin/patients/edit/'.$id); ?>" method="post">
            <div class="cote-a-cote" style="width: 10%; ">
                <div class="form-patient-box " style="padding-left: 40px;">
                    <?php echo $this->Form->input('matricule','Matricule',array(),'label-color'); ?>
                </div> 
                <div class="select-box" style="padding-left: 30px;">
                <label style="color: white;">Veuillez préciser le type du client</label>
                    <select name="type_client">
                        <option value="simple"></option>
                        <option value="Personnel_udt">Personnel UDT</option>
                        <option value="etudiant">Etudiant</option>
                    </select>
                </div>
            </div>
            <div class="cote-a-cote" style="width: 100%; ">
                    <div class="form-patient-box">
                        <?php echo $this->Form->input('id','hidden'); ?>
                    </div>
                    <div class="form-patient-box">
                        <?php echo $this->Form->input('prenom_patient','Prénom',array(),'label-color'); ?>
                    </div>
                    <div class="form-patient-box ">
                        <?php echo $this->Form->input('nom_patient','Nom',array(),'label-color'); ?>
                    </div>
                    <div class="form-patient-box">
                        <?php echo $this->Form->input('telephone_patient','Téléphone',array(),'label-color'); ?>
                    </div>
                    <div class="form-patient-box">
                        <?php echo $this->Form->input('contact_patient','Contact',array(),'label-color'); ?>
                    </div>
                    <div class="form-patient-box" style="padding-top: 20px; padding-right: 10px" >
                        <input type="submit" value="Enrégistré patient">
                    </div>
                </div>
            </form>
    </div>
    <br>

    <div class="cote-a-cote" style="width: 99%;">
        <div class="table-boxes">
            <form action="" method="get">
                <h6 style="padding: 10px">Veuillez choisir un Service</h6>
                <div class="select-box">
                    <select id="service_id" name="service_id">
                        <?php foreach($services as $k => $v): ?>
                                <option value="<?php echo $v->id; ?>"><?php echo $v->intitule_serv; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <input type="submit" class="btn primary" value="valider">
            </form>
            <div class="box-topic"><h6>Editer une facture</h6></div>
            <form action="<?php echo Router::url('admin/factures/edit/'.$id); ?>" method="post">
                <div class="input-box">
                    <?php echo $this->Form->input('id','hidden'); ?>
                </div> 
                <br>
                <label>Numéro facture</label>
                <div class="input-box">
                    <input style="height: 25px;" type="text" name="num" value = <?php echo "Fact-N°".$num_facture ; ?> readonly>
                </div>
                <label>Prescripteur*</label>
                <div class="select-box">
                    <select id="prescripteur_id" style="height: 25px;" name="prescripteur_id" required="true">
                        <option value="">Sélectionnez un prescripteur</option>
                        <?php foreach($prescripteurs as $k => $v): ?>
                            <option type_client="<?php echo $v->type_client; ?>" value="<?php echo $v->id; ?>">
                                <?php echo "$v->prenom_prescripteur $v->nom_prescripteur ($v->tel_prescripteur)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-box">
                <input style="height: 25px;" name="date_creation" type="hidden" value="<?php date_default_timezone_set('Africa/Dakar'); echo date('Y-m-d'); ?>">
                </div>
                <div class="input-box">
                    <input style="height: 25px;" type="hidden" name="user_id" value = <?php echo $agent_id ?>>
                </div>
                <br>
                <label>Patient*</label>
                <div class="select-box">
                    <select id="patient_id" style="height: 25px;" name="patient_id" required="true">
                        <option value="">Sélectionnez un patient</option>
                        <?php foreach($patients as $k => $v): ?>
                            <option type_client="<?php echo $v->type_client; ?>" value="<?php echo $v->id; ?>">
                                <?php echo "$v->prenom_patient $v->nom_patient ($v->telephone_patient)"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Conteneur pour afficher le type de client -->
                <div id="type-client-info" style="margin-top: 10px; margin-bottom: 10px; font-weight: bold;"></div>
                <br>
                    <label>Prestation*</label>
                    <div class="form-group">
                        <select name="prestation_id[]" id="prestation_id" class="form-control" required="true" multiple="multiple">
                            <?php foreach($prestations as $k => $v): ?>
                                <?php if (isset($serv)): ?>
                                    <?php if ($v->service_id == $serv): ?>
                                        <option montant="<?php echo $v->montant_prestat; ?>" value="<?php echo $v->id; ?>">
                                            <?php echo $v->intitule_prestat; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group"  style="display: none;">
                        <select name="montant[]" id="montant" class="form-control" required="true" multiple="multiple">
                            <?php foreach($prestations as $k => $v): ?>
                                <?php if (isset($serv)): ?>
                                    <?php if ($v->service_id == $serv): ?>
                                        <option montant="<?php echo $v->id; ?>" value="<?php echo $v->montant_prestat; ?>">
                                            <?php echo $v->intitule_prestat; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Réduction</label>
                        <select name="reduction" id="reduction"> 
                            <option value="">Aucune réduction</option>
                            <option value="0.1">10%</option>
                            <option value="0.2">20%</option>
                            <option value="0.3">30%</option>
                            <option value="0.4">40%</option>
                            <option value="0.5">50%</option>
                            <option value="0.6">60%</option>
                            <option value="0.7">70%</option>
                            <option value="0.8">80%</option>
                            <option value="0.9">90%</option>
                            <option value="100">100%</option>
                            <option value="101">projet</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <?php if (isset($serv)): ?>
                                <input style="height: 25px;" type="hidden" name="service_id" value = <?php echo $serv ; ?>  >
                        <?php endif ?>
                    </div>
                    <br>

                    <div class="select-box">
                    <label>Net à payer</label>
                        <input style="height: 25px;" id="montant_global" type="number" name="montant_global" readonly>
                    </div>
                    <br>

                    <div class="select-box">
                    <label>Prise en charge</label>
                        <input style="height: 25px;" id="pec" type="number" name="pec" readonly>
                    </div>
                    <br>

                <div class="actions">
                    <input type="submit" class="btn primary" value="Sauvegarder">
                </div>
            </form>
        </div>
        <div class="container-fluid content-boxes" style="margin-left: 10px;">
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
                    <div class="cote-a-cote" style="width: 100%;">
                        <div class="cote-a-cote" style="width: 100%;">
                            <form action="" method="get">
                                <div class="search-box">
                                <h6 style="padding: 10px" >Filtrer par date :</h6>
                                    <div class="cote-a-cote" style="width: 10%;">
                                        <div class="input-box">
                                            <label for="date"><h6>Date Début</h6></label>
                                            <input type = "date" name="debut" >
                                        </div>
                                        <div class="input-box" style="padding-left: 10%;">
                                            <label for="date"><h6>Date fin</h6></label>
                                            <input type = "date" name="fin" >
                                        </div> 
                                        <div class="form-patient-box" style="padding-top: 20px; padding-left: 10px" >
                                            <input type="submit" value=" Filtrer ">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  style="width: 100px;">
                            <form action="<?php echo Router::url('factures/delfiltre'); ?>" method="get" >
                                <h6 style="padding-top: 10px">
                                    <?php if (isset($debut) && isset($fin)): ?>
                                        <?php
                                            // Suppose que $debut est dans le format 'Y-m-d' ou 'Y-m-d H:i:s'
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $debut);
                                            // Si la date ne contient pas de temps (juste 'Y-m-d')
                                            if (!$date) {
                                                $date = DateTime::createFromFormat('Y-m-d', $debut);
                                            }
                                            // Affiche la date au format jj/mm/aaaa si la conversion a réussi
                                            if ($date) {
                                                echo "DU ".$date->format('d/m/Y')." AU ";
                                            } else {
                                                echo ""; // Gérer les dates invalides
                                            }
                                            
                                            // Suppose que $v->date_creation est dans le format 'Y-m-d' ou 'Y-m-d H:i:s'
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $fin);
                                            // Si la date ne contient pas de temps (juste 'Y-m-d')
                                            if (!$date) {
                                                $date = DateTime::createFromFormat('Y-m-d', $fin);
                                            }
                                            // Affiche la date au format jj/mm/aaaa si la conversion a réussi
                                            if ($date) {
                                                echo $date->format('d/m/Y');
                                            } else {
                                                echo ""; // Gérer les dates invalides
                                            }
                                        ?>
                                    <?php endif ?>
                                    </h6>
                                    <div style="padding-top: 10px">
                                        <input type="submit" class="btn primary" value="effacer le filtre">
                                    </div>
                            </form>
                        </div>
                    </div>

                    <div class="cote-a-cote">
                        <h6 style="padding: 10px"><?php echo $total_facture ; ?> Factures enrégistrées</h6>
                        <div>
                        <a href="<?php echo Router::url('factures/export?debut=' . (isset($_GET['debut']) ? $_GET['debut'] : '') . '&fin=' . (isset($_GET['fin']) ? $_GET['fin'] : '')); ?>" class="btn" style="background: #0a2558; color: white;"><i class="fa-solid fa-file-arrow-down"></i> Exporter</a>
                        </div>
                    </div>
                    
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
                                    <th scope="col">Net à payer</th>
                                    <th scope="col">Prise en charge</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php foreach($factures as $k => $v): ?>

                                        <tr <?php if($v->modifier == 1) echo 'style="background-color: #ffe6e6;"'; ?>>

                                            <td><?php echo $v->num; ?></td>
                                            <td>
                                                <?php
                                                // Suppose que $v->date_creation est dans le format 'Y-m-d' ou 'Y-m-d H:i:s'
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->date_creation);
                                                // Si la date ne contient pas de temps (juste 'Y-m-d')
                                                if (!$date) {
                                                    $date = DateTime::createFromFormat('Y-m-d', $v->date_creation);
                                                }
                                                // Affiche la date au format jj/mm/aaaa si la conversion a réussi
                                                if ($date) {
                                                    echo $date->format('d/m/Y');
                                                } else {
                                                    echo "Date invalide"; // Gérer les dates invalides
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
                                                    <a  onclick="return confirm('Voulez vous vraiment supprimer cet facture');" href="<?php echo Router::url("admin/factures/delete/{$v->num}"); ?>">Supprimer</a>
                                                </td>
                                            </tr>

                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                    <div class="pagination">
                        <ul>
                            <?php
                            $currentPage = $this->request->page;
                            $totalPages = $page;
                            $maxPagesToShow = 10;
                    
                            // Flèche gauche
                            if ($currentPage > 1) {
                                echo '<li><a href="?page=' . ($currentPage - 1) . '">&laquo;</a></li>';
                            }
                    
                            if ($totalPages <= $maxPagesToShow) {
                                // Affichage normal si le total <= 10
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li' . ($i == $currentPage ? ' class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                            } else {
                                $start = max(1, $currentPage - 4);
                                $end = min($totalPages, $currentPage + 4);
                    
                                // Affiche le 1er lien
                                if ($start > 1) {
                                    echo '<li><a href="?page=1">1</a></li>';
                                    if ($start > 2) {
                                        echo '<li class="dots"><a href="javascript:void(0)">...</a></li>';
                                    }
                                }
                    
                                for ($i = $start; $i <= $end; $i++) {
                                    echo '<li' . ($i == $currentPage ? ' class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                    
                                // Affiche dernier lien
                                if ($end < $totalPages) {
                                    if ($end < $totalPages - 1) {
                                        echo '<li class="dots"><a href="javascript:void(0)">...</a></li>';
                                    }
                                    echo '<li><a href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                }
                            }
                    
                            // Flèche droite
                            if ($currentPage < $totalPages) {
                                echo '<li><a href="?page=' . ($currentPage + 1) . '">&raquo;</a></li>';
                            }
                            ?>
                        </ul>
                    </div>

            </div>
        </div>
    </div>
</div>

<script src=<?php echo Router::url('js/app.js'); ?>></script>

