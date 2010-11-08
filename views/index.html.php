<html>
	<head>
		<title>Cassandra Address Book</title>		
	</head>
	
	<body>
		<div class='container' style="width: 500px; margin: 0 auto; margin-top: 100px; background: #f0f0f0; padding: 10px; border: 5px solid #ccc;">
			
			<h1 style="color: #888; margin: 0; margin-bottom: 10px; padding:0">Cassandra Address Book</h1>
			
			<?php if ($this->getNotice('notice')): ?>
				<div style="background:lightYellow;padding:5px; margin-bottom: 10px;">
					<?php echo $this->getNotice('notice') ?>
				</div>
			<?php endif; ?>
			
			<fieldset style="width: 200px; float: left;">
				<legend>Add New Address</legend>
				<form action='index.php?perform=insert' method='post'>
					<label for='field_name'>Name</label>
					<br/><input type='text' name='name' id='field_name'/>
					<br/><label for='field_phone'>Phone</label>
					<br/><input type='text' name='phone' id='field_phone'/>
					<br/><br/><input type='submit' value='Add'/>
				</form>
			</fieldset>
			<div style="float:left; margin-left: 5px;">
				<?php foreach($this->get('addresses') as $address): ?>
					<b><?php echo $address->getName() ?></b> - <?php echo $address->getPhone() ?>
					<a href="index.php?perform=edit&id=<?php echo $address->toGUID() ?>">edit</a> . 
					<a onclick="return confirm('Do you really want to remove this?');" href='index.php?perform=remove&id=<?php echo $address->toGUID() ?>'>remove</a>
					<br/>
				<?php endforeach; ?>
			</div>
			<br clear='both'/>
		</div>
	</body>
</html>