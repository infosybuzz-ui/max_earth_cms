
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Type</th>
			<th>Title</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				$k = 1;
				foreach($records as $rcd) {
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo $rcd['content_type'];?></td>
				<td><?php echo $rcd['content_title'];?></td>
				<td class="tooltip-demo">										
					<a href="<?php echo ADMIN_BASE_URL.'cms/contents/edit/'.EnCrypt($rcd['id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil text-navy"></i>
					</a>			
				</td>
			</tr>
		<?php 
				 $k++;
				}
				
			} else {
				echo '<tr>
						<td colspan="7" align="center">No Records found</td>
					 </tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>