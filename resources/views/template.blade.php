<!DOCTYPE html>
<html>
<head>
    <title>Print Log Details</title>
</head>
<body>
<?php 
  echo $request;
  ?>
          <br>
          <?php  
foreach($logs as $a){
    print_r( $a);
    echo "<br>";
}

?>
</body>
</html>
