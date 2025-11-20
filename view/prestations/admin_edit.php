<div class="cote-a-cote" style="width: 99%;">
        <div class="table-boxes">
            <div class="box-topic"><h6>ajouter une prestation</h6></div>
            <form action="<?php echo Router::url('admin/prestations/edit/'.$id); ?>" method="post">
                <div class="input-box">
                    <?php echo $this->Form->input('id','hidden'); ?>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('intitule_prestat','Intitulé'); ?>
                </div>
                <label>Service</label>  
                <div class="select-box">
                    <select name="service_id" id="service_id" required="true">
                    <option></option>
                        <?php foreach($services as $k => $v): ?>
                            <option value=<?php echo $v->id; ?>>
                                <?php echo $v->intitule_serv; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('montant_prestat','Montant', array('type'=>'number')); ?>
                </div>
                <div class="actions">
                    <input type="submit" class="btn primary" value="envoyer">
                </div>
            </form>
        </div>
        <div class="container table-boxes" style="margin-left: 10px;">
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    

            <div class="cote-a-cote" style="width: 100%;">
                        <div class="cote-a-cote" style="width: 100%;">
                            <form action="" method="get">
                                <div class="search-box">
                                    <div class="cote-a-cote" style="width: 10%;">
                                        <div class="input-box" style="padding-left: 10%;">
                                        <label for="date"><h6>Service</h6></label>

                                        <select name="service_id" id="service_id" required="true">
                                            <?php foreach($services as $k => $v): ?>
                                                <option value=<?php echo $v->id; ?>>
                                                    <?php echo $v->intitule_serv; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                            </div> 
                                        <div class="form-patient-box" style="padding-top: 20px; padding-left: 10px" >
                                            <input type="submit" value=" Filtrer ">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  style="width: 200px;">
                            <form action="<?php echo Router::url('prestations/delfiltre'); ?>" method="get" >
                                <h6 style="padding-top: 10px">
                                <?php foreach($services as $k => $v): ?>
                                    <?php if (isset($filtre)): ?>
                                        <?php if ($v->id == $filtre): ?>
                                            <?php echo $v->intitule_serv; ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                    </h6>
                                    <div style="padding-top: 10px">
                                        <input type="submit" class="btn primary" value="effacer le filtre">
                                    </div>
                            </form>
                        </div>
                    </div>
        
            <div class="box-topic"><h6><?php echo $total_prestation; ?> Prestations enrégistrées</h6></div>

            <table class="table table-bordered">
                <thead style="background-color: #0d3073; color:white;">
                    <tr>
                        <th scope="col">Intitulé prestatio</th>
                        <th scope="col">Service</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach($prestations as $k => $v): ?>
                        <tr>
                            <td><?php echo $v->intitule_prestat; ?></td>
                            <td>
                                <ul class="details">
                                <?php foreach($services as $k => $w): ?>
                                        <?php if ($v->service_id == $w->id): ?>
                                            <?php echo $w->intitule_serv; ?>
                                        <?php endif ?>
                                <?php endforeach ?>
                                </ul>
                            </td>
                            <td><?php echo $v->montant_prestat; ?></td>
                            <td>
                                <a href="<?php echo Router::url('admin/prestations/edit/'.$v->id); ?>">Modifier</a><span> | </span>
                                <a  onclick="return confirm('Voulez vous vraiment supprimer cette prestation');" href="<?php echo Router::url('admin/prestations/delete/'.$v->id); ?>">Supprimer</a>

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
