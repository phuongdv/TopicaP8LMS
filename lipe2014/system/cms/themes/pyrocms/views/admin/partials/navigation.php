<?php
$uri=uri_string();
$arr=explode('/',$uri);
$str_2="";
if(count($arr)>=2){
	$str_2=$arr[1];
}
?>
<div class="bar_left">

	<div class="menu_list"> <!--Code for menu starts here-->

		<p class="menu_head"><span>Menu</span></p>
		<div class="menu_body" <?php if($str_2=='menu'){ echo 'style="display: block;"';} ?>>
			<div class="clearfix"></div>
			<ul class="click_mouse" style="display: block;">
				<li><div class="IconListMN"></div><?php echo anchor('/admin/menu','Danh sách');?></li>
				<li><div class="IconListMN"></div><?php echo anchor('/admin/menu/add','Thêm mới');?></li>
			</ul>
		</div>

		<p class="menu_head"><span>Game</span></p>
		<div class="menu_body" <?php if($str_2=='game'||$str_2=='game_category'){ echo 'style="display: block;"';} ?>>
			<div class="clearfix"></div>
			<ul class="block_drow">
				<li><div class="iconDS"></div><a  class="list_style" href="javascript:void(0)">Game</a>
					<ul class="click_mouse" style="display: block;">
						<li><div class="IconListMN"></div><?php echo anchor('/admin/game','Danh sách');?></li>
						<li><div class="IconListMN"></div><?php echo anchor('/admin/game/add','Đăng mới');?></li>
					</ul>
				</li>
				<li><div class="iconDS"></div><a  class="list_style" href="javascript:void(0)">Danh mục Game</a>
					<ul class="click_mouse" style="display: block;">
						<li><div class="IconListMN"></div><?php echo anchor('/admin/game_category','Danh sách');?></li>
						<li><div class="IconListMN"></div><?php echo anchor('/admin/game_category/add','Đăng mới');?></li>
					</ul>
				</li>
			</ul>
		</div>

		<p class="menu_head"><span>Bài viết</span></p>
		<div class="menu_body" <?php if($str_2=='article'||$str_2=='article_category'){ echo 'style="display: block;"';} ?>>
			<div class="clearfix"></div>
			<ul class="block_drow">
				<li><div class="iconDS"></div><a  class="list_style" href="javascript:void(0)">Bài viết</a>
					<ul class="click_mouse" style="display: block;">
						<li><div class="IconListMN"></div><?php echo anchor('/admin/article','Danh sách');?></li>
						<li><div class="IconListMN"></div><?php echo anchor('/admin/article/add','Đăng mới');?></li>
					</ul>
				</li>
				<li><div class="iconDS"></div><a  class="list_style" href="javascript:void(0)">Danh mục bài viết</a>
					<ul class="click_mouse" style="display: block;">
						<li><div class="IconListMN"></div><?php echo anchor('/admin/article_category','Danh sách');?></li>
						<li><div class="IconListMN"></div><?php echo anchor('/admin/article_category/add','Đăng mới');?></li>
					</ul>
				</li>
			</ul>
		</div>

		<p class="menu_head"><span>Khối nội dung tĩnh</span></p>
		<div class="menu_body" <?php if($str_2=='static_info'){ echo 'style="display: block;"';} ?>>
			<div class="clearfix"></div>
			<ul class="click_mouse" style="display: block;">
				<li><div class="IconListMN"></div><?php echo anchor('/admin/static_info','Danh sách');?></li>
				<li><div class="IconListMN"></div><?php echo anchor('/admin/static_info/add','Thêm mới');?></li>
				<li><div class="IconListMN"></div><?php echo anchor('/admin/static_info/edit/1','Footer');?></li>
			</ul>
		</div>
		<p class="menu_head"><span>Quản lý</span>
		<div class="menu_body" style="display:none;"><div class="clearfix"></div>

			<?php
			// Display the menu items.
			// We have already vetted them for permissions
			// in the Admin_Controller, so we can just
			// display them now.
			foreach ($menu_items as $key => $menu_item)
			{
				if (is_array($menu_item))
				{
					echo '<ul class="block_drow">';
					echo	'<li><div class="iconDS"></div>';
					echo	'<a href="'.current_url().'#" class="top-link">'.lang_label($key).'</a>';
					//echo	'<div class="menu_body"><div class="clearfix"></div>';
					echo	'<ul class="click_mouse" style="display: block;">';
					foreach ($menu_item as $lang_key => $uri)
					{
						echo '<li><div class="IconListMN"></div><a href="'.site_url($uri).'" class="">'.lang_label($lang_key).'</a></li>';
					}
					echo '</ul>';
					echo '</li>';
					echo '</ul>';
				}
				elseif (is_array($menu_item) and count($menu_item) == 1)
				{
					echo '<ul class="block_drow">';
					foreach ($menu_item as $lang_key => $uri)
					{
						echo '<li><div class="iconDS"></div><a href="'.site_url($menu_item).'">'.lang_label($lang_key).'</a></li>';
					}
					echo '</ul>';
				}
				elseif (is_string($menu_item))
				{
					echo '<ul class="block_drow">';
					echo '<li><div class="iconDS"></div><a href="'.site_url($menu_item).'">'.lang_label($key).'</a></li>';
					echo '</ul>';
				}
			}
			?>
		</div>
	</div>
</div>