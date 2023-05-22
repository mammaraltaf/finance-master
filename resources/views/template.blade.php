<!DOCTYPE html>
<html>
<head>
    <title>Print Log Details</title>
</head>
<style>
    body {
				margin: 0;
				box-sizing: border-box;
				padding: 0 12px;
				font-size: 12px;
				font-family: "Poppins", sans-serif, monospace;
			}

			.header {
				display: flex;
				align-items: center;
				column-gap: 16px;
			}

			.headerNumber {
				font-size: 48px;
				padding: 12px 16px;
				background-color: orange;
			}
			.listingDetail > h2,
			p {
				margin: 0;
			}

			.listingDetail > p {
				color: #666666;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}

			th,
			td {
				padding: 12px 15px;
				text-align: left;
				border-bottom: 1px solid #ddd;
			}

			th {
				background-color: #032539;
				color: white;
				font-weight: bold;
			}

			tr:hover {
				background-color: #f5f5f5;
			}
</style>
<body>

	<div class="header">
        <div class="listingDetail">
            <h2>Request No. <?php echo $request->id; ?></h2>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Initiator</th>
                <th>Company ID</th>
                <th>Department ID</th>
                <th>Spplier ID</th>
                <th>Expense Type ID</th>
                <th>Currency</th>
      <th>Submission Date</th>
      <th>Comment</th>
      <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <tr>
                <td class="title">1</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td>John Doe</td>
                <td class="date">May 15, 2023</td>
                <td>John Doe</td>
                <td>John Doe</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</body>
</html>
