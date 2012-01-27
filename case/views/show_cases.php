
<div style="display:none;">
<?php echo Kohana::lang('ui_main.title'); ?>
<?php echo Kohana::lang('ui_main.location'); ?>
<?php echo Kohana::lang('ui_main.date'); ?>
<?php echo Kohana::lang('ui_main.category'); ?>

<a class="more" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>

</div>
   

			<div class="table-holder">
	<table  class="table"
	
		<thead>
			<tr>
			
				<th># id</th>				
				<th># Title</th>
				<th># Description</th>
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
						echo "<td>".$case_id."</td>";
						echo "<td>".$case_title."</td>";
						echo "<td>".$case_desc."</td>";
						 
						echo "</tr>";
					}
				?>
		</tbody>
	</table>
 
		</div>
	 
	 
<br />
 
		
 <div style="clear:both;"></div>

