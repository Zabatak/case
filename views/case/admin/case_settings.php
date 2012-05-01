<div class="bg">
	<h2>
		View Cases
	
	<?php
	$link = url::site()."admin/case_settings/edit/";
	?>
	 
	<?php
	echo "<a href=\"$link\">Add/Edit</a>";
	?>
	</h2>
	
	 
</div>


	<?php
	if ($form_action) {
	?>
		<!-- green-box -->
		<div class="green-box" id="submitStatus">
			<h3> <?php echo $form_action; ?> </h3>
		</div>
	<?php
	}
?>


 <div class="table-holder">
	<table  class="table"
	
		<thead>
			<tr>
			
				<th># id</th>				
				<th># Title</th>
				<th># Description</th>
				<th># Contact Person</th>
			</tr>
		</thead>
		<tfoot>		
		</tfoot>
		<tbody>
		
				<?php 
					foreach($cases as $case)
					{
						$case_id = $case->id;
						$case_title = $case->title;
						$case_desc	= $case->description;
						$case_person = $case->contact_person;
						
						echo "<tr>";
						echo "<td>".$case_id."</td>";
						echo "<td><a href=\"".url::site()."admin/case_settings/edit/".$case_id."\">".$case_title."</td>";
						echo "<td>".$case_desc."</td>";
						echo "<td>".$case_person."</td>";
						 
						echo "</tr>";
					}
				?>
		</tbody>
	</table>
</div>
	 