<div class="page-header">
    <h1>Les patients</h1>
</div>
<?php foreach ($patients as $k => $v): ?>
    <?php echo $v->prenom; ?>
    <?php echo $v->nom; ?>
    <?php echo $v->tel; ?>
    <?php echo $v->email; ?>

    <p><a href="<?php echo Router::url("patients/detail/{$v->id}/$v->nom"); ?>">détail &rarr;</a></p>
<?php endforeach ?> 

<div class="pagination">
    <ul>
        <?php for ($i=1; $i <= $page ; $i++): ?>
            <li <?php if($i==$this->request->page) echo 'class="active"';  ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>    
    </ul>
</div>
