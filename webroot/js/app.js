$(document).ready(function() {
    // Initialisation de Select2 sur les champs patient et prestation
    $('#patient_id, #prestation_id, #prescripteur_id').select2({
        placeholder: "Sélectionnez une option",
        allowClear: true,
        width: '100%', // Ajuste la largeur du champ Select2
    });

    // Affichage dynamique du type de client lors de la sélection d'un patient
    $('#patient_id').on('change', function() {
        let selectedPatient = $(this).find(':selected');
        let typeClient = selectedPatient.attr('type_client') || '';

        // Mettre à jour le conteneur avec le type de client
        $('#type-client-info').text(typeClient ? 'Type de client : ' + typeClient : '');
        
        // Recalculer les montants après la sélection du patient
        calculerMontantGlobal();
    });

    // Lorsque le champ prestation est modifié, recalculer les montants
    $('#prestation_id').on('change', function() {
        synchroniserSelects(); // Synchronisation avec le champ montant
        calculerMontantGlobal(); // Recalculer les montants
    });

    // Recalculer les montants lorsque la réduction est modifiée
    $('#reduction').on('change', function() {
        calculerMontantGlobal(); // Recalculer les montants
    });
});

// Fonction pour synchroniser les champs prestation et montant
function synchroniserSelects() {
    let prestationSelect = document.getElementById("prestation_id");
    let montantSelect = document.getElementById("montant");

    // Vider le champ montant avant de le remplir à nouveau
    montantSelect.innerHTML = '';

    // Remplir le champ montant en fonction des prestations sélectionnées
    let selectedOptions = prestationSelect.selectedOptions;
    let selectedMontants = []; // Tableau pour stocker les montants sélectionnés

    for (let i = 0; i < selectedOptions.length; i++) {
        let option = selectedOptions[i];
        let montantOption = document.createElement("option");
        montantOption.value = option.getAttribute('montant'); // Montant de la prestation
        montantOption.textContent = option.textContent; // Texte de la prestation
        montantSelect.appendChild(montantOption);

        // Ajouter le montant au tableau pour la sélection
        selectedMontants.push(montantOption.value);
    }

    // Sélectionner toutes les options de montant
    for (let j = 0; j < montantSelect.options.length; j++) {
        montantSelect.options[j].selected = true; // Sélectionner chaque option
    }

    // Calculer le montant global après la synchronisation
    calculerMontantGlobal();
}

function calculerMontantGlobal() {
    let prestationSelect = document.getElementById("prestation_id");
    let patientSelect = document.getElementById("patient_id");
    let reductionSelect = document.getElementById("reduction"); // Référence au champ de réduction

    let montantTotal = 0;  // Montant total sans réduction
    let montantAvantReduction = 0; // Montant avant application de la réduction
    let montantGlobal = 0; // Net à payer après calcul
    let reduction = parseFloat(reductionSelect.value) || 1; // Par défaut, pas de réduction (1)

    // Parcourir les prestations sélectionnées et additionner leurs montants
    for (let i = 0; i < prestationSelect.selectedOptions.length; i++) {
        let montantPrestation = parseInt(prestationSelect.selectedOptions[i].getAttribute('montant')) || 0;
        montantTotal += montantPrestation; // Ajout au montant total
    }

    // Récupérer le type de client pour ajuster le montant en fonction de la prise en charge
    let typeClient = "";
    if (patientSelect.selectedOptions.length > 0) {
        typeClient = patientSelect.selectedOptions[0].getAttribute('type_client');
    }

    montantAvantReduction = montantTotal; // Initialisation avec le montant total avant réduction

    // Ajuster le montant global en fonction du type de client avant réduction
    if (typeClient === "etudiant") {
        montantAvantReduction = montantTotal * (2 / 3); // Réduction pour les étudiants avant réduction
    } else if (typeClient === "Personnel_udt" || typeClient === "projet") {
        montantAvantReduction = montantTotal * 0; // Réduction pour le personnel UFR santé avant réduction
    }

    // Calcul du montant global en fonction de la réduction choisie
    if (reduction === 1) { 
        montantGlobal = montantAvantReduction; // Pas de réduction appliquée
    } else if (reduction === 100) { 
        montantGlobal = 0; // Si réduction de 100%, Net à payer = 0
    } else if (reduction === 101) { 
        montantGlobal = 0; // Si réduction de 100%, Net à payer = 0
    } else {
        montantGlobal = montantAvantReduction * (1 - reduction); // Appliquer la réduction sur le montant
    }

    // Arrondir les montants à l'entier naturel le plus proche
    montantTotal = Math.round(montantTotal); // Arrondi du montant total
    montantAvantReduction = Math.round(montantAvantReduction); // Arrondi du montant avant réduction
    montantGlobal = Math.round(montantGlobal); // Arrondi du montant global (Net à payer)

    // Mettre à jour le champ "Net à payer" avec le montant global arrondi
    document.querySelector('#montant_global').value = montantGlobal || 0;

    // Calcul de la prise en charge (PEC) : Montant total - Montant global (Net à payer)
    let pec = Math.round(montantTotal - montantGlobal); // Arrondir la valeur de PEC
    document.querySelector('#pec').value = pec || 0; // Afficher la PEC arrondie
}



// Exécuter la synchronisation lorsque la sélection change
document.getElementById('prestation_id').addEventListener('change', synchroniserSelects);

// Synchroniser lors du chargement initial (si une option est déjà sélectionnée)
window.onload = synchroniserSelects;
