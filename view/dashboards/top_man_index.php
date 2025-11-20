<div class="home-content" style="padding-top: 0">
    <div class="overview-boxes">
        <div class="box">
            <div class="right-side">
                <div class="box-topic"><b>Factures</b></div>
                <div class="number"><?php echo $total_facture; ?></div>
            </div>
            <i class="fa-solid fa-hospital-user cart one"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic"><b>Services</b></div>
                <div class="number"><?php echo $total_service; ?></div>
            </div>
            <i class="fa-solid fa-house-medical cart two"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic"><b>Patients</b></div>
                <div class="number"><?php echo $total_patient; ?></div>
            </div>
            <i class="fa-solid fa-users cart three"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic"><b>Revenu</b></div>
                <div class="number" style="font-size:25px;"><?php echo number_format($sum_fact,0,',',' '); ?> <span style="font-size:15px;">Fcfa</span></div>
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
    
                        <br>
                
                    <div class="recent-sales box" style="width: 100%; background-color: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
                    <br>
                    <div class="container-fluid">
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
                        <div class="title"><h6>Donnees mensuelles - Année <?php echo $annee; ?></h6></div>

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
            </div>
        </div>
                   
    <br>
    
</div>


