<?php
  session_start();
?>


<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />

    <title>Publichat</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/modern-normalize/0.7.0/modern-normalize.min.css"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
<?php 

// permitted characters we want to use
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
// php function for generating the random stringID
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}

if($_POST["roomID"] == null)
{
  $_SESSION["roomID"] = generate_string($permitted_chars, 10);
} else {
  $_SESSION["roomID"] = $_POST["roomID"];
}


// if roomID == empty then just generate a randomizer alphanumeric setup



?>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
    <body>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <?php echo $_POST["nickname"]; ?><br></p>
        <h1>Room # <?php echo $_SESSION["roomID"]; ?><b></b></h1>
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox">
    <?php

if(file_exists($_SESSION["roomID"]) && filesize($_SESSION["roomID"]) > 0){
    $handle = fopen($_SESSION["roomID"], "r");
    $contents = fread($handle, filesize($_SESSION["roomID"]));
    fclose($handle);
     
    echo $contents;
}
?>
    </div>
    <form id="chat-form" action="" name="message">
        <div class="input-group mb-3">
          <input
            name="usermsg"
            type="text"
            id="usermsg"
            class="form-control"
            placeholder="Type your message here"
          />
          <?php 
          $username = $_POST["nickname"];
          ?>
          <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
        
        </div>
      </form>

</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){

// var room = "<?php echo $_SESSION["roomID"] ?>";
// setInterval(loadLog(room), 1000);
});
$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
    var room = "<?php echo $_SESSION["roomID"] ?>";
    loadLog(room);
		return false;
	});

  function loadLog(room){
    var oldscrollHeight = $("#chatbox").attr("scrollHeight");
    $.ajax({
      url: room ,
      cache: false,
      success: function(html){
        $("#chatbox").html(html); 		
        //Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: $('#chatbox').height()})
          }
    },
    error:function() {
      alert("ajax call error");
    }
});
}

</script>
</body>
</html>