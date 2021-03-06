<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-pencil'></i> Edit page</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
        		<div class='col-lg-8'>
        			<div class='msg'></div>
        			<?php
        			if (isset($pagedata['id']))
        			{
        			?>
        			<form id='editPage' action='<?php echo base_url($page_path."/ajax"); ?>' method='post'>
        				<div class='form-group'>
        					<label>Page name :</label>
        					<input type='text' name='title' class='form-control'
        					value="<?php if(isset($pagedata['title'])){ echo htmlentities($pagedata['title'],ENT_QUOTES); } ?>" >
        				</div>
        				<div class='form-group'>
        					<label>Slug:</label>
        					<!--<input type='text' name='slug' class='form-control' placeholder='example'>-->
        					<div class="input-group">
        						<span class="input-group-addon" id="basic-addon3"><b><?php echo base_url('p'); ?>/</b></span>
        						<input type="text" name="slug" class="form-control" placeholder='page name' id="basic-url" aria-describedby="basic-addon3" 
        						value="<?php if(isset($pagedata['slug'])){ echo $pagedata['slug']; } ?>"
        						<?php if (isset($pagedata['uneditable']) && $pagedata['uneditable'] == 1){ echo "disabled"; } ?> >
        					</div>
        				</div>
        				<div class='form-group'>
        					<label>this page will be availabel for : </label><br>
        					<small><i>choose the language.</i></small>
        					<select name='lang-id' class='form-control'>
        						<option value='0'>---------- All languages ----------</option>
        						<?php
        						$selected = '';
        						foreach(config_item('languages') as $k => $row)
        						{
        							$selected = ($row['id'] == $pagedata['lang_id'])? 'selected' : '' ;
        							echo "<option value='".($k+1)."' ".$selected.">".ucfirst($row['name'])."</option>";
        						}
        						?>
        					</select>
        				</div>
        				<div class='form-group'>
        					<label>Keywords :</label><br>
        					<small><i>put this carracter "<b>,</b>" between two keywords.</i></small>
        					<input type='text' name='keywords' class='form-control' 
        					value="<?php if(isset($pagedata['keywords'])){ echo htmlentities($pagedata['keywords'],ENT_QUOTES); } ?>">
        				</div>
        				<div class='form-group'>
        					<label>Description :</label>
        					<textarea name='desc' class='form-control' rows='5'><?php if(isset($pagedata['description'])){ echo $pagedata['description']; } ?></textarea>
        				</div>
        				<div class='form-group'>
        					<label>Published :</label>
        					<select name='published' class='form-control'>
        						<option value='1' 
        						<?php if (isset($pagedata['published']) && $pagedata['published'] == 1){ echo "selected"; } ?> >Yes</option>
        						<option value='0' <?php if (isset($pagedata['published']) && $pagedata['published'] == 0){ echo "selected"; } ?> >No</option>
        					</select>
        				</div>
        				<div class='form-group'>
        					<label>Show on the header (navbar) :</label>
        					<select name='header' class='form-control'>
        						<option value='1' <?php if (isset($pagedata['show_header']) && $pagedata['show_header'] == 1){ echo "selected"; } ?> >Yes</option>
        						<option value='0' <?php if (isset($pagedata['show_header']) && $pagedata['show_header'] == 0){ echo "selected"; } ?> >No</option>
        					</select>
        				</div>
        				<div class='form-group'>
        					<label>Show on the footer :</label>
        					<select name='footer' class='form-control'>
        						<option value='1' <?php if (isset($pagedata['show_footer']) && $pagedata['show_footer'] == 1){ echo "selected"; } ?> >Yes</option>
        						<option value='0' <?php if (isset($pagedata['show_footer']) && $pagedata['show_footer'] == 0){ echo "selected"; } ?> >No</option>
        					</select>
        				</div>
        				<?php
        				if ($pagedata['slug'] != 'contact') // some privite pages
        				{
        				?>
        				<!-- <div class='form-group'>
        					<label>Content :</label>
        					<textarea name='content' class='form-control' rows='5'><?php if(isset($pagedata['content'])){ echo $pagedata['content']; } ?></textarea>
        				</div> -->
                        
                        <div> <!-- start editor -->
                            <textarea name='content' id="some-textarea" placeholder="Enter the content here ..." style="width: 100%; height: 480px; padding: 10px;"><?php if(isset($pagedata['content'])){ echo $pagedata['content']; } ?></textarea>
                        </div> <!-- end editor -->

        				<?php
        				}
        				?>
        				<div class='form-group'>
        					<input type='hidden' name='id' value='<?php echo $pagedata['id']; ?>' >
        					<input type='hidden' name='edit-page' value='yes' >
        					<button name='edit_page' class='btn btn-primary'><i class='fa fa-pencil'></i> Save the page</button>
        				</div>
        			</form>
        			<?php
        			} // end if 
        			?>
        		</div>
        	</div>
        </div>
	</div>
</section>

