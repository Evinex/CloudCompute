<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM flight ORDER BY Fid LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM flight')->fetchColumn();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Air Asia</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="css/DisplayFlight.css" rel="stylesheet" type="text/css">
</head>


<div class="content read">
	<h2>Flight List</h2>
                      <a href="index.php" class="create-contact">Create Another Flight Plan.</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Flight From</td>
                <td>Destination</td>
                <td>Departure Date</td>
                <td>Return Date</td>
                <td>Ways</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['Fid']?></td>
                <td><?=$contact['Strlocation']?></td>
                <td><?=$contact['Destination']?></td>
                <td><?=$contact['Depart']?></td>
                <td><?=$contact['Back']?></td>
                <td><?=$contact['Way']?></td>
                <td class="actions">
                    <a href="UpdateDF.php?Fid=<?=$contact['Fid']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="DeleteDF.php?Fid=<?=$contact['Fid']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="DisplayFlight.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="DisplayFlight.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<footer>
  <div class="footer">
    <p>Air Asia</p>
    </div>
</footer>