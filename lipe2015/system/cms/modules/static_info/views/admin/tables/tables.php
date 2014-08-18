<?php if ($rows) : ?>
Có : <strong><?php echo number_format($total_rows);?></strong> bản ghi.
<table>
	<thead>
		<tr>
			<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
			<th>ID</th>
			<th>Tên</th>
			<th>Trạng thái</th>
			<th>Sửa</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0;foreach ($rows as $row) : $i=1-$i;?>
			<tr class="row_<?php echo $i;?>">
				<td>
					<?php echo form_checkbox('action_to[]', $row->id); ?>
					 <?php echo form_hidden('arr_id[]',$row->id);?>
				</td>
				<td><?php echo $row->id; ?></td>
				<td><?php echo form_input('arr_name[]',$row->name); ?></td>
				<td><?php echo form_dropdown('arr_active[]',selectActive(),$row->active); ?></td>
				<td><?php echo anchor($index_uri.'/edit/' . $row->id,'<img src="'.IMAGE_ADMIN_PATH.'edit.png">', array('title'=>'Sửa')); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	 <tfoot>
		<tr>
			<td colspan="5">
				<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
			</td>
		</tr>
	</tfoot>
</table>
<?php else: ?>
	<div class="no_data">Không tồn tại bản ghi nào</div>
<?php endif; ?>   