<!--Des Marks, 11352911-->

<?php
  /*
   * Agenda:
   * Discuss more semantic HTML layout
   * Discuss how checkboxes work
   * Validate checkboxes in PHP
   * JavaScript error validation
   * Mixing JS and PHP validation
   * Styling into a 3-column layout
   */

  //setup default form values
  $form_values = array(
      'first' => '',
      'last' => '',
      'gender' => '',
      'class' => '',
      'major' => '',
      'city' => '',
      'email' => '',
      'interests' => ''
  );

  $file = fopen('info.csv', 'a');

  $submit = 0;

  //used to build checkboxes for class days
  $gender = array(
      'Other' => 'Other',
      'Female' => 'Female',
      'Male' => 'Male'
  );

  //did we receive form data?
  $errors = array();
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
      //Check for a valid name
      if(empty($_POST["first"]))
      {
          //textbox is blank
          $errors[] = "Please enter your first name.";
          $submit = 1;
      }
      else
      {
          //check to make sure that we only have text
          $pattern = '/^[a-zA-Z ]*$/';
          preg_match($pattern, $_REQUEST['first'], $result);

          //first off, do I have any matches?
          if(count($result) > 0)
          {
              //does first item length match input length?
              if(strlen($result[0]) != strlen($_REQUEST['first']))
              {
                          $submit = 1;
                  $errors[] = 'Names cannot contain numbers or special characters';
              }
          }
          else
          {
                      $submit = 1;
              $errors[] = 'Names cannot contain numbers or special characters';
          }
      }

      //Check for a valid name
      if(empty($_POST['last']))
      {
                  $submit = 1;
          //textbox is blank
          $errors[] = "Please enter your last name.";
      }
      else
      {
          //check to make sure that we only have text
         $pattern = '/^[a-zA-Z ]*$/';
          preg_match($pattern, $_REQUEST['last'], $result);

          //first off, do I have any matches?
          if(count($result) > 0)
          {
              //does first item length match input length?
              if(strlen($result[0]) != strlen($_REQUEST['last']))
              {
                          $submit = 1;
                  $errors[] = 'Names cannot contain numbers or special characters';
              }
          }
          else
          {
                      $submit = 1;
              $errors[] = 'Names cannot contain numbers or special characters';
          }
      }

      //Check for a valid class
      if($_POST['gender'] == "none")
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please select a gender.";
      }

      //Check for a valid class
      if($_POST['class'] == "none")
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please select a class.";
      }

      //Check for a valid class
      if($_POST['gradYear'] == "none")
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please select a graduation year.";
      }

      //Check for a valid major
      if(empty($_POST['major']))
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please enter your major.";
      }
      else
      {
          //check to make sure that we only have text
          $pattern = '/^[a-zA-Z ]*$/';
          preg_match($pattern, $_REQUEST['major'], $result);

          //first off, do I have any matches?
          if(count($result) > 0)
          {
              //does first item length match input length?
              if(strlen($result[0]) != strlen($_REQUEST['major']))
              {
                          $submit = 1;
                  $errors[] = 'Your major cannot contain numbers or special characters';
              }
          }
          else
          {
                      $submit = 1;
              $errors[] = 'Your major cannot contain numbers or special characters';
          }
      }

      //Check for a valid class
      if($_POST['busy'] == "none")
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please select how busy you are.";
      }


      //Check for a valid city
      if(empty($_POST['city']))
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please enter your hometown.";
      }
      else
      {
          //check to make sure that we only have text
          $pattern = '/^[a-zA-Z, ]*$/';
          preg_match($pattern, $_REQUEST['city'], $result);

          //first off, do I have any matches?
          if(count($result) > 0)
          {
              //does first item length match input length?
              if(strlen($result[0]) != strlen($_REQUEST['city']))
              {
                          $submit = 1;
                  $errors[] = 'Your hometown cannot contain numbers or special characters';
              }
          }
          else
          {
                      $submit = 1;
              $errors[] = 'Your hometown cannot contain numbers or special characters';
          }
      }

      //was our name textbox empty?
      if(empty($_POST['email']))
      {
          //textbox is blank
                    $submit = 1;
          $errors[] = "Please enter your email.";
      }
      else
      {
          //first off, do I have any matches?
          if(filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) == FALSE)
          {
                      $submit = 1;
              $errors[] = 'The email you entered is not valid.';
          }
      }

      //was our name textbox empty?
      if(empty($_POST['interests']))
      {
          //textbox is blank
          $submit = 1;
          $errors[] = "Please enter your interests.";
      }
  }

  foreach ($_POST as $key => $value) {
    $form_values[$key] = $value;
  }

  if(isset($_POST['submit-form']) and ($submit == 0)){
    $first = $_POST['first'];
    $last = $_POST['last'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $gradYear = $_POST['gradYear'];
    $major = $_POST['major'];
    $busy = $_POST['busy'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $interests = $_POST['interests'];

    fputcsv($file, array($first." ".$last,$gender, $class, $gradYear, $major, $busy, $city, $email, $interests));

    foreach ($_POST as $key => $value) {
      $form_values[$key] = "";
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
    <title>Cougar Club Survey</title>

    <!--Javascript-->
  <script type="text/javascript">
         document.addEventListener("DOMContentLoaded", function (){
            document.getElementById("submit-form")
                .addEventListener("click", function(evt){

                    //tracks whether or not the form is validated
                    var allowSubmit = true;

                    //Get the proper docement element
                    var firstName = document.getElementById("first").value;
                    //Check for a length greater than 0
                    if(firstName.length === 0){
                        allowSubmit = false;
                        document.getElementById('first-error').innerHTML = "*Please enter a first name";
                    }
                    else{
                        document.getElementById('first-error').innerHTML = "";
                        //We have valid length, so now lets make sure we have valid characters
                        var result = firstName.match(/[a-zA-Z]+/);
                        if(result != undefined && result.length > 0){
                            //Make sure the there aren't 2 strings!
                            if(result[0] !== result.input){
                                allowSubmit = false;
                                document.getElementById('first-error').innerHTML = "Please enter a valid first name";
                            }
                        }
                        else{
                            allowSubmit = false;
                            document.getElementById('first-error').innerHTML = "Please enter a valid first name";
                        }
                    }

                    //Get the proper document element
                    var lastName = document.getElementById("last").value;
                    //Check for a length greater than 0
                    if(lastName.length === 0){
                        allowSubmit = false;
                        document.getElementById('last-error').innerHTML = "*Please enter a last name";
                    }
                    else{
                        document.getElementById('last-error').innerHTML = "";

                        //Check for valid characters
                        var result = lastName.match(/[a-zA-Z]+/);
                        if(result != undefined && result.length > 0){
                            //Are there 2 strings?
                            if(result[0] !== result.input){
                                allowSubmit = false;
                                document.getElementById('last-error').innerHTML = "Please enter a valid last name";
                            }
                        }
                        else{
                            allowSubmit = false;
                                document.getElementById('last-error').innerHTML = "Please enter a valid last name";
                        }
                    }

                    var gender = document.getElementById('gender').value;
                    if (gender === "none"){
                      document.getElementById("gender-error").innerHTML = "*Please select a gender.";
                      allowSubmit = false;
                    }
                    else {
                      document.getElementById("gender-error").innerHTML = "";
                    }

                    var classValue = document.getElementById('class').value;
                    if (classValue === "none"){
                      document.getElementById("class-error").innerHTML = "*Please select a class standing.";
                      allowSubmit = false;
                    }
                    else {
                      document.getElementById("clas-error").innerHTML = "";
                    }

                    var gradYear = document.getElementById('gradYear').value;
                    if (gradYear === "none"){
                      document.getElementById("gradYear-error").innerHTML = "*Please select a graduation year.";
                      allowSubmit = false;
                    }
                    else {
                      document.getElementById("gradYear-error").innerHTML = "";
                    }

                    //Get the proper document element
                    var majorText = document.getElementById("major").value;
                    //Check for a length greater than 0
                    if(majorText.length === 0){
                        document.getElementById("major-error").innerHTML = "*Please enter a major.";
                        allowSubmit = false;
                    }
                    else {
                      document.getElementById("major-error").innerHTML = "";
                    }

                    var busy = document.getElementById('busy').value;
                    if (busy === "none"){
                      document.getElementById("gradYear-error").innerHTML = "*Please select a how busy you are.";
                      allowSubmit = false;
                    }
                    else {
                      document.getElementById("busy-error").innerHTML = "";
                    }

                    //Get the proper document element
                    var cityText = document.getElementById("city").value;
                    //Check for a length greater than 0
                    if(cityText.length === 0){
                        allowSubmit = false;
                        document.getElementById("city-error").innerHTML = "*Please enter your hometown.";
                    }
                    else {
                      document.getElementById("city-error").innerHTML = "";
                    }

                    //Get the proper document element
                    var emailText = document.getElementById("email").value;
                    //Check for a length greater than 0
                    if(emailText.length === 0){
                        allowSubmit = false;
                        document.getElementById("email-error").innerHTML = "*Please enter your email.";
                    }
                    else{
                        document.getElementById("email-error").innerHTML = "";
                        //Check for valid characters
                        //http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
                        var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        var result = emailText.match(emailRegex);
                        if(result != undefined && result.length > 0){
                            //Make sure we don't have 2 strings
                            if(result[0] !== result.input){
                                allowSubmit = false;
                                document.getElementById("email-error").innerHTML = "*Please enter a valid email.";
                            }
                        }
                        else{
                            allowSubmit = false;
                            document.getElementById("email-error").innerHTML = "*Please enter a valid email.";
                        }
                    }

                    //Get the proper document element
                    var interestsText = document.getElementById("interests").value;
                    //Check for a length greater than 0
                    if(interestsText.length === 0){
                        allowSubmit = false;
                        document.getElementById("interests-error").innerHTML = "*Please enter your interests.";
                    }
                    else {
                      document.getElementById("interests-error").innerHTML = "";
                    }

                    //did we encounter errors?
                    if(allowSubmit === false){
                        //stop click event
                        evt.preventDefault();
                    }
                });
        });
    </script>
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
      <?php foreach ($errors as $key => $value) {
        echo "*".$value."<br><br>";
      }?>

      <!--Submit form to ourselves using HTTP POST-->
      <form class="survey-body" method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">

          <article class="question">
              <h3><label for="first">First name:&nbsp;</label></h3>
              <div><input id="first" class="basic" name="first" type="text" size="20"
                          value="<?php print $form_values['first']; ?>"
                          required="required" /> </div>
              <div id="first-error" class="error-message"><?php echo($nameerr);?><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="last">Last name:&nbsp;</label></h3>
              <div><input id="last" class="basic" name="last" type="text" size="20"
                          value="<?php print $form_values['last']; ?>"
                          required="required" /> </div>
              <div id="last-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3>Gender:&nbsp;</h3>
              <div><select name="gender" id="gender">
                <option value="none">Select</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
              </select></div>

              <div id="gender-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="class">Class Standing:&nbsp;</label></h3>
              <div><select name="class" id="class">
                <option value="none">Select</option>
                <option value="Freshman">Freshman</option>
                <option value="Sophmore">Sophmore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
                <option value="Graduate Student">Grad Student</option>
              </select></div>
              <div id="class-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="gradYear">Expected Graduation:&nbsp;</label></h3>
              <div><select name="gradYear" id="gradYear">
                <option value="none">Select</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select></div>
              <div id="gradYear-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="major">Major:&nbsp;</label></h3>
              <div><input id="major" name="major" type="text" size="20"
                          value="<?php print $form_values['major']; ?>"
                          required="required" /> </div>
              <div id="major-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="busy">How busy are you?:&nbsp;</label></h3>
              <div><select name="busy" id="busy">
                <option value="none">Select</option>
                <option value="1">1 - Not Busy</option>
                <option value="2">2 - Somewhat Busy</option>
                <option value="3">3 - Busy</option>
                <option value="4">4 - Very Busy</option>
              </select></div>
              <div id="busy-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="city">Hometown:&nbsp;</label></h3>
              <div><input id="city" name="city" type="text" size="20"
                          value="<?php print $form_values['city']; ?>"
                          required="required" /> </div>
              <div id="city-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
              <h3><label for="email">Email:&nbsp;</label></h3>
              <div><input id="email" name="email" type="text" size="20"
                          value="<?php print $form_values['email']; ?>"
                          required="required" /> </div>
              <div id="email-error" class="error-message"><!--TODO--></div>
          </article>

          <br>

          <article class="question">
            <h3><label for="interests">Interests:&nbsp;</label></h3>
            <div><input id="interests" name="interests" type="text" rows="5" size="20"
                        value="<?php print $form_values['class']; ?>"
                        required="required" /> </div>
            <div id="interests-error" class="error-message"><!--TODO--></div>
          </article>

          <button type="submit" name="submit-form" id="submit-form" value="submit"><b>Submit</b></button>
      </form>
    </div>
  </body>
</html>
