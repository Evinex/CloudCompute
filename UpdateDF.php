<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['Fid'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Fid = isset($_POST['Fid']) ? $_POST['Fid'] : NULL;
        $Strlocation = isset($_POST['Strlocation']) ? $_POST['Strlocation'] : '';
        $Destination = isset($_POST['Destination']) ? $_POST['Destination'] : '';
        $Depart = isset($_POST['Depart']) ? $_POST['Depart'] : date('Y-m-d');
        $Back = isset($_POST['Back']) ? $_POST['Back'] : date('Y-m-d');
        $Way = isset($_POST['Way']) ? $_POST['Way'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE flight SET Strlocation = ?, Destination = ?, Depart = ?, Back = ?, Way = ? WHERE Fid = ?');
        $stmt->execute([$Strlocation, $Destination, $Depart, $Back, $Way, $_GET['Fid']]);
        $msg = 'Updated Successfully! Returning to Flight Plan Page...'; header( "refresh:3;url=DisplayFlight.php" );
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM flight WHERE Fid = ?');
    $stmt->execute([$_GET['Fid']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Flight Plan doesn\'t exist with that ID!');
    }
} else {
    exit('No Flight ID specified!');
}
?>

<?=template_header('Air Asia')?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Air Asia</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="css/DisplayFlight.css" rel="stylesheet" type="text/css">
</head>

<div class="content update">
    <h2>Update Contact #<?=$contact['Fid']?></h2>
    <form action="UpdateDF.php?Fid=<?=$contact['Fid']?>" method="post">
        <label for="Fid">FID</label>
        <label for="strlocation">Flight Starting Location</label>
        <input type="text" name="Fid" placeholder="1" value="<?=$contact['Fid']?>" id="Fid" disabled="disabled"> 
        <select style="margin-right: 0px;width: 400px;height: 47px;padding: 0px 120px;border: 1px solid #cccccc;" name="Strlocation" placeholder="Malaysia" value="<?=$contact['Strlocation']?>" id="Strlocation">
                                                    <option value="">Select a location...</option>                           
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="India">India</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Korea">Korea</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Malaysia">Malaysia</option>
        </select>
        <label for="destination">Destination</label>
        <label for="Departure">Departure Time</label>
        <select style="margin-right: 25px;width: 400px;height: 47px;padding: 0px 120px;border: 1px solid #cccccc;" name="Destination" placeholder="Malaysia" value="<?=$contact['Destination']?>" id="Destination">
                                                    <option value="">Select a location...</option>                                        
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="India">India</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Korea">Korea</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Malaysia">Malaysia</option>
        </select>
        <input type="date" name="Depart" value="<?=date('Y-m-d', strtotime($contact['Depart']))?>" id="Depart">
        <label for="title">Returning Date</label>
        <label for="way">Type/Way</label>
        <input type="date" name="Return" value="<?=date('Y-m-d', strtotime($contact['Back']))?>" id="Back">
        <select style="margin-right: 0px;width: 400px;height: 47px;padding: 0px 120px;border: 1px solid #cccccc;" name="Way" value="<?=$contact['Way']?>" id="Way">
                                  <option value="Round">Round</option>
                                  <option value="One-Way">One-Way</option>
        </select>
       
        <input type="submit" value="Update"> 
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>