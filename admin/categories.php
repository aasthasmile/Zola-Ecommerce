<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

 $sql = "SELECT * FROM categories where parent= 0";
 $result=$db->query($sql);
 $errors=array();

//edit category
 	 if(isset($_GET['edit']) && !empty($_GET['edit'])){
 	 	$edit_id= (int) $_GET['edit'];
 	 	$edit_id= santinize($edit_id);
 	 	$sql2 = "SELECT * FROM categories where id='$edit_id'";
 	 	$end_result=$db->query($sql2);
 	 	$category=mysqli_fetch_assoc($end_result);
 	 }
//delete Category
 	 if(isset($_GET['delete']) && !empty($_GET['delete'])){
 	 	$delete_id= (int) $_GET['delete'];
 	 	$delete_id= santinize($delete_id);
 	 	$sql="SELECT * from categories where id='$delete_id'";
 	 	$result =$db->query($sql);
 	 	$category =mysqli_fetch_assoc($result);
 	 	if($category['parent'] == 0){
 	 		$sql="DELETE FROM categories where id='$delete_id'";
 	 		$db->query($sql);
 	 	}
 	 	$dsql = "DELETE FROM categories where id='$delete_id'";
 	 	$db->query($dsql);
 	 	header('Location: categories.php');
 	 }




//Process Form

if(isset($_POST) && !empty($_POST)){
 	 	$parent=santinize($_POST['parent']);
 	 	$category=santinize($_POST['category']);
 	 	//if category is blank
 	 	if( $category ==''){
 	 			$errors[] .= 'Category cant be blank';
 	 	}


 	 	//check if brand exists in database
 	 	$sqlform = "SELECT * FROM categories WHERE category= '$category' and parent='$parent' ";
 	 	$fresult=$db->query($sqlform);
 	 	$count=mysqli_num_rows($fresult);
 	 	if($count>0) {
 	 		$errors[] .='That '.$category.' already exists.Please choose another category name..';
 	 	}

 	 	//display errorsor update database
 	 	if(!empty(($errors))){
 	 		$display=display_errors($errors); ?>
 	 		<script >
 	 			jQuery('document').ready(function(){
 	 				jQuery('#errors').html('<?= $display; ?>');
 	 			});
 	 		</script>
 	 	
 	 	<?php } else{
 	 		//add category to database
 	 		$updatesql ="INSERT into categories (category,parent) values ('$category','$parent')";
 	 		$db->query($updatesql);
 	 		header('Location:categories.php');
 	 	
 	 	}

 	 }	
 	 	$category_value ='';
 	 	if(isset($_GET['edit'])){
 	 		$category_value= $category['category'];
 	
?>

<h2 class="text-center">Categories</h2><hr>
<!--Categories form-->
<div class="row">

	<div class="col-md-6">
	<table class="table table-bordered ">
		<thead>
			<th>Category</th><th> Parent</th><th></th>
		</thead>
		<tbody>
			<?php while($parent = mysqli_fetch_assoc($result)): 
					$parent_id=(int) $parent['id'];
					$sql2 ="SELECT * FROM categories where parent='$parent_id'";
					$cresult= $db->query($sql2);
			?>
			<tr class="bg-primary">
				<td><?= $parent['category']; ?></td>
				<td>Parent</td>
				<td>
					<a href="categories.php?edit=<?= $parent['id']; ?>" class="btn btn-md btn-default"><span class="glyphicon glyphicon-pencil"> </span></a>
					<a href="categories.php?delete=<?= $parent['id']; ?>" class="btn btn-md btn-default"><span class="glyphicon glyphicon-remove-sign"> </span></a>
				</td>
			</tr>
			<?php while($child=mysqli_fetch_assoc($cresult)): ?>
			<tr class="bg-info">
				<td><?= $child['category']; ?></td>
				<td><?= $parent['category']; ?></td>
				<td>
					<a href="categories.php?edit=<?= $child['id']; ?>" class="btn btn-md btn-default"><span class="glyphicon glyphicon-pencil"> </span></a>
					<a href="categories.php?delete=<?= $child['id']; ?>" class="btn btn-md btn-default"><span class="glyphicon glyphicon-remove-sign"> </span></a>
				</td>
			</tr>

			<?php endwhile; ?>	
		<?php endwhile; ?>
		</tbody>
	</table>

	</div>

	<div class="col-md-6">
				
		
   <form class="form" action="categories.php<?=(isset($_GET['edit'])?'?edit='.$edit_id:''); ?>" method="post">
			<legend> <?=(isset($_GET['edit'])?'Edit ':'Add a '); ?>Category </legend>
		<div id="errors"></div>
		<div class="form-group">
			<label for="parent">Parent</label>
			<select class="form-control" name="parent" id="parent">
				<option value="0">Parent </option>
				<?php 
				$sql = "SELECT * FROM categories where parent= 0";
 				$rresult=$db->query($sql);
 				?>

				<?php while($parent =mysqli_fetch_assoc($rresult)): ?>
					<option value="<?= $parent['id']; ?>"><?= $parent['category']; ?></option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="category">Category</label>
			<input type="text" class="form-control" id="category" name="category" > 
			<!-- value="<?=$category_value;?>" > -->

		</div>
		
		<div class="form-group">
			<input type="submit" value="Add Category" class="btn btn-success">
		</div>
		

		</form> 
		
	</div>
</div>

 <?php include 'includes/footer.php'; ?>