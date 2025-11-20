<?php
class DashboardsController extends Controller{

    /**
     * Admin
     */
    function admin_index(){
        $perPage = 10;

        $this->loadModel('Facture');
        $this->loadModel('Service');

        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Prestation');
    $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }

    $condition = "id != 0";

$supprimees = $this->Facturessupprimee->find(array(
    'fields' => 'numero_facture'
));
$liste_numeros = array_map(function($s) {
    return $s->numero_facture;
}, $supprimees);

$clause_exclusion = '';
if (!empty($liste_numeros)) {
    $in_clause = "'" . implode("','", $liste_numeros) . "'";
    $clause_exclusion = "num NOT IN ($in_clause)";
    $clause_inclusion = "num IN ($in_clause)";
}else{
        $clause_exclusion = $condition;
        $clause_inclusion = $condition;
}

        $d['factures'] = $this->Facture->find(array(
            'conditions' => $clause_exclusion,
            'group' => 'num',
            'limit' => ($perPage*($this->request->page-1)).','.$perPage,
            'order' => 'id'
        ));
            $d['factures_corb'] = $this->Facture->find(array(
                'conditions' => $clause_inclusion,
                'group' => 'num',
                'limit' => ($perPage * ($this->request->page - 1)) . ',' . $perPage,
                'order' => 'id'
            ));
            
            
            $clause_modif = 'modifier = 1';
            $clause_in_opht = 'service_id = 1';
            $clause_in_anapath = 'service_id = 2';
            $clause_in_anabio = 'service_id = 3';
        // Combine les deux conditions
        if (!empty($clause_exclusion)) {
            $condfact = $clause_modif . ' AND ' . $clause_exclusion;
            $condopht = $clause_in_opht . ' AND ' . $clause_exclusion;
            $condanapath = $clause_in_anapath . ' AND ' . $clause_exclusion;
            $condanabio = $clause_in_anabio . ' AND ' . $clause_exclusion;
        } else {
            $condopht = $clause_in_opht;
            $condanapath = $clause_in_anapath;
            $condanabio = $clause_in_anabio;
            $condfact = $clause_modif;
        }
            
        $d['fact_sup'] = $this->Facture->find(array(
            'conditions' => $condfact,
            'group' => 'num',
            'limit' => ($perPage*($this->request->page-1)).','.$perPage,
            'order' => 'id'
        ));
        
        $d['total_patient'] = $this->Patient->findCount($condition);
        $d['total_service'] = $this->Service->findCount($condition);

        $d['total_facture_opht'] = $this->Facture->CountFact($condopht);
        $d['total_facture_anapath'] = $this->Facture->CountFact($condanapath);
        $d['total_facture_anabio'] = $this->Facture->CountFact($condanabio);
        $d['sum_fact_opht'] = $this->Facture->sum($condopht);
        $d['sum_fact_anapath'] = $this->Facture->sum($condanapath);
        $d['sum_fact_anabio'] = $this->Facture->sum($condanabio);
        
        $d['total_facture'] = $this->Facture->CountFact($clause_exclusion);
        $d['total_patient'] = $this->Patient->findCount($condition);
        $d['total_service'] = $this->Service->findCount($condition);
        $d['sum_fact'] = $this->Facture->sum($clause_exclusion);

        $d['page'] = ceil($d['total_facture'] / $perPage);
        $this->set($d);
    }

/**dg*/

 function top_man_index(){
        $perPage = 10;

        $this->loadModel('Facture');
        $this->loadModel('Service');

        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Prestation');
        $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }

    $condition = "id != 0";

$supprimees = $this->Facturessupprimee->find(array(
    'fields' => 'numero_facture'
));
$liste_numeros = array_map(function($s) {
    return $s->numero_facture;
}, $supprimees);

$clause_exclusion = '';
if (!empty($liste_numeros)) {
    $in_clause = "'" . implode("','", $liste_numeros) . "'";
    $clause_exclusion = "num NOT IN ($in_clause)";
    $clause_inclusion = "num IN ($in_clause)";
}else{
        $clause_exclusion = $condition;
        $clause_inclusion = $condition;
}

            $clause_in_opht = 'service_id = 1';
            $clause_in_anapath = 'service_id = 2';
            $clause_in_anabio = 'service_id = 3';
        // Combine les deux conditions
        if (!empty($clause_exclusion)) {
            $condopht = $clause_in_opht . ' AND ' . $clause_exclusion;
            $condanapath = $clause_in_anapath . ' AND ' . $clause_exclusion;
            $condanabio = $clause_in_anabio . ' AND ' . $clause_exclusion;
        } else {
            $condopht = $clause_in_opht;
            $condanapath = $clause_in_anapath;
            $condanabio = $clause_in_anabio;
        }
        
        $d['total_patient'] = $this->Patient->findCount($condition);
        $d['total_service'] = $this->Service->findCount($condition);

        $d['total_facture'] = $this->Facture->CountFact($clause_exclusion);
        $d['total_facture_opht'] = $this->Facture->CountFact($condopht);
        $d['total_facture_anapath'] = $this->Facture->CountFact($condanapath);
        $d['total_facture_anabio'] = $this->Facture->CountFact($condanabio);
        $d['sum_fact_opht'] = $this->Facture->sum($condopht);
        $d['sum_fact_anapath'] = $this->Facture->sum($condanapath);
        $d['sum_fact_anabio'] = $this->Facture->sum($condanabio);

        $d['sum_fact'] = $this->Facture->sum($clause_exclusion);
        
                // DONNEES MENSUELLE
       // Récupérer l'année depuis GET ou utiliser l'année courante
$annee = isset($_GET['annee']) ? (int) $_GET['annee'] : date('Y');

// Tableau vide pour stocker les résultats par mois
$factures_par_mois = [];
$montants_par_mois = [];

// Boucler sur les 12 mois
for ($mois = 1; $mois <= 12; $mois++) {
    // Formater le mois (01, 02, 03...)
    $mois_format = str_pad($mois, 2, '0', STR_PAD_LEFT);

    // Condition de recherche : même service, même année, même mois
    $cond_mois = $clause_exclusion . " AND DATE_FORMAT(date_creation, '%Y-%m') = '{$annee}-{$mois_format}'";

    // Nombre de factures pour ce mois
    $factures_par_mois[$mois] = $this->Facture->CountFact($cond_mois);

    // Montant total pour ce mois
    $montants_par_mois[$mois] = $this->Facture->sum($cond_mois);
}

$d['annee'] = $annee;
$d['factures_par_mois'] = $factures_par_mois;
$d['montants_par_mois'] = $montants_par_mois;


        // END DONNEES MENSUELLE
        $this->set($d);
    }



       /**
     * Permet de récupérer les services pour le menu facture
     */
    public function getMenu(){
        $this->loadModel('Service');
        return $this->Service->find(array(
            'conditions' => array('id != 0' )
        ));
     }
}