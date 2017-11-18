<div class='container'>
	<div class='row'>
		<?php
		echo $sidebar;
		?>
		<div class='col-md-9'>
			<div class='row'>
				<div id='title' class='col-md-7'>
					<h1><i class="fa fa-fw fa-link"></i> <?php echo $title; ?></h1>
				</div>
				<div class='col-md-5'>
					<br>
					<div id='text-left'>
						<form action='<?php echo base_url($page_path); ?>/mylinks/p/1' method='get'>
							<div class="input-group">
								<input type="text" class="form-control" name='s' placeholder="ابحث عن رابط ..." 
									value='<?php if (isset($string)){echo htmlentities($string,ENT_QUOTES);}?>' >
								<span class="input-group-btn">
									<button class="btn btn-warning"><i class='fa fa-search'></i> بحث</button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
			<hr>
			<div class='row'>
				<div class='col-md-12'>
				<?php
				if ($no_result_of_search == 1 && $searchType == 'search')
				{
					echo "<div style='text-align: center;'><span>لا توجد نتائج !</span></div>";
				}
				else if ($total_items == 0)
				{
					echo "
						<div style='text-align: center;'><span>لا توجد روابط حاليا</span><br><br>
							<a href='".base_url($page_path)."/addlinks' class='btn btn-primary'>إختصر أول رابط لك من هنا</a>
						</div>";
				}
				else
				{
					foreach ($links->result_array() as $row) {	
				?>
							<div dir='rtl' class='row boxLink'>
								<div class='col-xs-12'>
									<a href='<?php echo base_url('go')."/".$row['slug']; ?>' target='_blank'>
										<h4 class='h4'>
											<i class='fa fa-link fa-fw'></i> <?php echo $row['title']; ?>
										</h4>
									</a>
								</div>
								<div class='col-xs-12'>
									<div class='info'>
										<ul>
											<li title='تاريخ إنشاء الرابط'>
												<i class='fa fa-clock-o'></i> <?php echo date(get_config_item("time_format"),$row['created']);?>
											</li>
											<li title='عدد المشاهدات'>
												<i class='fa fa-eye fa-fw'></i> <?php echo $row['views'];?>
											</li>
											<?php
											if ($row['status'] == 1)
											{
												echo "<li><span class='badge badge-success' title='الرابط شغال و قابل للإستخدام'>نشط</span></li>";	
											}
											else
											{
												echo "<li><span class='badge badge-danger' title='تم حظر الرابط للنتهاكه شروط الإستخدام'>محظور</span></li>";
											}
											?>
											<div class='clear'></div>
										</ul>
									</div>
								</div>
								<div class='col-xs-12'>
									<div class='col-md-6'>
										<div class='form-group'>
											<span>الرابط المختصر :</span>
											<div class='input-group input-group-sm'>
												<span class='input-group-btn'>
													<button class='btn btn-primary copy' type='button'>Copy</button>
												</span>
												<input class='form-control' dir='ltr' type='text' value='<?php echo get_domains($row['domain'])."go/".$row['slug'];?>' >
											</div>
										</div>
									</div>
									<div class='col-md-6'>
										<span>الرابط الأصلي :</span>
										<div class='input-group input-group-sm'>
											<span class='input-group-btn'>
												<button class='btn btn-primary copy' type='button'>Copy</button>
											</span>
											<input class='form-control' dir='ltr' type='text'value='<?php echo htmlentities(decode($row['url']),ENT_QUOTES);?>' >
										</div>
										<br>
									</div>
								</div>
								<div class='action'>
									<!--<span class='btn btn-primary'><i class='fa fa-pencil'></i></span>-->
									<span class='btn btn-danger btn-sm deleteLink' id='<?php echo $row['id'];?>' ><i class='fa fa-trash'></i><span>
								</div>
							</div>
					<?php
					} // end foreach
					?>
					<div class='row'>
						<div class='col-md-10'>
							<div>
								<?php
								// $all_items,$num_per_page,$url
								echo pagination($total_items,$num_per_page,base_url($page_path.'/mylinks/p/'),'ar');
								?>
							</div>
						</div>
						<div class='col-md-2' dir='ltr'>
							<br><span dir='rtl'><i>(<?php echo $total_items; ?>) رابطا</i></span><br>
							<b dir='ltr'><?php echo $p."/".$all_pages." صفحة"; ?></b>
						</div>
					</div>
				<?php
				} // end else
				?>
			</div>
			</div>
		</div>
	</div>
</div>
