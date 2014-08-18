<ul>
	<li class="separator">
		<a class="iconHomed" href="/" title="Khogamevn.mobi - Wapsite hay nhất cho điện thoại di động">
			<img src="<?php echo IMAGE_PATH;?>home.png" alt="home" class="icon">                    </a>
	</li>
	<?php
	if(!empty($rows)){
		foreach($rows as $menu){
			?>
			<li class="separator"><a href="<?php echo $menu->link;?>" <?php if(strpos($menu->link,'http://')!==false){ echo 'target="_blank"';} ?> ><?php echo $menu->name;?></a></li>
		<?php
		}
	}
	?>
	<?php
	if($this->current_user){
		?>
		<li class="separator">
			<a href="/users" title="Thông tin tài khoản">Thông tin tài khoản</a>
		</li>
	<?php
	}else{
		?>
		<li class="separator">
			<a href="/users/login" title="Đăng nhập">Đăng nhập</a>
		</li>
		<li class="separator">
			<a href="/users/register" title="Đăng kí">Đăng kí</a>
		</li>
	<?php }?>
</ul>