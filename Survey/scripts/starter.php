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
    'name' => ''
);

$file = fopen('info.csv', 'w');

//used to build checkboxes for class days
$class_days = array(
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday'
);

//TODO: consider how we might cache this array
$class_days_checked = array();
foreach($class_days as $key => $value)
{
    $class_days_checked[$key] = '';
}

print_r($_REQUEST);

//did we receive form data?
$errors = array();
if(!empty($_REQUEST['submit-form']))
{
    //populate old form values
    foreach($_REQUEST as $key => $value)
    {
        $form_values[$key] = $value;
    }

    //update CB values
    if(!empty($_REQUEST['class-days']))
    {
        foreach($_REQUEST['class-days'] as $value)
        {
            $class_days_checked[$value] = 'checked="checked"';
        }
    }

    //was our name textbox empty?
    if(strlen($_REQUEST['name']) == 0)
    {
        //textbox is blank
        $errors[] = "Please enter your name.";
    }
    else
    {
        //check to make sure that we only have text
        $pattern = '/[a-zA-Z]+/';
        preg_match($pattern, $_REQUEST['name'], $result);

        //first off, do I have any matches?
        if(count($result) > 0)
        {
            //does first item length match input length?
            if(strlen($result[0]) != strlen($_REQUEST['name']))
            {
                $errors[] = 'Names cannot contain numbers or special characters';
            }
        }
        else
        {
            $errors[] = 'Names cannot contain numbers or special characters';
        }
    }

    //validate checkbox data
    //Q1: did we get any CB data?
    if(empty($_REQUEST['class-days']) ||
        count($_REQUEST['class-days']) == 0)
    {
        $errors[] = 'Please select at least one day that you have class';
    }

}


$csvLine ="";
foreach ($_REQUEST as $key => $value)
{
  $csvLine += (string)$value + ',';
}
fputcsv($file, explode(",",$csvLine));

//we might ask: are error free?  If so, save to DB, file, etc.

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Simple Form</title>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function ()
        {
            document.getElementById("submit-form")
                .addEventListener("click", function(evt){

                    //tracks whether or not the form is validated
                    var allowSubmit = true;

                    //TODO: validate
                    //validate name box
                    //grab the text inside of our name textbox
                    var nameText = document.getElementById("name").value;
                    if(nameText.length === 0)
                    {
                        allowSubmit = false;
                        alert('Please enter a name');
                    }
                    else
                    {
                        //is this a valid name?
                        var result = nameText.match(/[a-zA-Z]+/);
                        if(result != undefined && result.length > 0)
                        {
                            //was the first match the same length as the original
                            //string?
                            if(result[0] !== result.input)
                            {
                                allowSubmit = false;
                                alert('Please enter a valid name');
                            }
                        }
                        else
                        {
                            allowSubmit = false;
                            alert('Please enter a valid name');
                        }
                    }


                    //did we encounter errors?
                    if(allowSubmit === false)
                    {
                        //stop click event
                        evt.preventDefault();
                    }

                });
        });
    </script>
</head>
<body>
    <article id="error-messages">
        <?php if(count($errors) > 0): ?>
            <h1>Errors were encountered in your submission</h1>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php print $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>
    <!--Submit form to ourselves using HTTP POST-->
    <form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <article class="question">
            <h1><label for="name">Name:</label></h1>
            <div><input id="name" name="name" type="text" size="20"
                        value="<?php print $form_values['name']; ?>"
                        required="required"
                /> </div>
            <div id="name-error" class="error-message"><!--TODO--></div>
        </article>
        <article class="question">
            <h1>Gender:</h1>
            <div><label for="gender-male">Male</label>
                <input id="gender-male" name="gender" type="radio"
                        value="male" size="20" />
            </div>
            <div><label for="gender-female">Female</label>
                <input id="gender-female" name="gender" type="radio"
                       value="female" size="20" />
            </div>
            <div id="gender-error" class="error-message"><!--TODO--></div>
        </article>
        <article class="question">
            <h1>Days you have class:</h1>
            <div>
                <ul>
                    <?php foreach($class_days as $lower => $upper): ?>
                        <li>
                            <input
                                type="checkbox"
                                name="class-days[]"
                                id="days-<?php print $lower; ?>"
                                value="<?php print $lower; ?>"
                                <?php print $class_days_checked[$lower]; ?>
                            />
                            <label for="days-<?php print $lower; ?>">
                                <?php print $upper; ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="days-error" class="error-message"><!--TODO--></div>
        </article>
        <button type="submit" name="submit-form" id="submit-form" value="submit">Submit</button>
    </form>
</body>
</html>
