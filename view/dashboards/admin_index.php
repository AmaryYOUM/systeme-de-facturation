<div class="home-content" style="padding-top: 0">
  <div class="overview-boxes">
    <div class="box">
      <div class="right-side">
        <div class="box-topic"><b>Factures</b></div>
        <div class="number" style="font-size:20px;"><?php echo $total_facture; ?></div>
      </div>
      <i class="fa-solid fa-hospital-user cart one"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic"><b>Services</b></div>
        <div class="number" style="font-size:20px;"><?php echo $total_service; ?></div>
      </div>
      <i class="fa-solid fa-house-medical cart two"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic"><b>Patients</b></div>
        <div class="number" style="font-size:20px;"><?php echo $total_patient; ?></div>
      </div>
      <i class="fa-solid fa-users cart three"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic"><b>Revenu</b></div>
        <div class="number" style="font-size:20px;"><?php echo number_format($sum_fact,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>
      </div>
      <i class="bx bxs-cart-download cart four"></i>
    </div>
  </div>
      <br>
    <div class="overview-boxes2">
        <div class="box2">
            <div class="right-side">
                <div class="box2-topic"><b>Service Ophtalmologie</b></div>
                <div class="number"><b>Factures : </b><?php echo $total_facture_opht; ?></div>
                <div class="number"><b>Montant : </b><?php echo number_format($sum_fact_opht,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>
            </div>
            <i class="fas fa-eye cart one" aria-hidden="true"></i>
        </div>
        <div class="box2">
            <div class="right-side">
                <div class="box2-topic"><b>Laboratoire d’anatomopathologie</b></div>
                <div class="number"><b>Factures : </b><?php echo $total_facture_anapath; ?></div>
                <div class="number"><b>Montant : </b><?php echo number_format($sum_fact_anapath,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>
            </div>
            <i class="fas fa-diagnoses cart two" aria-hidden="true"></i>

        </div>
        <div class="box2">
            <div class="right-side">
                <div class="box2-topic"><b>Laboratoire d’analyses biologiques</b></div>
                <div class="number"><b>Factures : </b><?php echo $total_facture_anabio; ?></div>
                <div class="number"><b>Montant : </b><?php echo number_format($sum_fact_anabio,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>

            </div>
            <i class="fas fa-flask cart three" aria-hidden="true"></i>
        </div>
    </div>

  <div class="sales-boxes">
    <div class="recent-sales box" style="width: 100%">
      <div class="title">Factures recentes</div>
      <br>
        <div class="sales-details" style="border: 1px solid; color:#0d3073 ; padding-right:20px">
          <ul class="details">
              <li class="topic"><b>N° facture</b></li>
                <?php foreach($factures as $k => $v): ?>
                  <li><a href="<?php echo Router::url("admin/factures/detail/$v->num"); ?>"><?php echo $v->num; ?></a></li>
                <?php endforeach ?>
            </ul>
            <ul class="details">
              <li class="topic"><b>Patient</b></li>
              <?php foreach($factures as $k => $v): ?>
                <?php foreach($patients as $k => $w): ?>
                  <?php if ($v->patient_id == $w->id): ?>
                    <li><a href="<?php echo Router::url("admin/factures/detail/$v->num"); ?>"><?php echo "$w->prenom_patient $w->nom_patient"; ?></a></li>
                  <?php endif ?>
                <?php endforeach ?> 
              <?php endforeach ?>               
            </ul>
            <ul class="details">
              <li class="topic"><b>Prestations</b></li>
              <?php foreach($factures as $k => $v): ?>
                <?php foreach($prestations as $k => $w): ?>
                  <?php if ($v->prestation_id == $w->id): ?>
                    <li><a href="<?php echo Router::url("admin/factures/detail/$v->num"); ?>"><?php echo $w->intitule_prestat; ?></a></li>
                  <?php endif ?>
                <?php endforeach ?> 
              <?php endforeach ?>               
            </ul>
            <ul class="details">
              <li class="topic"><b>Montant</b></li>
              <?php foreach($factures as $k => $v): ?>
                <li><a href="<?php echo Router::url("admin/factures/detail/$v->num"); ?>"><?php echo number_format($v->montant_global,0,',',' ').' Fcfa'; ?></a></li>
              <?php endforeach ?> 
            </ul>
        </div>
      <br>
      <div class="button">
        <a href="<?php echo Router::url('admin/factures/edit') ?>">Voir Tout</a>
      </div>
      <br>
      
      <div class="title">Facture à supprimer</div>
      <br>
      <div class="sales-details" style="border: 1px solid; color:#0d3073">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background-color: #0a2558; color:white;">
                    <tr>
                        <th scope="col">Numéro facture</th>
                        <th scope="col">Date facturation</th>
                        <th scope="col">Agent</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Prestation</th>
                        <th scope="col">Net à payer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach($fact_sup as $k => $v): ?>
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
                                        <td><?php echo $w->intitule_prestat." <b>...<b>"; ?></td>
                                    <?php endif ?>
                                <?php endforeach ?>

                                <td><?php echo number_format($v->montant_global,0,',',' ')." Fcfa"; ?></td>
    
                                <td>
                                    <a href="<?php echo Router::url("admin/factures/detail/{$v->num}"); ?>">Visualiser &rarr;</a><span> | </span>
                                    <a  onclick="return confirm('Voulez vous vraiment supprimer cet facture');" href="<?php echo Router::url("admin/factures/delete/{$v->num}"); ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        
        <br>
        <div class="title">Corbeille</div>
      <br>
      <div class="sales-details" style="border: 1px solid; color:#0d3073">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background-color: #0a2558; color:white;">
                    <tr>
                        <th scope="col">Numéro facture</th>
                        <th scope="col">Date facturation</th>
                        <th scope="col">Agent</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Prestation</th>
                        <th scope="col">Net à payer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach($factures_corb as $k => $v): ?>
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
                                        // Affiche la date au format jj/mm/aaaa si la conversion a réussi
                                        if ($date) {
                                            echo $date->format('d/m/Y');
                                        } else {
                                            echo "Date invalide"; // Gérer les dates invalides
                                        }
                                        ?>
                                    </td>
                                        
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
                                                <td><?php echo $w->intitule_prestat." <b>...<b>"; ?></td>
                                            <?php endif ?>
                                        <?php endforeach ?>
        
                                        <td><?php echo number_format($v->montant_global,0,',',' ')." Fcfa"; ?></td>
            
                                        <td>
                                            <a href="<?php echo Router::url("admin/factures/detail/{$v->num}"); ?>">Visualiser &rarr;</a><span> | </span>
                                            <a  onclick="return confirm('Voulez vous vraiment supprimer cet facture');" href="<?php echo Router::url("admin/factures/delete_definitive/{$v->num}"); ?>">Supprimer definitivement</a>
                                        </td>
                                    </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
              <br>
              <div class="button">
                <a href="<?php echo Router::url('admin/factures/corbeille') ?>">Voir corbeille</a>
              </div>
        
    </div>
    <div class="top-sales box">
      <div class="table-boxes">
        <div style="padding-left: 20px; font-size:12px"><h3>Nos Services</h3></div>
        <ul><?php $servicesmenu = $this->request('Dashboards','getMenu'); ?>
          <?php foreach($servicesmenu as $s): ?>
          <li>
            <a  style="color:#0d3073" href="<?php echo Router::url('admin/services/view/'.$s->id) ?>" 
              title="<?php echo $s->intitule_serv; ?>">
                  <?php echo $s->intitule_serv; ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <br>

      <div class="table-boxes">
      <div style="padding-left: 20px; font-size:12px"><h3>Nos Agents</h3></div>
            <ul>
              <?php foreach($users as $k => $v): ?>
              <li >
                <a href="#" >
                  <span style="color:#0d3073">
                      <?php echo $v->prenom_user; ?> <?php echo $v->nom_user; ?>
                  </span>
                </a>
                <span class="label <?php echo ($v->online==1)?'success':'error'; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span>
              </li>
              <?php endforeach ?>
            </ul>
        </div>
  </div>
  </div>
</div>

