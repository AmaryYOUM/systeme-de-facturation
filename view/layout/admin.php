<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="<?php echo Router::url('css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo Router::url('css/bootstrap.min.css'); ?>" />

        <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UMRED</title>
    <link rel="icon" href="<?php echo Router::url('img/LOGO UMRED FAV.jpg'); ?>" type="image/jpeg">

  </head>
<body>
    <body>             
    <div class="sidebar hidden-print">
      <div class="logo-details"  style="height: 140px; width: 140px; margin-top: 10px; margin-left: 30px; background-color: white;  border-radius: 100%;">
        <a href="<?php echo Router::url('admin/dashboards/index'); ?>">
          <img style="height: 120px; width: 120px; margin: 10px;" src="<?php echo Router::url('img/logo uidt.png'); ?>" alt="">
        </a>
      </div>
      <ul class="nav-links">
        <li>
          <a href="<?php echo Router::url('admin/dashboards/index') ?>">
          <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboards</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/factures/edit') ?>">
            <i class="fa-solid fa-hospital-user"></i>
            <span class="links_name">Factures</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/prescripteurs/edit') ?>">
            <i class="fa-solid fa-users"></i>
            <span class="links_name">Prescripteur</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/patients/edit') ?>">
            <i class="fa-solid fa-users"></i>
            <span class="links_name">Patients</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/users/edit') ?>">
          <i class="fa-solid fa-users"></i>
          <span class="links_name">Agent</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/services/edit') ?>">
            <i class="fa-solid fa-house-medical"></i>
            <span class="links_name">Services</span>
          </a>
        </li>
        <li>
          <a href="<?php echo Router::url('admin/prestations/edit') ?>">
            <i class="bx bx-box"></i>
            <span class="links_name">Prestations</span>
          </a>
        </li>
        <li class="log_out">
            <span class="links_name">
                <form action="<?php echo Router::url('users/logout'); ?>" method="post">
                    <i class="bx bx-log-out"></i>
                    <input type="submit" class="btn primary" value="Déconnexion">
                </form>
            </span>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <nav class="hidden-print">
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        
        <div class="profile-details">
          <ul class="nav-links">
            <li style="list-style: none;">
              <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                <span class="admin_name"><?php echo $agent_prenom; ?> <?php echo $agent_nom; ?></span>
                <i class="bx bx-chevron-down"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li>
                  <a href="<?php echo Router::url('users/logout') ?>">
                    <span class="links_name">
                        <form action="<?php echo Router::url('users/logout'); ?>" method="post">
                            <i class="bx bx-log-out"></i>
                            <input type="submit" class="btn primary" value="Déconnexion">
                        </form>
                    </span>
                  </a>
                </li>
             </ul>
            </li>
          </ul>
        </div>

      </nav>
      <div class="home-content">
        <?php echo $content_for_layout; ?>
      </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>

    <!-- deconnexion automatique-->
<script>
let inactivityTime = function () {
    let timeout; // Variable pour le minuteur

    // Fonction pour réinitialiser le minuteur
    const resetTimer = function () {
        clearTimeout(timeout); // Effacer le minuteur précédent
        timeout = setTimeout(logoutUser, 300000); // Définir un nouveau minuteur de 5 minute
    };

    // Fonction pour déconnecter l'utilisateur
    const logoutUser = function () {
        // Effectuer une requête AJAX pour déconnecter l'utilisateur
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo Router::url('users/logout'); ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Rediriger vers la page de connexion ou afficher un message
                window.location.href = '<?php echo Router::url('users/auth_login'); ?>';
            }
        };
        xhr.send(); // Envoyer la requête
    };

    // Écouter les événements pour réinitialiser le minuteur
    window.onload = resetTimer; // Au chargement de la page
    window.onmousemove = resetTimer; // Lorsque la souris se déplace
    window.onkeypress = resetTimer; // Lorsque l'utilisateur appuie sur une touche
};

inactivityTime(); // Appeler la fonction
</script>

  </body>
</html>