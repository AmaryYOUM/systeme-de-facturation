<div class="home-content" style="padding-top: 0">
  <div class="overview-boxes">
  <div class="box">
      <div class="right-side">
        <div class="box-topic">Patients</div>
        <div class="number"><?php echo $total_patient; ?></div>
      </div>
      <i class="bx bxs-cart-add cart two"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Patients</div>
        <div class="number"><?php echo $total_patient; ?></div>
      </div>
      <i class="bx bxs-cart-add cart two"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Factures</div>
        <div class="number"><?php echo $total_facture; ?></div>
      </div>
      <i class="bx bx-cart cart three"></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Revenu</div>
        <div class="number"><?php echo number_format($sum_fact,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>
      </div>
      <i class="bx bxs-cart-download cart four"></i>
    </div>
  </div>

  <div class="sales-boxes">
    <div class="recent-sales box" style="width: 100%">
      <div class="title">Factures recentes</div>
      <br>
      <div class="sales-details" style="border: 1px solid; color:#0d3073;padding-right:20px">
      <ul class="details">
          <li class="topic"><b>N° facture</b></li>
            <?php foreach($factures as $k => $v): ?>
              <li><a href="<?php echo Router::url("chef_service/factures/detail/$v->num"); ?>"><?php echo $v->num; ?></a></li>
            <?php endforeach ?>
        </ul>
        <ul class="details">
          <li class="topic"><b>Patient</b></li>
          <?php foreach($factures as $k => $v): ?>
            <?php foreach($patients as $k => $w): ?>
              <?php if ($v->patient_id == $w->id): ?>
                <li><a href="<?php echo Router::url("chef_service/factures/detail/$v->num"); ?>"><?php echo "$w->prenom_patient $w->nom_patient"; ?></a></li>
              <?php endif ?>
            <?php endforeach ?> 
          <?php endforeach ?>               
        </ul>
        <ul class="details">
          <li class="topic"><b>Prestations</b></li>
          <?php foreach($factures as $k => $v): ?>
            <?php foreach($prestations as $k => $w): ?>
              <?php if ($v->prestation_id == $w->id): ?>
                <li><a href="<?php echo Router::url("chef_service/factures/detail/$v->num"); ?>"><?php echo $w->intitule_prestat; ?></a></li>
              <?php endif ?>
            <?php endforeach ?> 
          <?php endforeach ?>               
        </ul>
        <ul class="details">
          <li class="topic"><b>Montant</b></li>
          <?php foreach($factures as $k => $v): ?>
            <li><a href="<?php echo Router::url("chef_service/factures/detail/$v->num"); ?>"><?php echo number_format($v->montant_global,0,',',' ').' Fcfa'; ?></a></li>
          <?php endforeach ?> 
        </ul>
      </div>
      <br>
      <div class="button">
        <a href="<?php echo Router::url('chef_service/factures/edit') ?>">Voir Tout</a>
      </div>
    </div>
    <div class="top-sales box">
      <div class="table-boxes">
        <div style="padding-left: 20px"><h3>Nos Services</h3></div>
        <ul><?php $servicesmenu = $this->request('Dashboards','getMenu'); ?>
          <?php foreach($servicesmenu as $s): ?>
              <li>
                <a style="color:#0d3073" href="
                  <?php foreach($users as $k => $v): ?>
                    <?php if ($v->service_id == $s->id): ?>
                      <?php echo Router::url('chef_service/services/view/'.$s->id) ?>
                    <?php endif; ?>
                  <?php endforeach; ?>" title="<?php echo $s->intitule_serv; ?>">
                    <?php echo $s->intitule_serv; ?>
                </a>
              </li>
          <?php endforeach; ?>
        </ul>
      </div>

  </div>
  
</div>

