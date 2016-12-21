<?php
if(!empty($_REQUEST['password']))
{
    //In real life, probably do a user/pw lookup in DB
    if($_POST['password'] == 'webdev')
    {
        //note: CSV location should probably not exist in web-accessible folder
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=info.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $contents = file_get_contents("info.csv");
        print $contents;
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />

    <!--Access to the external CSS-->
    <link type="text/css" rel="stylesheet" href="style/reset.css" />
    <link type="text/css" rel="stylesheet" href="style/style.css" />

    <!--Access to the external JavaScript-->
    <script src="scripts/survey.js"></script>

    <!--Access to the external JavaScript-->
    <script src="scripts/survey.php"></script>

    <!--Title-->
    <title>Admin Panel</title>
  </head>

  <body>
    <!--Top Menu Bar-->
    <img id="img-logo" class="img-logo" src="images/logo.png" alt="Cougar logo"></img>
    <div id="top-content" class="body top content top-content">
      <header id="main-header" class="title main-header">
        <h1>Cougar Club Survey</h1>
      </header>
    </div>

    <!--Sidebar Area-->
    <div id="sidebar" class="content sidebar side">
      <ul>
        <li><a href="./index.php">Home</a></li>
        <li><a href="./admin.php">Admin</a></li>
        <li><a href="./info.php">Info</a></li>
      </ul>
    </div>
    <!--Main Content-->
    <div id="main-content" class="body main content main-content">
      <!--Submit form to ourselves using HTTP POST-->
      <form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
          <label for="password-box">The password is: "webdev"<br><br>Password:</label>
          <input type="password" name="password" id="password-box" />
          <br>
          <button type="submit"><b>Submit</b></button>
      </form>
    </div>
  </body>

</html>
