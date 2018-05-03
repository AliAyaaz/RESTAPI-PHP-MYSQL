<html>
  <head>
    <title>REST API CRUD</title>
  </head>

  <!--  it is better to use separate CSS file and add that css file here, i have added css here only for creating every thing in same file -->
  <style> 
    .full-content-center { max-width: 300px; margin: 6% auto; }
    .div-input { margin-top:20px; }
    .btn-login { background-color: #68C39F; border-color: #68C39F; color: #FFFFFF; height: 34px; margin-top: 20px; }
    .form-control { width: 100%; padding: 6px; font-size: 14px; line-height: 1.42; }
  </style>


  <!--  it is better to create  separate file for form and  post values here , i have added form here because i want to put all code in same file -->
  <div class="container">

    <div class="full-content-center"> 
        <h3>REST API  CRUD</h3>
      
        <div class="login-block">

          <form role="form"  name="form1" id="mainForm" method="post" enctype="multipart/form-data" action="">

            <div class="div-input">
              <input type="text" name ="userName" class="form-control" required="" placeholder="Enter Your Name" />
            </div>

            <div class="div-input">
              <input type="email" name ="userEmail" class="form-control" required=""  placeholder="Enter your email" />
            </div>

            <div class="row">
              <div class="col-sm-6">
                <input type="submit" value ="Register"  class="btn-login" />
              </div>
            </div>
            
          </form>

        </div>
  
    </div>
  </div>
  
</html>






<?php 
   // Calling Database connection 
	 require_once("Config/DB.php");
	 $db= new DB("localhost", "testdb", "root", "");
                                  
   
// CRUD  READ METHOD

	  if( $_SERVER['REQUEST_METHOD'] =="GET")
	  {
  
      /* //if you want to READ any record from db, use this READ method of CRUD
 
          echo json_encode($db->query("SELECT * FROM user"));
          success 200 code
          http_response_code(200);
      */
    
	  }
    
    // CRUD  CREATE METHOD
    
	  else if( $_SERVER['REQUEST_METHOD'] =="POST")
	  {
        $UserName= $_POST['userName'];
        $UserEmail= $_POST['userEmail'];
        $UserPassword = bin2hex(openssl_random_pseudo_bytes(4));    
        
			    if ($db->query("SELECT * FROM users where Email='".$UserEmail."'"))
			    {
				      echo '{"Error" : User "Already Exists"}';
              http_response_code(400);
			    }
			    else
			    {
              $db->query("INSERT INTO users (Id, Name, Email, Password, User_Group) VALUES (NULL, '". $UserName."', '".$UserEmail."', '".$UserPassword."', 'admin')");
              echo '{"Status" : "Success"}';
              http_response_code(200);
                  
              // Call Mail function for sending email to User with Random Password 
                  
              SendEmail($UserEmail, $UserPassword);
                          
			    }
      }
	 
  
  // CRUD  DELETE METHOD
  
      else if( $_SERVER['REQUEST_METHOD'] =="DELETE")
	    {
            // if you want to delete any record from db, use this DELETE method of CRUD
      }
	    else
	    {
	  	    http_response_code(405);
	    }
      
      
      function  SendEmail($sendto, $password )
      {
      
              $to = $sendto;
              $subject = "HTML email";
              $header = "From: ayaaz83@gmail.com\r\n";
              $header.= "MIME-Version: 1.0\r\n";
              $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
              $header.= "X-Priority: 1\r\n";

              $message = "
              <html>
              <head>
                 <title>Registeration Email Notification</title>
              </head>
              <body>
                  <p> You password  is  ".$password."</p>
              </body>
              </html>
              ";

              // Always set content-type when sending HTML email
              $headers = "MIME-Version: 1.0" . "\r\n";
              $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

              // More headers
              $headers .= 'From: <ayaaz83@gmail.com>' . "\r\n";

              $status = mail($to, $subject, $message, $header);

              if($status)
              {
                  echo '<p>Your mail has been sent!</p>';
              } 
              else 
              {
                 echo '<p>Something went wrong, Please try again!</p>';
              }

      }
?>





