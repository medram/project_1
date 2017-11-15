<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class='fa fa-pencil'></i> Edit page
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit page
            </li>
        </ol>
    </div>
</div>
<div class='row'>
	<div class='col-lg-8'>
		<div class='msg'></div>
		<?php
		if (isset($pagedata['id']))
		{
		?>
		<form id='editPage' action='<?php echo base_url($page_path."/ajax"); ?>' method='post'>
			<div class='form-group'>
				<label>Title :</label>
				<input type='text' name='title' class='form-control'
				value="<?php if(isset($pagedata['title'])){ echo htmlentities($pagedata['title'],ENT_QUOTES); } ?>" >
			</div>
			<div class='form-group'>
				<label>Slug (page name):</label>
				<!--<input type='text' name='slug' class='form-control' placeholder='example'>-->
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon3"><b><?php echo base_url('p'); ?>/</b></span>
					<input type="text" name="slug" class="form-control" placeholder='page name' id="basic-url" aria-describedby="basic-addon3" 
					value="<?php if(isset($pagedata['slug'])){ echo $pagedata['slug']; } ?>"
					<?php if (isset($pagedata['uneditable']) && $pagedata['uneditable'] == 1){ echo "disabled"; } ?> >
				</div>
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
			<div class='form-group'>
				<label>Content :</label>
				<textarea name='content' class='form-control' rows='5'><?php if(isset($pagedata['content'])){ echo $pagedata['content']; } ?></textarea>
			</div>
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