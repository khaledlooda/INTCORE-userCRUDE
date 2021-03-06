<?php 
	include_once('./controllers/common.php');
	include_once('./components/head.php');
	include_once('./models/user.php');
	//Database::connect('intcore(hello-world)', 'root', '');
?>
	<div style="padding: 10px 0px 10px 0px; vertical-align: text-bottom;">
		<span style="font-size: 125%;">Users</span>
		<button class="button float-right edit_user" id="add">Add User</button>
	</div>

    <table class="table table-striped">
    	<thead>
	    	<tr>
	      		<th scope="col">ID</th>
	      		<th scope="col">Name</th>
	      		<th scope="col"></th>
	    	</tr>
	  	</thead>
	  	<tbody>
		  	<?php	
		  	$us=new User();
				$users = $us->all(safeGet('keywords'));
				//var_dump($users);
				foreach ($users as $u) {
				$user =new User();
				$user->get_by_id($u['id']);
			?>
    		<tr>
    			<td><?=$user->id?></td>
    			<td><?=$user->name?></td>
    			<td>
    				<button name="function" value="edit" class="button edit_user" id="<?=$user->id?>">Edit</button>&nbsp;
    				<button class="button delete_user" id="<?=$user->id?>">Delete</button>
				</td>
    		</tr>
    		<?php } ?>
    	</tbody>
    </table>

<?php include_once('./components/tail.php') ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.edit_user').click(function(event) {
			window.location.href = "edituser.php?id="+$(this).attr('id');
		});
	
		$('.delete_user').click(function(){
			var anchor = $(this);
			$.ajax({
				url: './controllers/User_controller.php',
				type: 'GET',
				dataType: 'json',
				data: {"id": anchor.attr('id'),"do":"delete" },

			})
			.done(function(reponse) {
				if(reponse.status==1) {
					anchor.closest('tr').fadeOut('slow', function() {
						$(this).remove();
					});
				}
			})
			.fail(function() {
				alert("Connection error.");
			})
		});
	});
</script>