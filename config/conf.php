<?php
class Conf{
    static $debug = 1;
    static $databases = array(
        'default' => array(
            'host' => 'localhost',
            'database' => 'ufr2s_db',
            'login' => 'root',
            'password' => '',
        )
        );
}

Router::prefix('topmanagement','top_man');
Router::prefix('backoffice','admin');
Router::prefix('frontoffice','agent');
Router::prefix('chefs','chef_service');
Router::prefix('authentification','auth');
Router::connect('/','users/auth_login');
Router::connect('facture/:numero-:id','factures/detail/id:([0-9]+)/numero:([a-z0-9]+)');
Router::connect('facture/:action','factures/:action');

// users
Router::connect('user/:nom-:id','users/view/id:([0-9]+)/nom:([a-z0-9]+)');
// patients
Router::connect('patient/:nom-:id','patients/view/id:([0-9]+)/nom:([a-z0-9]+)');
// prestations
Router::connect('prestation/:nom-:id','prestations/view/id:([0-9]+)/intitule:([a-z0-9]+)');