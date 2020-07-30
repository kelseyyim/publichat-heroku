<?php
    session_start();
?>

<?php

    
    $text = $_POST['text'];
    $fp = fopen($_SESSION["roomID"], 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['nickname']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);

?>