<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        .cote-a-cote {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 5px;
        }

        .logos {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 10px;
        }
        
        .logos img {
          max-width: 100%;
          height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 10px;
            word-wrap: break-word;
        }

        thead {
            background-color: #0d3073;
            color: white;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 5px 0 0 0;
            text-align: center;
            font-size: 10px;
        }

        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        @media print {
  * {
    box-sizing: border-box;
  }


  body, html {
    margin: 0;
    padding: 0;
    width: 80mm;
    font-size: 13px;
    line-height: 1.4;
    background: white;
  }

  .page_agent {
    width: 80mm;
    margin: 0 auto;
    padding: 4mm;
    background: white;
  }

  .logos {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 5mm;
  }

  .logos img {
    max-height: 40px;
    max-width: 40mm;
    object-fit: contain;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }

  th, td {
    border: 1px solid black;
    padding: 3px;
    word-break: break-word;
  }

  .cote-a-cote_print {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 4px;
  }

  ul {
    font-size: 10px;
    text-align: center;
    margin-top: 6px;
  }

  @page {
    size: 80mm auto;
    margin: 0;
  }

      .home-content {
      margin: 0 !important;
      padding: 0 !important;
    }
    
    .hidden-print, .hidden-print * {
      display: none !important;
      visibility: hidden !important;
    }
    
    }


    </style>
</head>

<body>
<div class="home-content">
    <div class="hidden-print" style="padding-left: 20px;">
        <button id="btnPrinter" style="height: 40px; width: 100px;">Imprimer</button>
    </div>

    <div class="page_agent">
        <div class="logos">
            <div><img src="<?php echo Router::url('img/logo uidt.png'); ?>" alt="Logo UIDT"></div>
            <div><img src="<?php echo Router::url('img/Logo UMRED.jpg'); ?>" alt="Logo UMRED"></div>
        </div>

        <div class="cote-a-cote_print">
            <div>
                <b>Service:</b>
                <?php foreach($prestations as $w): if ($factures->prestation_id == $w->id): foreach($services as $u): if ($w->service_id == $u->id): echo $u->intitule_serv; endif; endforeach; endif; endforeach; ?>
            </div>
        </div>
<br>
        <div class="cote-a-cote_print">
            <div>
                <b>Patient:</b>
                <?php foreach($patients as $w): if ($factures->patient_id == $w->id): echo "$w->prenom_patient $w->nom_patient"; endif; endforeach; ?>
            </div>
            <div>
                <b>Facture:</b> <?php echo $factures->num; ?>
            </div>
        </div>

        <div class="cote-a-cote_print">
            <div>
                <b>Téléphone:</b>
                <?php foreach($patients as $w): if ($factures->patient_id == $w->id): echo "$w->telephone_patient"; endif; endforeach; ?>
            </div>
            <div>
                <b>Date:</b>
                <?php
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $factures->date_creation);
                    if (!$date) $date = DateTime::createFromFormat('Y-m-d', $factures->date_creation);
                    echo $date ? $date->format('d/m/Y') : 'Date invalide';
                ?>
            </div>
        </div>
<br>

        <table>
            <thead>
                <tr>
                    <th>Prestation</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fact as $v): foreach($prestations as $w): if ($v->prestation_id == $w->id): ?>
                <tr>
                    <td><?php echo $w->intitule_prestat; ?></td>
                    <td><?php echo number_format($w->montant_prestat,0,',',' ')." Fcfa"; ?></td>
                </tr>
                <?php endif; endforeach; endforeach; ?>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr>
                    <td>Prise en charge
                        <?php 
                        switch ($factures->reduction) {
                            case 0: break;
                            case 101: echo " (par le projet!)"; break;
                            default: echo " (Réduction de " . ($factures->reduction * 1) . "%)"; break;
                        } ?>
                    </td>
                    <td><b><?php echo number_format($factures->pec,0,',',' ')." Fcfa"; ?></b></td>
                </tr>
                <tr>
                    <td>Net à payer</td>
                    <td><b><?php echo number_format($factures->montant_global,0,',',' ')." Fcfa"; ?></b></td>
                </tr>
            </tbody>
        </table>
<br>

        <ul>
            <li><b>UFR des sciences de la santé - Quartier 10ème (ex RIAOM) - Email : ufrsante@univ-thies.sn</b></li>
            <li><b>site web : www.univ-thies.sn - BP : 404 Thiès (Sénégal) - Tél : 33 951 83 73</b></li>
        </ul>
    </div>
</div>

<script>
  document.querySelector("#btnPrinter").addEventListener("click", () => {
    // Cloner le contenu de la facture
    const original = document.querySelector(".page_agent");
    const clone = original.cloneNode(true);
    
    // Ajouter une séparation entre les deux tickets
    const separator = document.createElement("hr");
    separator.style.border = "1px dashed #000";
    separator.style.margin = "8mm 0";

    // Injecter le clone et la séparation dans le DOM
    original.parentNode.appendChild(separator);
    original.parentNode.appendChild(clone);

    // Lancer l'impression
    window.print();

    // Nettoyer : retirer le clone et la séparation après impression
    window.onafterprint = () => {
      separator.remove();
      clone.remove();
    };
  });
</script>

</body>
</html>
