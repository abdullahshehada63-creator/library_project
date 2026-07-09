<nav class="navbar navbar-fixed-top navbar-inverse" style="border-radius: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
     <?php
      if(isset($_SESSION['type']))
      {
        if($_SESSION['type']==0)
        {
            $userType="Adminstrator";
        }
        else
        {
            $userType="User";
        }
      } 
      else
      {
        $userType="University Library Administration";
      }
      ?>
      <a href="#" onclick="showSid()"><span class="glyphicon glyphicon-th-list" style="float: left; padding-top: 15px;  margin-right: 10px; font-size: 16px; color: white;" ></span></a>
      <a class="navbar-brand" href="#"><?php echo $userType ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="/php_library_iug_project/index.php">Home</a></li>
       
        <?php
        if(isset($_SESSION['id']))
        {
          echo " <li><a href='admin.php?out'>Logout</a></li>";  
        } 
        else
        {
            echo "  <li><a href='login.php'>Login</a></li>";
        }
        ?>
      
       
      </ul>
    </div>
  </div>
</nav>