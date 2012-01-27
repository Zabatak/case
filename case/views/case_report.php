<div class="action-taken clearingfix"  style="border-width: 2px; border-style: dashed; border-color: #ff9900; ">
  
	
	<?php if ($case_name) { ?>
		
		<div id="action-taken-badge">
		Linked to case 
		</div>
		<div id="case-desc">
		<strong> Name: </strong><?php echo $case_name->title; ?>
		</div>
	<?php }; ?>
</div>