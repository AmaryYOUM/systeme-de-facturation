<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

      .page_agent {
        width: 200mm;
        margin: 0 auto;
        background: white;
      }

    </style>
</head>

<body>
    <div class="page_agent">
            <div>
                <h6>Information du prescripteur</h6>
            </div><br>
            <div>
                <b>Prénom :</b><?php echo $prescripteurs->prenom_prescripteur; ?>
            </div><br>
            <div>
                <b>Nom :</b> <?php echo $prescripteurs->nom_prescripteur; ?>
            </div><br>
            <div>
                <b>Téléphone :</b><?php echo $prescripteurs->tel_prescripteur; ?>
            </div><br>
            <div>
                <b>Mail :</b><?php echo $prescripteurs->mail_prescripteur; ?>
            </div><br>
            <div>
                <b>Spécialité :</b><?php echo $prescripteurs->specialite_prescripteur; ?>
            </div><br>
            <div>
                <b>Structure :</b><?php echo $prescripteurs->structure_prescripteur; ?>
            </div><br>
            <div>
                <b>Structure :</b>
                    <?php foreach($services as $k => $u): ?>
                        <?php if ($prescripteurs->service_prescripteur_id == $u->id): ?>
                            <td><?php echo $u->intitule_serv; ?></td>
                        <?php endif ?>
                    <?php endforeach ?>
            </div>
    </div>                        
</body>
</html>
