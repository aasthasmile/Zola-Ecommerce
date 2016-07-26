<?php 
	require_once '../core/init.php';
	include 'includes/head.php'; 
 	include 'includes/navigation.php'; 
 	//get brands from database
 	 $sql = "SELECT * FROM brand order by brand";
 	 $results=$db->query($sql);
 	 $errors=array();

 	 //edit brand
 	 if(isset($_GET['edit']) && !empty($_GET['edit'])){
 	 	$edit_id= (int) $_GET['edit'];
 	 	$edit_id= santinize($edit_id);
 	 	$sql2 = "SELECT * FROM brand where id='$edit_id'";
 	 	$end_result=$db->query($sql2);
 	 	$eBrand=mysqli_fetch_assoc($end_result);
 	 }
 	 	
 	//delete brand
 	 if(isset($_GET['delete']) && !empty($_GET['delete'])){
 	 	$delete_id= (int) $_GET['delete'];
 	 	$delete_id= santinize($delete_id);
 	 	$sql = "DELETE FROM brand where id='$delete_id'";
 	 	$db->query($sql);
 	 	header('Location: brand.php');
 	 }

 	 //If add form is submitted
 	 if(isset($_POST['add_submit'])){
 	 	 $brand=santinize($_POST['brand']);

 	 	//check if brand is blank
 	 	if($_POST['brand']==''){
 	 		$errors[] .= 'You must enter a brand';
 	 	}

 	 	//check if brand exists in database
 	 	$sql = "SELECT * FROM brand WHERE brand= '$brand' ";
 	 	if(isset($_GET['edit'])){
 	 		$sql = "SELECT * FROM BRAND where brand='$brand' and id !='$edit_id'";
 	 	}

 	 	$result = $db->query($sql);
 	 	$count = mysqli_num_rows($result);
 	 	if ($count > 0 ){
 	 		$errors[] .='That brand already exists.Please choose another brand name..';
 	 	}
 	 	 	 	//display errors
 	 	if(!empty(($errors))){
 	 		echo display_errors($errors);
 	 	}
 	 	else{
 	 		//add brand to database
 	 		$sql = "INSERT into brand(brand) Values('$brand')";
 	 		if(isset($_GET['edit'])){
 	 			$sql = "UPDATE brand SET brand='$brand' WHERE id='$edit_id'";
 	 		}
 			$db->query($sql); 	
 			header('Location: brand.php');
 	 	}

 	 }

 ?>

<h2 class="text-center">Brands</h2>
<!--Brand form-->
<div class="text-center">
	<form class="form-inline" action="brand.php<?=((isset($_GET['edit']))?'?edit='.edit_id:''); ?>" method="post">
		<div class="form-group">
			
			<?php 
			$brand_value='';
			if(isset($_GET['edit'])) {
				$brand_value=$eBrand['brand'];
			}
			else{
				if(isset($_POST['brand'])) {
					$brand_value=santinize($_POST['brand']);
				}
			}	

		 ?>		
		
			<label for="brand"><?= ((isset($_GET['edit']))?'edit':'Add a'); ?> Brand</label>
			<input type="text" name="brand" id="brand" class="form-control" value="<?= $brand_value; ?>">
			<!-- cancel button -->
			<?php if(isset($_GET['edit'])): ?>
				<a href="brand.php" class="btn btn-default"> Cancel </a>
			<?php endif; ?>	
			<input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add a'); ?> Brand" class="btn btn-success">
				
		</div>
	</form>		
</div>
<hr>



<table class="table table-bordered table-striped table-auto table-condensed">
	<thead>
		<th></th><th> Brand</th><th></th>
	</thead>
	<tbody>
		<?php while($brand =mysqli_fetch_assoc($results)): ?>
		<tr>
			<Td><a href="brand.php?edit=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"> </span></a></td>
			<Td><?= $brand['brand']; ?> </td>
			<Td><a href="brand.php?delete=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"> </span></a></td>
			
			
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>


 <?php include 'includes/footer.php'; ?>