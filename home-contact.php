<?php
/**
 *
  Contact
 *
 */
?>
<?php
$nameError = '';
$emailError = '';
$commentError = '';
 
 

if (isset($_POST['submitted'])) {
    if (trim($_POST['firstname']) === '') {
        $nameError = __( 'Please enter your name.', 'ariwoo' );
        $hasError = true;
    } else {
        $name = trim($_POST['firstname']);
    }
    if (trim($_POST['email']) === '') {
         $emailError = __( 'Please enter your email address.', 'ariwoo' );
        $hasError = true;
    } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
        $emailError = __( 'You entered an invalid email address.', 'ariwoo' );
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }
	$phone = trim($_POST['phone']);
    if (trim($_POST['message']) === '') {
       $commentError =  __( 'Please enter a message.', 'ariwoo' );
        $hasError = true;
    } else {
        if (function_exists('stripslashes')) {
            $comments = stripslashes(trim($_POST['message']));
        } else {
            $comments = trim($_POST['message']);
        }
    }

    //If there is no error, send the email
    if (!isset($hasError)) {
        $emailTo = get_option('tz_email');
        if (!isset($emailTo) || ($emailTo == '')) {
            $emailTo = get_option('admin_email');
        }
        $subject = '[Wordpress] From ' . $name;
        $body = "Name: $name \n\nPhone: $phone \n\nEmail: $email \n\nComments: $comments";
        $headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;
        mail($emailTo, $subject, $body, $headers);
        $emailSent = true;
    }
}
?>

<!-- blog title -->
<!-- blog title ends -->
<?php if (isset($emailSent) && $emailSent == true) { ?>
            <div class="thanks">
                <p><?php _e( 'Thanks, your email was sent successfully.', 'ariwoo' ); ?></p>
            </div>
        <?php } else { ?>
    <?php if (isset($hasError) || isset($captchaError)) { ?>
                <p class="error common"><?php _e( 'Sorry, an error occured. ', 'ariwoo' ); ?></p>
            <?php } ?>
            
            
            
             <form   action="<?php $_SERVER['PHP_SELF'] ?>" id="register-form" novalidate="novalidate" method="post">
						<div class="col-md-6 span">
						
                        
                        	<input type="text"   name="firstname" value="<?php if (isset($_POST['firstname']))
            echo $_POST['firstname'];
            ?>" placeholder="<?php _e( 'Name', 'ariwoo' ); ?>"><?php if ($nameError != '') { ?>
                    <span class="error name"> <?php echo $nameError; ?> </span>                           
                       <?php } ?>
                       
                       
                       
							<input type="text" name="phone" value="" placeholder="<?php _e( 'Phone', 'ariwoo' ); ?>">
							<input type="text" name="email" value="<?php if (isset($_POST['email']))
                       echo $_POST['email'];
                   ?>" placeholder="<?php _e( 'Email', 'ariwoo' ); ?>"> <?php if ($emailError != '') { ?>
                    <span class="error email"> <?php echo $emailError; ?> </span>                            
                       <?php } ?>
						</div>
                        
                        
						<div class="col-md-6 omega span"><textarea  name="message" value="<?php
                   if (isset($_POST['message'])) {
                       if (function_exists('stripslashes')) {
                           echo stripslashes($_POST['message']);
                       } else {
                           echo $_POST['message'];
                       }
                   }
                       ?>" placeholder="<?php _e( 'Message', 'ariwoo' ); ?>"></textarea>  <?php if ($commentError != '') { ?>
                    <span class="error comment"> <?php echo $commentError; ?> </span>
                <?php } ?></div>
						<div class="clear"></div>
					<div class="col-md-12">		<input type="reset" class="con_btn" value="Clear Form">
						<input type="submit" class="con_btn send_btn" value="<?php _e( 'Send', 'ariwoo' ); ?>">
                         <input type="hidden" name="submitted" id="submitted" value="<?php _e( 'true', 'ariwoo' ); ?>" /> </div>
						<div class="clear"></div>
					</form>
            

            
             
<?php } ?>
 