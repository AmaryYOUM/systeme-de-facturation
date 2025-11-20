<div class="home-content"  style="padding-top : 0">
    
    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title"><h6><?php echo $service->intitule_serv; ?></h6></div>
            <br>
            <table class="table table-bordered">
                <thead style="background-color: #0d3073; color:white;">
                    <tr>
                        <th>
                            <ul class="details">
                                <li>Prestation</li>
                            </ul>
                        </th>   
                        <th>
                            <ul class="details">
                                <li>Montant</li>
                            </ul>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td>
                            <ul class="details">
                            <?php foreach($services as $k => $v): ?>
                                <?php foreach($prestations as $k => $w): ?>
                                    <?php if ($v->id == $w->service_id): ?>
                                        <li style="font-size:10px"><?php echo $w->intitule_prestat; ?></li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            </ul>
                        </td>
                        <td>
                            <ul class="details">
                            <?php foreach($services as $k => $v): ?>
                                <?php foreach($prestations as $k => $w): ?>
                                    <?php if ($v->id == $w->service_id): ?>
                                        <li style="font-size:10px"><?php echo $w->montant_prestat; ?></li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        <div class="recent-sales box" style="width: 90%">
            <div class="cote-a-cote" >
                <div class="box1">
                <div class="box" style="width: 250px; height: 100px; border-radius: 5px; border: 1px solid #ccc;">
                <div class="box-topic" style="margin: 10px; font-size:25px"><h6>Facture</h6></div>
                    <div class="cote-a-cote" style="margin: 10px;">
                        <div class="right-side">
                            <div class="number" style="font-size:25px;"><td><?php echo $total_facture; ?></td></div>
                        </div>
                        <div class="right-side" style="padding-top: 17px;"><i class="fa-solid fa-hospital-user cart one"></i></div>
                    </div>
                </div>
                    <br>
                <div class="box" style="width: 250px; height: 100px; border-radius: 5px; border: 1px solid #ccc;">
                <div class="box-topic" style="margin: 10px; font-size:25px"><h6>Prestation</h6></div>
                    <div class="cote-a-cote" style="margin: 10px;">
                        <div class="right-side">
                            <div class="number" style="font-size:25px;"><td><?php echo $total_prestation; ?></td></div>
                        </div>
                        <div class="right-side" style="padding-top: 17px;"><i class="bx bx-box cart two"></i></div>
                    </div>
                </div>
                </div>
                    <div class="box" style="width: 250px; height: 100px; border-radius: 5px; border: 1px solid #ccc;">
                        <div class="box-topic" style="margin: 10px; font-size:25px"><h6>Montant</h6></div>
                            <div class="cote-a-cote" style="margin: 10px;">
                                <div class="right-side">
                                    <div class="number" style="font-size:20px;"><td><?php echo number_format($sum_fact,0,',',' ')." Fcfa"; ?></td></div>
                                </div>
                                <div class="right-side" style="padding-top: 17px;"><i class="bx bxs-cart-add cart four"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
    <br>
            <div class="recent-sales box" style="width: 100%; background-color: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">

                    <div class="container-fluid" style="margin-left: 10px;">
                    <br>
                        <form method="GET" style="margin-bottom: 10px;">
                            <label for="annee">Sélectionnez l'année :</label>
                            <select name="annee" id="annee" onchange="this.form.submit()">
                                <?php 
                                $annee_actuelle = date('Y');
                                for ($y = $annee_actuelle; $y >= $annee_actuelle - 5; $y--) { ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($y == $annee) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </form>
                        <div class="title"><h6>Donnees mensuelles du service - Année <?php echo $annee; ?></h6></div>

                    <br>
                    <table class="table table-bordered" style="font-size: 12px;">
                        <thead style="background-color: #0a2558; color:white;">
                            <tr>
                                <th></th>
                                <th scope="col">Janvier</th>
                                <th scope="col">Fevrier</th>
                                <th scope="col">Mars</th>
                                <th scope="col">Avril</th>
                                <th scope="col">Mai</th>
                                <th scope="col">Juin</th>
                                <th scope="col">Juillet</th>
                                <th scope="col">Aout</th>
                                <th scope="col">Septembre</th>
                                <th scope="col">Octobre</th>
                                <th scope="col">Novembre</th>
                                <th scope="col">Décembre</th>
                            </tr>
                    </thead>
  <tbody id="tbody">
        <tr>
            <td>Nombre factures</td>
            <?php for($m=1; $m<=12; $m++): ?>
                <td><?php echo isset($factures_par_mois[$m]) ? $factures_par_mois[$m] : 0; ?></td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td>Montant total</td>
            <?php for($m=1; $m<=12; $m++): ?>
                <td><?php echo isset($montants_par_mois[$m]) ? number_format($montants_par_mois[$m], 0, ',', ' ') : 0; ?> CFA</td>
            <?php endfor; ?>
        </tr>
    </tbody>
                    </table>
                </div>
            </div>
            
    <br>
    <div class="recent-sales box" style="width: 100%; background-color: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid" style="margin-left: 10px;">
            <br>
                <div class="title"><h6>liste dans factures du service</h6></div>    
            <br>
            <table class="table table-bordered" style="font-size: 10px; list-style: none">
                <thead style="background-color: #0a2558; color:white;">
                    <tr>
                        <th scope="col">N° facture</th>
                        <th scope="col">Date création</th>
                        <th scope="col">Agent</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Service</th>
                        <th scope="col">Prestation</th>
                        <th scope="col">Montant global</th>
                    </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($factures as $k => $u): ?>
                    <?php foreach($services as $k => $w): ?>
                        <?php if ($w->id == $u->service_id): ?>
                    <tr>
                        <?php foreach($prestations as $k => $v): ?>
                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <td><?php echo $u->num; ?></td>
                                    <?php endif ?>
                        <?php endforeach ?>
                    
                        <?php foreach($prestations as $k => $v): ?>
                            <?php if ($v->id == $u->prestation_id): ?>
                                <td><?php echo $u->date_creation; ?></td>
                            <?php endif ?>
                        <?php endforeach ?>
                        
                        
                        <?php foreach($prestations as $k => $v): ?>

                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <?php foreach($users as $k => $x): ?>
                                            <?php if ($u->user_id == $x->id): ?>
                                                <td><?php echo $x->login; ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>

                        <?php endforeach ?>
                    
                        <?php foreach($prestations as $k => $v): ?>

                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <?php foreach($patients as $k => $x): ?>
                                            <?php if ($u->patient_id == $x->id): ?>
                                                <td><?php echo "$x->prenom_patient $x->nom_patient"; ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>

                        <?php endforeach ?>
                    
                        <?php foreach($prestations as $k => $v): ?>

                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <td><?php echo $w->intitule_serv; ?></td>
                                    <?php endif ?>

                        <?php endforeach ?>

                        <?php foreach($prestations as $k => $v): ?>

                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <td><?php echo $v->intitule_prestat." <b>...<b>"; ?></td>
                                    <?php endif ?>

                        <?php endforeach ?>

                        <?php foreach($prestations as $k => $v): ?>

                                    <?php if ($v->id == $u->prestation_id): ?>
                                        <td><?php echo $u->montant_global; ?></td>
                                    <?php endif ?>

                        <?php endforeach ?>
                    
                    </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tbody>
            </table>
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