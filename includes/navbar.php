<?php
if (!isset($_GET['langID']))

  $lang = 'en';
else

  $lang = $_GET['langID'];

include('locale/' . $lang . '.php');
?>

<!-- Navbar Start -->
<div class="container-fluid p-0 nav-bar">
  <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
    <a href="index.html" class="navbar-brand px-lg-4 m-0">
      <img src="img/iug.png" alt="Islamic University of Gaza Logo" style="height: 100px;">
    </a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
      <div class="navbar-nav ml-auto p-4">
        <a href="index.php?langID=<?= $lang ?>"
          class="nav-item nav-link <?= ($activePage == 'home') ? 'active' : '' ?>"><?php echo $langArray['navbar']['home']; ?></a>
        <a href="about.php?langID=<?= $lang ?>"
          class="nav-item nav-link <?= ($activePage == 'about') ? 'active' : '' ?>"><?php echo $langArray['navbar']['about']; ?></a>
        <a href="services.php?langID=<?= $lang ?>"
          class="nav-item nav-link <?= ($activePage == 'services') ? 'active' : '' ?>"><?php echo $langArray['navbar']['services']; ?></a>
        <a href="categories.php?langID=<?= $lang ?>"
          class="nav-item nav-link <?= ($activePage == 'categories') ? 'active' : '' ?>"><?php echo $langArray['navbar']['categories']; ?></a>
        <a href="index.php?langID=<?= $lang ?>#donation"
          class="nav-item nav-link <?= ($activePage == 'donation') ? 'active' : '' ?>"><?php echo $langArray['navbar']['donation']; ?></a>
        <a href="contact.php?langID=<?= $lang ?>"
          class="nav-item nav-link <?= ($activePage == 'contact') ? 'active' : '' ?>"><?php echo $langArray['navbar']['contact']; ?></a>

      </div>
    </div>

    <form name="langSelect" action="" method="get" style="display: flex;">
      <select name="langID" id="langID">
        <option selected disabled><?php echo $langArray['language_selector']['select_language']; ?></option>
        <option value="ar"><?php echo $langArray['language_selector']['arabic']; ?></option>
        <option value="en"><?php echo $langArray['language_selector']['english']; ?></option>
      </select>
      <br /><br />
      <button class="btn btn-primary" type="submit"><?php echo $langArray['language_selector']['submit']; ?></button>
    </form>
  </nav>
</div>
<!-- Navbar End -->