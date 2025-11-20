<div class="cote-a-cote" style="width: 99%;">
    <div class="table-boxes">
        <div class="box-topic"><h6>ajouter un nouveau agent</h6></div>
        <br>            
        <form action="<?php echo Router::url('admin/users/edit/'.$id); ?>" method="post">
            <div class="input-box">
                <?php echo $this->Form->input('id','hidden'); ?>
            </div>
            <div class="input-box">
                <input type = "hidden" name="maj_mdp" value = "0" ; ?>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('prenom_user','Prénom'); ?>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('nom_user','Nom'); ?>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('login','Identifiant'); ?>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('password','mot de passe',array('type'=>'password')); ?>
            </div>
            <div class="select-box">
                <select name="profil" required="true">
                    <option value="user">Agent</option>
                    <option value="directeur">Directeur</option>
                    <option value="admin">Administrateur</option>
                    <option value="chef_service">Chef de service</option>
                </select>
            </div> 
            <div class="select-box">
                <label>Veuillez choisir le service</label>
                <select id="service_id" name="service_id">
                <option value=""></option>
                    <?php foreach($services as $k => $v): ?>
                        <option value="<?php echo $v->id; ?>"><?php echo $v->intitule_serv; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('tel_user','Tel'); ?>
            </div>
            <div class="input-box">
                <?php echo $this->Form->input('email','E-mail'); ?>
            </div>
            <div class="actions">
                <input type="submit" class="btn primary" value="envoyer">
            </div>
        </form>
    </div>
    <div class="container table-boxes" style="flex: 1; min-width: 300px; overflow-x: auto;">
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
        <br>
        <div class="cote-a-cote" style="width: 100%;">
            <div class="cote-a-cote" style="width: 100%;">
                <form action="" method="get">
                    <div class="search-box">
                        <div class="cote-a-cote" style="width: 10%;">
                            <div class="input-box" style="padding-left: 10%;">
                                <label for="date"><h6>Numéro téléphone</h6></label>
                                <select name="profil">
                                        <?php foreach($users_filtre as $k => $v): ?>
                                            <option value="<?php echo $v->profil ; ?>"><?php echo $v->profil ; ?></option>
                                        <?php endforeach ?>
                                </select>                                            </div> 
                            <div class="form-patient-box" style="padding-top: 20px; padding-left: 10px" >
                                <input type="submit" value=" Filtrer ">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div  style="width: 100px;">
                <form action="<?php echo Router::url('users/delfiltre'); ?>" method="get" >
                    <h6 style="padding-top: 10px">
                    <?php foreach($users_filtre as $k => $v): ?>
                            <?php if ($v->profil == $filtre): ?>
                                <?php echo $v->profil ; ?>
                            <?php endif ?>
                    <?php endforeach ?>
                        </h6>
                        <div style="padding-top: 10px">
                            <input type="submit" class="btn primary" value="effacer le filtre">
                        </div>
                </form>
            </div>
        </div>


        <div class="box-topic"><h6><?php echo $total_user; ?> Agent enrégistrées</h6></div>
        <br>
        <table class="table table-bordered" style="width: 100%; table-layout: auto;">
            <thead style="background-color: #0d3073; color:white;">
                <tr>
                    <th scope="col">Maj mot de passe</th>
                    <th scope="col">En ligne</th>
                    <th scope="col">Profil</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Tel</th>
                    <th scope="col">email</th>
                    <th scope="col">Déconnexion</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($users as $k => $v): ?>
                    <tr>
                        <td><span class="label <?php echo ($v->maj_mdp==1)?'success':'error'; ?>"><?php echo ($v->maj_mdp==1)?'Mdp oublié':''; ?></span>
                        </td>
                        <td><span class="label <?php echo ($v->online==1)?'success':'error'; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span></td>
                        <td><?php echo $v->profil; ?></td>
                        <td><?php echo $v->prenom_user; ?></td>
                        <td><?php echo $v->nom_user; ?></td>
                        <td><?php echo $v->tel_user; ?></td>
                        <td><?php echo $v->email; ?></td>
                       <td>
                            <?php
                                // Vérifie si 'last_logout' n'est pas vide et n'est pas la valeur par défaut '0000-00-00 00:00:00'
                                if (!empty($v->last_logout) && $v->last_logout != '0000-00-00 00:00:00') {
                                    // Essaye de créer un objet DateTime à partir de 'last_logout'
                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $v->last_logout);
                                    
                                    // Si la date ne correspond pas au format, essaie un autre format
                                    if (!$date) {
                                        $date = DateTime::createFromFormat('Y-m-d', $v->last_logout);
                                    }
                                    
                                    // Si la conversion a réussi, affiche la date au format jj/mm/aaaa hh:mm:ss
                                    if ($date) {
                                        echo $date->format('d/m/Y H:i:s');
                                    } else {
                                        echo "Date invalide"; // Gérer les dates invalides
                                    }
                                } else {
                                    // Si la date est '0000-00-00 00:00:00', ou vide, ne rien afficher
                                    echo "";
                                }
                            ?>
                        </td>


                        <td>
                            <a href="<?php echo Router::url('admin/users/edit/'.$v->id); ?>">Editer</a><span> | </span>
                            <a  onclick="return confirm('Voulez vous vraiment supprimer cet agent');" href="<?php echo Router::url('admin/users/delete/'.$v->id); ?>">Supprimer</a>
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
