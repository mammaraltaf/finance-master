<!DOCTYPE html>
<html>
<head>
    <title>Print Log Details</title>
</head>
<body>
    <?php
echo $request;
echo "<br>";

foreach ($logs as $a) {
    print_r($a);
    echo "<br>";
}
?>

<br>
<h4>Approval History Information</h4>
<p>Approval Status: 1 of 1 received</p>

    <table class="table">
    <thead>
        <tr>
            <th>Action</th>
            <th>User ID</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($request as $req)
        <tr>
            <td><?php echo $req->action; ?></td>
            <td><?php echo $req->user_id; ?></td>
            <td><?php echo $req->date; ?></td>
            <td><?php echo $req->time; ?></td>
        </tr>
        @endforeach
    </tbody>
    </table>
        <p>Initiator: <?php echo $req->initiator; ?></p>
        <p>Manager: <?php echo $req->manager; ?></p>
        <p>Finance: <?php echo $req->finance; ?></p>
        <p>Director: <?php echo $req->director; ?></p>
</body>
</html>
