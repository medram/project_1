	<div class='col-md-3'>
		<div class="list-group">
			<?php
			$src = get_profile_img($userdata['user_token']);
			?>
			<a class='list-group-item' style="background: <?php echo color(); ?>;border: 0px;" 
				href="<?php echo base_url($page_path); ?>/profile" >
				<div style='text-align: center;'>
					<img src="<?php echo $src; ?>" alt="<?php $userdata['username'] ?>" title='لتغيير الصورة أنقر هنــا لاذهاب إلى اعدادات حسابك.' class='profile-img pro-img img-circle' >
				</div>
			</a>
			<a href="<?php echo base_url($page_path); ?>/dashboard" class="list-group-item">
				<i class='fa fa-fw fa-lg fa-pie-chart'></i> إحصاءاتي 
			</a>
			<a href="<?php echo base_url($page_path); ?>/addlinks" class="list-group-item">
				<i class='fa fa-fw fa-lg fa-chain-broken'></i> إختصار روابط جديدة 
			</a>
			<a href="<?php echo base_url($page_path); ?>/mylinks" class="list-group-item">
				<i class='fa fa-fw fa-lg fa-link'></i> روابطي المختصرة 
			</a>
			<a href="<?php echo base_url($page_path); ?>/settings" class="list-group-item">
				<i class='fa fa-fw fa-lg fa-cogs'></i> إعدادات روابطي المختصرة 
			</a>
			<a href="<?php echo base_url($page_path); ?>/profile" class="list-group-item">
				<i class='fa fa-fw fa-lg fa-user'></i> الملف الشخصي <!--<span class="badge badge-success">100%</span>-->
			</a>
		</div>
		<!-- Ads -->
		<div style='text-align: center;'>
			<?php
			echo get_ad('',TRUE);
			?>
		</div>
	</div>