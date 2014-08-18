<?php echo form_open(uri_string());?>
<fieldset id="user_password">
	<legend><?php echo lang('user:password_section') ?></legend>
	<ul>
		<li class="float-left spacer-right">
			<label for="password">Mật khẩu hiện tại</label><br/>
			<?php echo form_password('current_password', '', 'autocomplete="off"') ?>
		</li>
		<li class="float-left spacer-right">
			<label for="password">Mật khẩu mới</label><br/>
			<?php echo form_password('password', '', 'autocomplete="off"') ?>
		</li>
		<li class="float-left spacer-right">
			<label for="password">Nhập lại</label><br/>
			<?php echo form_password('confirm_password', '', 'autocomplete="off"') ?>
		</li>
		<li class="form_buttons">
			<input type="submit" value="Đồng ý" name="ok" />
			<input type="reset" value="Hủy bỏ" name="reset" />
		</li>
	</ul>
</fieldset>
<?php echo form_close();?>