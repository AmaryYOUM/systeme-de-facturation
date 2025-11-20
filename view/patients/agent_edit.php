<div class="cote-a-cote" style="width: 99%;">
    <div class="table-boxes">
        <div class="box-topic"><h6>ajouter un nouveau patient</h6></div>
        <br>            
        <form action="<?php echo Router::url('agent/patients/edit/'.$id); ?>" method="post">
            <div class="form-patient-box">
                <?php echo $this->Form->input('id','hidden'); ?>
            </div>
            <div class="form-patient-box">
                <?php echo $this->Form->input('prenom_patient','Prénom*'); ?>
            </div>
            <div class="form-patient-box ">
                <?php echo $this->Form->input('nom_patient','Nom*'); ?>
            </div>
            <div class="form-patient-box">
                <?php echo $this->Form->input('telephone_patient','Téléphone*'); ?>
            </div>
            <div class="form-patient-box">
                <?php echo $this->Form->input('contact_patient','Contact'); ?>
            </div>
            <div class="form-patient-box">
                    <?php echo $this->Form->input('matricule','Matricule'); ?>
                </div> 
                <div class="select-box">
                <label>Veuillez préciser le type du client</label>
                    <select name="type_client">
                        <option value="simple"></option>
                        <option value="Perso_ufr_sante">Personnel UDT</option>
                        <option value="etudiant">Etudiant</option>
                    </select>
                </div>
                <input type="submit" class="btn primary" value="Enrégistré patient"> 
        </form>
    </div>
    <div class="container table-boxes" style="margin-left: 10px;">
    <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
    <br>

        <div class="cote-a-cote" style="width: 100%;">
                        <div class="cote-a-cote" style="width: 100%;">
                            <form action="" method="get">
                                <div class="search-box">
                                    <div class="cote-a-cote" style="width: 10%;">
                                        <div class="input-box" style="padding-left: 10%;">
                                            <label for="date"><h6>Numéro téléphone</h6></label>
                                            <input  name="telephone_patient" type="text" placeholder="Numéro téléphone..." />
                                            </div> 
                                        <div class="form-patient-box" style="padding-top: 20px; padding-left: 10px" >
                                            <input type="submit" value=" Filtrer ">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  style="width: 100px;">
                            <form action="<?php echo Router::url('patients/delfiltre'); ?>" method="get" >
                                <h6 style="padding-top: 10px">
                                    <?php foreach($patients as $k => $v): ?>
                                            <?php if ($v->telephone_patient == $filtre): ?>
                                                <?php echo $v->prenom_patient." ".$v->nom_patient ; ?>
                                            <?php endif ?>
                                    <?php endforeach ?>
                                    </h6>
                                    <div style="padding-top: 10px">
                                        <input type="submit" class="btn primary" value="effacer le filtre">
                                    </div>
                            </form>
                        </div>
                    </div>

        <div class="box-topic"><h6><?php echo $total_patient; ?> Patient enrégistrées</h6></div>
        <br>
        <table class="table table-bordered">
            <thead style="background-color: #0d3073; color:white;">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Tel</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($patients as $k => $v): ?>
                    <tr>
                        <td><?php echo $v->id; ?></td>
                        <td><?php echo $v->prenom_patient; ?></td>
                        <td><?php echo $v->nom_patient; ?></td>
                        <td><?php echo $v->telephone_patient; ?></td>
                        <td><?php echo $v->contact_patient; ?></td>
                        <td>
                            <a href="<?php echo Router::url('agent/patients/edit/'.$v->id); ?>">Editer</a>
                        </td>
                    </tr>
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