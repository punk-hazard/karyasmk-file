<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-free" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-free" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="jneyes_total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>        
				<div class="col-sm-10">            
            <input type="text" name="jneyes_total" id="jneyes_total" value="<?php echo $jneyes_total; ?>" class="form-control" />
        		</div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="jneyes_status"><?php echo $entry_status; ?></span></label>        
				<div class="col-sm-10">            
           <select name="jneyes_status" id="jneyes_status" class="form-control">
                <?php if ($jneyes_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
        		</div>
        </div>
       <div class="form-group">
            <label class="col-sm-2 control-label" for="jneyes_tax_class_id"><?php echo $entry_tax_class; ?></label>        
				<div class="col-sm-10">            
 <select name="jneyes_tax_class_id" id="jneyes_tax_class_id" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $jneyes_tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
        		</div>
        </div>
         <div class="form-group">
            <label class="col-sm-2 control-label" for="jneyes_geo_zone_id"><?php echo $entry_geo_zone; ?></label>        
				<div class="col-sm-10">            
<select name="jneyes_geo_zone_id" id="jneyes_geo_zone_id" class="form-control">
                  <option value="0"><?php echo $text_all_zones; ?></option>
                  <?php foreach ($geo_zones as $geo_zone) { ?>
                  <?php if ($geo_zone['geo_zone_id'] == $jneyes_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
        		</div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="jneyes_sort_order"><?php echo $entry_sort_order; ?></label>        
				<div class="col-sm-10">            
            <input type="text" name="jneyes_sort_order" id="jneyes_sort_order" class="form-control"  value="<?php echo $jneyes_sort_order; ?>" />
        		</div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="category"><span data-toggle="tooltip" title="<?php echo $help_product_filtered; ?>"><?php echo $entry_product_filtered; ?></span></label>        
				<div class="col-sm-10">            
  				<select id="category" style="margin-bottom: 5px;" onchange="getProducts();">
										<?php foreach ($categories as $category) { ?>
										<option value="<?php echo (int)$category['category_id']; ?>"><?php echo $category['name']; ?></option>
										<?php } ?>
							</select>
							<table>
									<tr>
								<td style="padding: 0;">
								<select multiple="multiple" id="product" size="10" style="width:350px; height:300px; "></select></td>
								<td style="vertical-align: middle;"><input type="button" value="--&gt;" onclick="addFiltered();" />
								<br /><input type="button" value="&lt;--" onclick="removeFiltered();" /></td>
								<td style="padding: 0;">
								<select multiple="multiple" id="filtered" size="10" style="width:350px; height:300px; "></select></td>
							</tr>
						</table>
							<div id="product_filtered">
							<?php foreach ($product_filtered as $product_filtered) { ?>
							<input type="hidden" name="product_filtered[]" value="<?php echo $product_filtered['product_id']; ?>" />
								<?php } ?>
								</div>
        		</div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function addFiltered() {
	$('#product :selected').each(function() {
		$(this).remove();
		$('#filtered option[value=\'' + $(this).attr('value') + '\']').remove();
		$('#filtered').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		$('#product_filtered input[value=\'' + $(this).attr('value') + '\']').remove();
		$('#product_filtered').append('<input type="hidden" name="product_filtered[]" value="' + $(this).attr('value') + '" />');
	});
}

function removeFiltered() {
	$('#filtered :selected').each(function() {
		$(this).remove();
		$('#product_filtered input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getProducts() {

	$('#product option').remove();
	<?php if (isset($this->request->get['shipping_code'])) {?>
		var shipping_code = '<?php echo $this->request->get['shipping_code'] ?>';
	<?php } else { ?>
		var shipping_code = '';
	<?php } ?>
											
	$.ajax({
		url: 'index.php?route=shipping/jneyes/category&token=<?php echo $token; ?>&category_id=' + $('#category').val(),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
				if (data[i]['shipping_code'] == shipping_code) { continue; }
					$('#product').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
				}
			}
		});
	}
						
function getFiltered() {
	$('#filtered option').remove();
	$.ajax({
		url: 'index.php?route=shipping/jneyes/filtered&token=<?php echo $token; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#product_filtered input'),
		success: function(data) {
			$('#product_filtered input').remove();
			for (i = 0; i < data.length; i++) {
				$('#filtered').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' (' + data[i]['model'] + ') </option>');
						
				$('#product_filtered').append('<input type="hidden" name="product_filtered[]" value="' + data[i]['product_id'] + '" />');
			}
		}
	});
}

getProducts();
getFiltered();
//--></script>
<?php echo $footer; ?> 