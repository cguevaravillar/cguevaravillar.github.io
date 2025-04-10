<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors','On');
$disabled = explode(',', ini_get('disable_functions'));
if(in_array('mail', $disabled)) die("mail function is disabled on this server");
$debug = true; //change value to false once the form is working
$errors = '';
$myemail = 'carlosguevara.villar@yahoo.com';//<-----Put Your email address here.
if(isset($_POST['name']))
    {
        
    if(empty($_POST['name'])  ||
       empty($_POST['email']) ||
       empty($_POST['message']))
    {
        $errors .= "\n Error: all fields are required";
    }
    
    if( empty($errors))
    {
    
        $name = $_POST['name'];
        $email_address = $_POST['email'];
        $message = $_POST['message'];
        
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",$email_address))
        {
            $errors .= "\n Error: Invalid email address";
        }
        
        if( empty($errors))
        {
            $to = $myemail;
            $email_subject = "Contact form submission: $name";
            $email_body = "You have received a new message. ".
            " Here are the details:\n Name: $name \n Email: $email_address \n Message \n $message";
        
            $headers = "From: $myemail\n";
            $headers .= "Reply-To: $email_address";
            
            $send = (function_exists('mail')) ? @mail($to,$email_subject,$email_body,$headers) : false;
            if($send) {
                //redirect to the 'thank you' page
                header('Location: contact-form-thank-you.html');
                exit;
            } else {
                if($debug) phpinfo();
                else $errors .= 'Server error: Please report to the webmaster';
                exit;    
            }
        }
    }
} //end isset name
?>
