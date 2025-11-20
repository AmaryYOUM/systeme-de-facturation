<div class="cote-a-cote" style="width: 99%;">
    <div class="table-boxes">
        <div class="box-topic"><h6>ajouter un nouveau prescripteur</h6></div>
        <br>            
        <form action="<?php echo Router::url('admin/prescripteurs/edit/'.$id); ?>" method="post">
            <div class="form-patient-box">
                <?php echo $this->Form->input('id','hidden'); ?>
            </div>
            <div class="form-patient-box">
                <?php echo $this->Form->input('prenom_prescripteur','Prénom*'); ?>
            </div>
            <div class="form-patient-box ">
                <?php echo $this->Form->input('nom_prescripteur','Nom*'); ?>
            </div>
            <div class="form-patient-box ">
                <?php echo $this->Form->input('specialite_prescripteur','Spécialité prescripteur'); ?>
            </div>
            <div class="form-patient-box ">
                <?php echo $this->Form->input('structure_prescripteur','Structure prescripteur'); ?>
            </div>
            
            <label for="service"><h6>Service</h6></label>

            <select name="service_prescripteur_id" id="service_prescripteur_id" required="true">
                <?php foreach($services as $k => $v): ?>
                    <option value=<?php echo $v->id; ?>>
                        <?php echo $v->intitule_serv; ?>
                    </option>
                <?php endforeach ?>
            </select>

            <div class="form-patient-box">
                <?php echo $this->Form->input('tel_prescripteur','Téléphone'); ?>
            </div>
            <div class="form-patient-box">
                <?php echo $this->Form->input('mail_prescripteur','E-mail'); ?>
            </div>
            
                <input type="submit" class="btn primary" value="Enrégistré prescripteur"> 
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
                                            <input  name="tel_prescripteur" type="text" placeholder="Numéro téléphone..." />
                                            </div> 
                                        <div class="form-patient-box" style="padding-top: 20px; padding-left: 10px" >
                                            <input type="submit" value=" Filtrer ">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  style="width: 100px;">
                            <form action="<?php echo Router::url('prescripteurs/delfiltre'); ?>" method="get" >
                                    <div style="padding-top: 10px">
                                        <input type="submit" class="btn primary" value="effacer le filtre">
                                    </div>
                            </form>
                            
                        </div>
                    </div>

        <div class="box-topic"><h6><?php echo $total_prescripteur; ?> Prescripteur enrégistrées</h6></div>
        <br>
        <table class="table table-bordered">
            <thead style="background-color: #0d3073; color:white;">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Tel</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Spécialité</th>
                    <th scope="col">Structure</th>
                    <th scope="col">Service</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($prescripteurs as $k => $v): ?>
                    <tr>
                        <td><?php echo $v->id; ?></td>
                        <td><?php echo $v->prenom_prescripteur; ?></td>
                        <td><?php echo $v->nom_prescripteur; ?></td>
                        <td><?php echo $v->tel_prescripteur; ?></td>
                        <td><?php echo $v->mail_prescripteur; ?></td>
                        <td><?php echo $v->specialite_prescripteur; ?></td>
                        <td><?php echo $v->structure_prescripteur; ?></td>
                        
                        <?php foreach($services as $k => $u): ?>
                            <?php if ($v->service_prescripteur_id == $u->id): ?>
                                <td><?php echo $u->intitule_serv; ?></td>
                            <?php endif ?>
                        <?php endforeach ?>

                        <td>
                            <a href="<?php echo Router::url('admin/prescripteurs/edit/'.$v->id); ?>">Editer</a><span> | </span>
                            <a  onclick="return confirm('Voulez vous vraiment supprimer ce prescripteur');" href="<?php echo Router::url('admin/prescripteurs/delete/'.$v->id); ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="pagination">
            <ul>
                <?php for ($i=1; $i <= $page ; $i++): ?>
                    <li <?php if($i==$this->request->page) echo 'class="active"';  ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>    
            </ul>
        </div>
        </div>
    </div>