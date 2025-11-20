<!DOCTYPE html>
<html lang="en">
<head class="hidden-print">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="home-content" style="padding-top: 0px">
        <div class="page">
        <div class="cote-a-cote" >
            <div><img style="height: 150px; width: 150px;" src="<?php echo Router::url('img/logo uidt.png'); ?>" alt=""></div>
            <div><img style="height: 150px; width: 300px;" src="<?php echo Router::url('img/Logo UMRED.jpg'); ?>" alt=""></div>
        </div>
        <br><br>
                <h6 style="font-size: 30px;" >Prescripteur </h6>
                <br>
                <h3>Prénom :</h3> <?php echo $prescripteurs->prenom_prescripteur; ?>
                <h3>Nom : </h3><?php echo $prescripteurs->nom_prescripteur; ?>
                <h3>Téléphone : </h3><?php echo $prescripteurs->tel_prescripteur; ?>
                <h3>E-mail : </h3><?php echo $prescripteurs->mail_prescripteur; ?>
                <h3>Spécialité : </h3><?php echo $prescripteurs->specialite_prescripteur; ?>
                <h3>Structure : </h3><?php echo $prescripteurs->structure_prescripteur; ?>
                <h3>Service : </h3>
                        <?php foreach($services as $k => $u): ?>
                            <?php if ($prescripteurs->service_prescripteur_id == $u->id): ?>
                                <td><?php echo $u->intitule_serv; ?></td>
                            <?php endif ?>
                        <?php endforeach ?>

                <br><br><br>
                
                <br><br><br>
                <div style="text-align: center; ">
                <ul style="list-style: none; font-size: 15px;">
                    <b><li>UFR des sciences de la santé - Quartier 10ème (ex RIAOM) - Email : ufrsante@univ-thies.sn - site web : www.univ-thies.sn - BP : 404 Thiès (Sénégal) - Tél : 33 951 83 73</li></b>
                </ul>
            </div>
        </div>
    </div>
</body>

<script>
var btnPrinter = document.querySelector("#btnPrinter");

btnPrinter.addEventListener("click", () =>{
    window.print();
});
</script>
</html>