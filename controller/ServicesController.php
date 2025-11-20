<?php
class ServicesController extends Controller{
    /**
     * Admin
     */
    function admin_view($id){
        $perPage = 50;

        $this->loadModel('Service');
        $this->loadModel('Prestation');
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
    $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $condition = array('id != 0');

        $d['service'] = $this->Service->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
        $d['services'] = $this->Service->find(array(
            'conditions' => array('id'=>$id)
        ));
        $d['patients'] = $this->Patient->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));
        
        /*condition facture*/
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
        }
        /* end condition facture*/
        
        $clause_fact_serv = 'service_id = "'.$id.'" ';
   // Combine les deux conditions
    if (!empty($clause_exclusion)) {
        $condfact = $clause_fact_serv . ' AND ' . $clause_exclusion;
    } else {
        $condfact = $clause_fact_serv;
    }
        $d['factures'] = $this->Facture->find(array(
            'conditions' => $condfact,
            'group' => 'num',
            'limit' => ($perPage*($this->request->page-1)).','.$perPage,
            'order' => 'id'
        ));

        $d['total_facture'] = $this->Facture->CountFact($condfact);
        $d['total_prestation'] = $this->Prestation->findCount($clause_fact_serv);
        $d['sum_fact'] = $this->Facture->sum($condfact);
        $d['page'] = ceil($d['total_facture'] / $perPage);
        
        
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
    $cond_mois = $condfact . " AND DATE_FORMAT(date_creation, '%Y-%m') = '{$annee}-{$mois_format}'";

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

    function chef_service_view($id){
        $perPage = 30;

        $this->loadModel('Service');
        $this->loadModel('Prestation');
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Prescripteur');
        $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        $d['debut']='';
        $d['fin']='';
        $condition = array('id != 0');

       /*condition facture*/
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
        }
        /* end condition facture*/
        
        $clause_fact_serv = 'service_id = "'.$this->Session->user('service_id').'" ';
   // Combine les deux conditions
    if (!empty($clause_exclusion)) {
        $condit = $clause_fact_serv . ' AND ' . $clause_exclusion;
    } else {
        $condit = $clause_fact_serv;
    }
            
            
        if (!empty($_GET['debut']) && !empty($_GET['fin'])) {
            $condfact = ('date_creation >= "'.$_GET['debut'].'" AND date_creation <= "'.$_GET['fin'].'" AND  service_id = "'.$this->Session->user('service_id').'"  ');

                $d['factures'] = $this->Facture->find(array(
                    'conditions' => $condfact,
                    'group' => 'num',
                    'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                    'order' => 'id'
                ));
                $d['debut'] = $_GET['debut'];
                $d['fin'] = $_GET['fin'];
                $d['total_facture'] = $this->Facture->CountFact($condfact);
                $d['sum_fact'] = $this->Facture->sum($condfact);
            }else {
            $d['factures'] = $this->Facture->find(array(
                'conditions' => $condit,
                'group' => 'num',
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_facture'] = $this->Facture->CountFact($condit);
            $d['sum_fact'] = $this->Facture->sum($condit);
        }


        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }

        $d['service'] = $this->Service->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
        $d['services'] = $this->Service->find(array(
            'conditions' => array('id'=>$id)
        ));
        $d['patients'] = $this->Patient->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));
        $d['prescripteurs'] = $this->Prescripteur->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));

            $d['total_prestation'] = $this->Prestation->findCount($clause_fact_serv);
            $d['page'] = ceil($d['total_facture'] / $perPage);
            
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
    $cond_mois = $condit . " AND DATE_FORMAT(date_creation, '%Y-%m') = '{$annee}-{$mois_format}'";

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

    function export(){
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');
        $this->loadModel('Prescripteur');
        $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['services'] = $this->Service->get($this->request->data);
        $d['prescripteurs'] = $this->Prescripteur->get($this->request->data);

        $d['output'] = "";

        $d['debut']='';
        $d['fin']='';
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
        }
        if (!empty($_GET['debut']) && !empty($_GET['fin'])) {
            
                $clause_date = ('date_creation >= "'.$_GET['debut'].'" AND date_creation <= "'.$_GET['fin'].'" AND  service_id = "'.$this->Session->user('service_id').'"  ');
                // Combine les deux conditions
                if (!empty($clause_exclusion)) {
                    $condfact = $clause_date . ' AND ' . $clause_exclusion;
                } else {
                    $condfact = $clause_date;
                }
                
                $d['factures'] = $this->Facture->find(array(
                    'conditions' => $condfact,
                    'order' => 'id'
                ));
                $d['debut'] = $_GET['debut'];
                $d['fin'] = $_GET['fin'];
            }else {
                $condit_serve = 'service_id = "'.$this->Session->user('service_id').'" ';

                                // Combine les deux conditions
                if (!empty($clause_exclusion)) {
                    $condit = $condit_serve . ' AND ' . $clause_exclusion;
                } else {
                    $condit = $condit_serve;
                }
                $d['factures'] = $this->Facture->find(array(
                    'conditions' => $condit,
                    'order' => 'id'
            ));
        }
        $this->set($d);
     }
     
    /**
     * Permet d'éditer une facture
     */
    function admin_edit($id = null){
        $perPage = 10;

        $this->loadModel('Service');
        $this->loadModel('Prestation');

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Service->validates($this->request->data)){                
                $this->Service->save($this->request->data);
                $this->Session->setFlash('Prestation modifiée avec succès');    
                $this->redirect('admin/services/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Service->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = '';

        if (!empty($_GET['service_id'])) {

            $d['prestations'] = $this->Prestation->find(array(
                'conditions' => array('service_id' => $_GET['service_id']),
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['filtre'] = $_GET['service_id'];
        }else {
            $d['prestations'] = $this->Prestation->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
        }

        $d['services'] = $this->Service->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));

        $d['total_service'] = $this->Service->findCount($condition);
        $d['page'] = ceil($d['total_service'] / $perPage);
        $this->set($d);
     }

    /**
     * Permet de supprimer une prestation
     */ 
    
    function admin_delete($id){
        $this->loadModel('Service');
        $this->loadModel('Prestation');
        $Prestat = $this->Prestation->find(array(
         'conditions' => array('service_id'=>$id)
         ));
         if (empty($Prestat)) {
             $this->Service->delete($id);
             $this->Session->setFlash('Le service a bien été supprimer');    
             $this->redirect('admin/services/edit'); 
         }else {
             $this->Session->setFlash('Le service n\'a pas été supprimer car il contient au moins une prestation, veuillez d\'abord supprimer toutes les prestations');
             $this->redirect('admin/services/edit'); 
         } 
     }

    function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/services/edit');
        }else {
            $this->redirect('agent/services/edit');
        }
    }

}
