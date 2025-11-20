<div class="container">
    <h1><?php echo $total_facture; ?> Factures enrégistrées</h1>
    <br><a href="<?php echo Router::url('agent/factures/edit'); ?>" class="primary btn">ajouter une facture</a>
</div>
<br>
<table class="table table-bordered">
    <thead style="background-color: rgb(130, 106, 251);color:#fff;">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">N° facture</th>
            <th scope="col">Date création</th>
            <th scope="col">Agent</th>
            <th scope="col">Patient</th>
            <th scope="col">Prestation</th>
            <th scope="col">Montant global</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <?php foreach($factures as $k => $v): ?>
            <tr>
                <td><?php echo $v->id; ?></td>
                <td><?php echo $v->num; ?></td>
                <td><?php echo $v->date_creation; ?></td>
                    <?php foreach($users as $k => $w): ?>
                        <?php if ($v->user_id == $w->id): ?>
                            <td><?php echo $w->login; ?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php foreach($patients as $k => $w): ?>
                        <?php if ($v->patient_id == $w->id): ?>
                            <td><?php echo "$w->prenom $w->nom"; ?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php foreach($prestations as $k => $w): ?>
                        <?php if ($v->prestation_id == $w->id): ?>
                            <td><?php echo $w->intitule; ?></td>
                        <?php endif ?>
                    <?php endforeach ?>
                    <td><?php echo $v->montant_global; ?></td>
                <td>
                    <a href="<?php echo Router::url('agent/factures/edit/'.$v->id); ?>">Editer</a><span> | </span>
                    <a href="<?php echo Router::url("agent/factures/detail/{$v->id}/$v->num"); ?>">détail &rarr;</a>
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

