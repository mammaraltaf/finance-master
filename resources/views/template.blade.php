<!DOCTYPE html>
<html>
<head>
    <title>Print Log Details</title>
</head>
<body>
    <?php
    
// echo $request['amount_in_gel'];
// echo "<br>";

// foreach ($logs as $a) {
//     print_r($a);
//     echo "<br>";
// }
// exit();
?>

<br>
<h4>Approval History Information</h4>
<p>Approval Status: 1 of 1 received</p>

    <table class="table">
    <thead>
        <tr>
            <th>Action</th>
            <th>User</th>
            <th>Date</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td><?php echo $log['action']; ?></td>
            <td><?php echo $log['rolename']; ?></td>
            <td><?php  echo $log['log_date']; ?></td>
           
        </tr>
        @endforeach
    </tbody>
    </table>
    
        <p>Initiator: <?php echo $request['initiator']; ?></p>
        <p>Amount in gel: <?php echo $request['amount_in_gel']; ?></p>
        <p>Status: <?php echo $request['status']; ?></p>
        
       
</body>
</html>
