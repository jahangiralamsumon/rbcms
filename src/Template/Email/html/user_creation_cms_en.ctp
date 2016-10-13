<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome</title>
</head>
 <body>

     Hi <?php echo $templateContent[0]['content'];?> !<br/><br/>
 
     Your account has been successfully created! Nice to have you with us! You can login using the following link. <br/><br/>
     
     <a href="<?php echo $templateContent[3]['content'];?>">Login</a>
     <br/><br/>
     Your sign-in username and email address is: <?php echo $templateContent[1]['content'];?> <br/>
     Your password is: <?php echo $templateContent[2]['content'];?>
     <br/><br/><br/>
    

Regards,<br/>
CHTL Team<br/>
 
</body>
</html>