<?php $title_for_layout = $patients->id ?>
<div class="page-header">
    <h1>L'agent</h1>
</div>
<ul>
    <li><span>Id : </span><?php echo $patients->id; ?></li>
    <li><span>Prénom : </span><?php echo $patients->prenom; ?></li>
    <li><span>Nom : </span><?php echo $patients->nom; ?></li>
    <li><span>Tel : </span><?php echo $patients->tel; ?></li>
</ul>

<?php debug($patients); 