<div class="container">
    <h1><?php echo $total_user; ?> Agent enrégistrées</h1>
    <br><a href="<?php echo Router::url('admin/users/edit'); ?>" class="primary btn">ajouter un nouveau </a>
</div>
<br>
<table class="table table-bordered">
    <thead style="background-color: rgb(130, 106, 251);color:#fff;">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">En ligne</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Tel</th>
            <th scope="col">email</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <?php foreach($users as $k => $v): ?>
            <tr>
                <td><?php echo $v->id; ?></td>
                <td><span class="label <?php echo ($v->online==1)?'success':'error'; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span></td>
                <td><?php echo $v->prenom; ?></td>
                <td><?php echo $v->nom; ?></td>
                <td><?php echo $v->tel; ?></td>
                <td><?php echo $v->email; ?></td>
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