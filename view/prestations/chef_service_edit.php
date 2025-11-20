<div class="cote-a-cote" style="width: 99%;">
        <div class="table-boxes">
            <div class="box-topic"><h6>ajouter une prestation</h6></div>
            <form action="<?php echo Router::url('chef_service/prestations/edit/'.$id); ?>" method="post">
                <div class="input-box">
                    <?php echo $this->Form->input('id','hidden'); ?>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('intitule_prestat','Intitulé'); ?>
                </div>
                <div class="input-box">
                    <input style="height: 25px;" name="service_id" type="hidden" value = <?php echo $this->Session->user('service_id') ; ?>>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('montant_prestat','Montant', array('type'=>'number')); ?>
                </div>
                <div class="actions">
                    <input type="submit" class="btn primary" value="Enregistrer">
                </div>
            </form>
        </div>

        <div class="container table-boxes" style="margin-left: 10px;">
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
                <h6><?php echo "$total_prestation Prestations enrégistrées"; ?></h6>
            <br>
            <table class="table table-bordered">
                <thead style="background-color: #0d3073; color:white;">
                    <tr>
                        <th scope="col">Intitulé prestation</th>
                        <th scope="col">Service</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach($prestations as $k => $v): ?>
                        <?php if ($v->service_id == $this->Session->user('service_id')): ?>
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
                                <a href="<?php echo Router::url('chef_service/prestations/edit/'.$v->id); ?>">Modifier</a><span> | </span>
                                <a  onclick="return confirm('Voulez vous vraiment supprimer cette prestation');" href="<?php echo Router::url('chef_service/prestations/delete/'.$v->id); ?>">Supprimer</a>
                            </td>
                        </tr>
                        <?php endif ?>
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
