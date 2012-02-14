
<div style="display:none;">
<?php echo Kohana::lang('ui_main.title'); ?>
<?php echo Kohana::lang('ui_main.location'); ?>
<?php echo Kohana::lang('ui_main.date'); ?>
<?php echo Kohana::lang('ui_main.category'); ?>

<a class="more" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>

</div>
   
 
<div class="table-holder">
	<table class="table" style="align-left:10px">
	
		<thead>
			<tr>
			
		 <th><h5 style="color: #009200;">Case Title</h4></th>
	
		<th></th>
		
		 <th><h5 style="color: #009200;"> Description</h5></th>
			
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
						
						
						echo "<tr>";
						echo "<td><h5 style='color: #009900';><a href=\"".url::site()."case_view/openCase/".$case_id."\">".$case_title."</h5></td>";
						
						echo "<td class='col'></td>";
						echo "<td class='col'><h5 style='color: #0099DD';>".$case_desc."</h5></td>";
						 
						echo "</tr>";
					}
				?>
		</tbody>
	</table>
 
		</div>
	 
	 
<br />
 