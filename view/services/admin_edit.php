<div class="bloc-content">

    <div class="cote-a-cote" style="width: 99%;">
        <div class="table-boxes" style="background-color: #0a2558;">
            <div ><h3 style="color: white;">Ajouter un nouveau service</h3></div>
            <form action="<?php echo Router::url('admin/services/edit/'.$id); ?>" method="post">
                <div class="input-box">
                    <?php echo $this->Form->input('id','hidden'); ?>
                </div>
                <div class="input-box">
                    <?php echo $this->Form->input('intitule_serv','Intitulé du service',array(),'label-color'); ?>
                </div>
                <div class="actions">
                    <input type="submit" class="btn primary" value="sauvegarder">
                </div>
            </form>
        </div>
        <div class="container table-boxes" style="margin-left: 10px;">
        <div style="background-color: green;"><h5 style="text-align: center; color: white"><?php echo $this->Session->flash(); ?></h5></div>    
                    <h6><?php echo "$total_service Services enrégistrées"; ?></h6>    
                    <br>        
                
                    <table class="table table-bordered">
                        <thead style="background-color: #0a2558; color:white;">
                            <tr>
                                <th scope="col">Intitulé service</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php foreach($services as $k => $v): ?>
                                <tr>
                                    <td><?php echo $v->intitule_serv; ?></td>
                                
                                    <td>
                                        <a href="<?php echo Router::url('admin/services/edit/'.$v->id); ?>">Modifier</a><span> | </span>
                                        <a  onclick="return confirm('Voulez vous vraiment supprimer ce service');" href="<?php echo Router::url('admin/services/delete/'.$v->id); ?>">Supprimer</a>
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
    </div>
    <br>
</div>

<script src=<?php echo Router::url('js/app.js'); ?>></script>