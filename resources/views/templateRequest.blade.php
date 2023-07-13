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
            <td>{{$log['action']}}</td>
            <td>{{$log['user']['user_type']}}</td>
            <td>{{$log['created_at']}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
<p>Initiator: {{$request['initiator']}}</p>
<p>Company: {{$request['company']['name']}}</p>
<p>Department: {{$request['department']['name']}}</p>
<p>Supplier: {{$request['supplier']['supplier_name']}}</p>
<p>Type Of Expense: {{$request['typeOfExpense']['name']}}</p>
<p>Currency: {{$request['currency']}}</p>
<p>Amount: {{$request['amount']}}</p>
<p>Amount in gel: {{$request['amount_in_gel']}}</p>
<p>Basis: {{$request['basis']}}</p>
<p>Due Date Payment: {{$request['payment_date']}}</p>
<p>Due Date Submission: {{$request['submission_date']}}</p>
<p>Description: {{$request['description']}}</p>
<p>Link: <a href="{{$request['request_link']}}" target="_blank">{{$request['request_link'] ?? ''}}</a></p>
<p>Status: {{$request['status']}}</p>
<p>Basis
    <?php
    $files=explode(',',$request['basis']);
    foreach($files as $file){ ?>
    <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>
    <?php  }
    ?>

</p>
</body>
</html>

