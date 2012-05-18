<?php

	// Load TinyMCE
	 
		echo html::script('media/js/tinymce/tiny_mce', true);
	 
	?>
	
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
	<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'caseForm', 'name' => 'caseForm')); ?>
		<input type="hidden" name="save" id="save" value="">
		<!-- report-form -->
		<div class="report-form">
			<?php
			if ($form_error) {
			?>
				<!-- red-box -->
				<div class="red-box">
					<h3><?php echo Kohana::lang('ui_main.error');?></h3>
					<ul>
					<?php
					foreach ($errors as $error_item => $error_description)
					{
						print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
					}
					?>
					</ul>
				</div>
			<?php
			}

			if ($form_saved) {
			?>
				<!-- green-box -->
				<div class="green-box">
					<h3><?php echo Kohana::lang('ui_main.report_saved');?></h3>
				</div>
			<?php
			}
			?>
			<div class="head">
				<h3><?php echo $id ? "Edit Case" : "New Case"; ?></h3>
				<div class="btns" style="float:right;">
					<ul>
						<li><a href="#" class="btn_save"><?php echo strtoupper("Save Case");?></a></li>
						<li><a href="#" class="btn_save_close"><?php echo strtoupper("Save and Close");?></a></li>
						<?php 
						if($id)
						{
                                                     
						echo "<li><a href=\"". url::site()."admin/case_settings/delete/".$id ."\" class=\"btn_delete btns_red\">".strtoupper("Delete This Case")."</a></li>";
						}
						?>
						<li><a href="<?php echo url::base().'admin/case_settings/';?>" class="btns_red">
						<?php echo strtoupper(Kohana::lang('ui_main.cancel'));?></a>&nbsp;&nbsp;&nbsp;</li>
					</ul>
				</div>
			</div>
			<!-- f-col -->
			<div>

				
				<div class="row">
					<h4>Case Title :</h4>
					<?php print form::input('title', $form['title'], ' class="text title"'); ?>
				</div>
				<div class="row">
					<h4>Case Description :<span></span></h4>
					<?php print form::textarea('description', $form['description'], ' rows="17" cols="80" style="width:800px; height:300px;"') ?>
				</div>
				<div class="row">
					<h4>Contact Person :<span></span></h4>
					<?php print form::input('contact_person', $form['contact_person'],  ' class="text title"'); ?>
				</div>
				<div class="row">
					<h4>Contact Person Phone :<span></span></h4>
					<?php print form::input('contact_person_phone', $form['contact_person_phone'],  ' class="text title"'); ?>
				</div>
				
			</div>
			<div class="row">
				<h4>Incidents linked to that case = <?php print count($incidents);?></h4> 
				<table class="table" style="width:80%">
					<thead>
						<tr>
						<th>id </th>
						<th>Title </th>
						<th>Description</th>
						</tr>
						
					</thead>
				<?php
					  
					
					 foreach($incidents as $incident)
					{
						
						$role_style = "style=\"background:#eee; color:#888;\"";
						echo "<tr>";
						echo "<td><span style=\"font-size:15;align:center\">";
						echo"".$incident->id;
						echo "&nbsp;&nbsp;&nbsp;";
						echo "<td>"; 
						echo "<a href=\"".url::base()."admin/reports/edit/".$incident->id."\">".$incident->incident_title. "</a>";
						echo "</td>";
						
						echo "<td>";
						echo"".$incident->incident_description;
						
						echo "&nbsp;&nbsp;&nbsp;";
						
						
						echo "</td>";
						echo "</tr>";
						
					}
					
					
				?>
				</table>
				<br/>
			</div>
			 
			<hr/>
			
			
			
			<div class="btns">
				<ul>
					<li><a href="#" class="btn_save"><?php echo strtoupper("Save Case");?></a></li>
					<li><a href="#" class="btn_save_close"><?php echo strtoupper("Save and Close");?></a></li>
					<?php 
					if($id)
					{
						echo "<li><a href=\"#\" class=\"btn_delete btns_red\">".strtoupper("Delete This Case")."</a></li>";
					}
					?>
					<li><a href="<?php echo url::site().'admin/case_settings/';?>" class="btns_red"><?php echo strtoupper(Kohana::lang('ui_main.cancel'));?></a></li>
				</ul>
			</div>						
		</div>
	<?php print form::close(); ?>
	
	<?php
		if($id)
		{
			// Hidden Form to Perform the Delete function
			print form::open(url::site().'admin/case_settings', array('id' => 'reportMain', 'name' => 'reportMain'));
			$array=array('action'=>'d','group_id[]'=>$id);
			print form::hidden($array);
			print form::close();
		}
	?>
</div>
