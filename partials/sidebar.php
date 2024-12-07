<?php 
session_start();
if(!isset($_SESSION['admin_legionweb']) || empty($_SESSION['admin_legionweb'])){
            echo ' <script> window.location.pathname = "admin/index.php"</script>';
            // header("Location: index.php");
  exit();
}?>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
          <!-- <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo"> -->
            <!-- <use xlink:href="image/LOGO BLANC"></use> -->
            <img src="image/LOGO OR.png" alt="" width="115" height="65">
          <!-- </svg> -->
          <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#signet"></use>
          </svg>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="index.html">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
            </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a></li>
        
        <li class="nav-title">Components</li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
            </svg> les articles de blog</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="formblog.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> creer un nouvel article</a></li>
            <li class="nav-item"><a class="nav-link" href="blog.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> voir les article creer</a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
            </svg> Evenements</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="formevent.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> creer un nouvel Evenement</a></li>
            <li class="nav-item"><a class="nav-link" href="evenements.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> voir les Evenement</a></li>
            <li class="nav-item"><a class="nav-link" href="anciensevenement.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Anciens Evenement</a></li>
          </ul>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
            </svg> message des clients </a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="client.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> voir les message </a></li>
          </ul>
        </li>
        
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
        </svg> les evenement</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="ajoutevents.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> creer un nouveaux evenement</a></li>
            <li class="nav-item"><a class="nav-link" href="allevents.php"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> voir les evenement creer</a></li>
          </ul>
        </li>


       

              <!-- <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>
           
        </li> -->
       
        
      <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>