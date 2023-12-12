<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    $conn = connectToDatabase();

    //get ids to enter
    $game_id = !empty($_POST['game_id']) ? $_POST['game_id'] : "";
    $library_id = !empty($_POST['library_id']) ? $_POST['library_id'] : "";
    $username = "";

	if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];
		$query = "SELECT COUNT(*) FROM librarylist WHERE library_id=? AND game_id = ?";
		$result = $conn->prepare($query);
		$result->bind_param('ss',$library_id, $game_id);
		$result->execute();
		$result->bind_result($count);
        
        //check if it exists in library
	    if($result->fetch() && $count == 0){
            //add to library table
            $query = "INSERT INTO librarylist (library_id, game_id) VALUES (?, ?)";
            $values = [$library_id, $game_id];
        
            $result->close();
            $res = $conn->prepare($query);
            $res->bind_param('ss', ...$values);
            $res->execute();
            $message = "success";
            header("Location: gamedetails.php?game_id=$game_id&message=" . urlencode($message));
            exit();
        }else{
            $message = "exists";
            header("Location: gamedetails.php?game_id=$game_id&message=" . urlencode($message));
            exit();
        }
	}else{
        $_SESSION['callback_url'] = 'addtomylibrary.php';
        header('Location: ' . 'login.php');
        exit(); 
    }


?>
</div>