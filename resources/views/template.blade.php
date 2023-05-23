<!DOCTYPE html>
<html>
<head>
    <title>Print Log Details</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    h4 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    th {
        font-weight: bold;
        background-color: #f2f2f2;
    }
</style>
<body>
    <?php
    
// echo ( $request['typeOfExpense']);
// echo "<br>";
// exit();
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
    <p>Company: <?php echo $request['company']['name']; ?></p>
    <p>Department: <?php echo $request['department']['name']; ?></p>
    <p>Supplier: <?php echo $request['supplier']['supplier_name']; ?></p>
    <p>Type Of Expense: <?php echo $request['typeOfExpense']['name']; ?></p>
    <p>Currency: <?php echo $request['currency']; ?></p>
    <p>Amount: <?php echo $request['amount']; ?></p>
    <p>Amount in gel: <?php echo $request['amount_in_gel']; ?></p>
    <p>Basis: <?php  echo $request['basis']; ?></p>
    <p>Due Date Payment: <?php echo $request['payment_date']; ?></p>
    <p>Due Date Submission: <?php echo $request['submission_date']; ?></p>
    <p>Description: <?php echo $request['description']; ?></p>
    <p>Status: <?php echo $request['status']; ?></p>
    <?php //exit(); ?>
       
</body>
</html>
