<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['Fid'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM flight WHERE Fid = ?');
    $stmt->execute([$_GET['Fid']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Flight Plan doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM flight WHERE Fid = ?');
            $stmt->execute([$_GET['Fid']]);
            $msg = 'You have deleted the Flight Plan! Returning to Flight Plan Page...'; header( "refresh:3;url=DisplayFlight.php" );
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: DisplayFlight.php');
            exit;
        }
    }
} else {
    exit('No Flight ID specified!');
}
?>

<?=template_header('Delete')?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Air Asia</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="css/DisplayFlight.css" rel="stylesheet" type="text/css">
</head>

<div class="content delete">
	<h2>Delete Contact #<?=$contact['Fid']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete Flight Plan #<?=$contact['Fid']?>?</p>
    <div class="yesno">
        <a href="DeleteDF.php?Fid=<?=$contact['Fid']?>&confirm=yes">Yes</a>
        <a href="DeleteDF.php?Fid=<?=$contact['Fid']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>

