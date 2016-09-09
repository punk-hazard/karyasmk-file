<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
             <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>  </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
           <div class="form-group">
                <label class="col-sm-2 control-label" for="install-table"><?php echo $text_install_table; ?></label>
                <div class="col-sm-10">
                
                <?php if (!$settings['installed']) { ?>
                  <a href="<?php echo $settings['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i></a>
                  <?php } else { ?>
                  <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $settings['uninstall']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>
                  <?php } ?>
                </div>
              </div>
    <fieldset>
        <legend><?php echo $text_options; ?></legend>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="jne_handling_fee"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_handling_fee; ?>"><?php echo $entry_handling_fee; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="jne_handling_fee" value="<?php echo $jne_handling_fee; ?>" id="jne_handling_fee" size="10" style="width: 120px;" class="form-control" />
          
                </div>
              </div>
              
               <div class="form-group required">
                <label class="col-sm-2 control-label" for="jne_handling_fee"><?php echo $entry_handling_fee_mode; ?></label>
                <div class="col-sm-10">
                <?php if ($jne_handling_fee_mode == "flat") { ?>
                  <input checked="checked" type="radio" name="jne_handling_fee_mode"  value="flat" id="jne_handling_fee_mode" /> <?php echo $text_total_mode; ?>
           <div style="clear: both; width: 100%; height: 1px;"></div>  
                 <input type="radio" name="jne_handling_fee_mode"  value="perweight" id="jne_handling_fee_mode" /> <?php echo $text_weight_mode; ?>
                   <?php } else { ?>   
                     <input type="radio" name="jne_handling_fee_mode"  value="flat" id="jne_handling_fee_mode" /> <?php echo $text_total_mode; ?>
           <div style="clear: both; width: 100%; height: 1px;"></div>  
                 <input checked="checked" type="radio" name="jne_handling_fee_mode"  value="perweight" id="jne_handling_fee_mode" /> <?php echo $text_weight_mode; ?>
                
                     <?php } ?>                           
                </div>
              </div>
         <div class="form-group required">
                <label class="col-sm-2 control-label" for="jne_wooden_package"><?php echo $entry_wooden_package; ?></label>
                <div class="col-sm-10">
                    <?php if($jne_wooden_package) { ?> 
                    <input type="radio" name="jne_wooden_package" checked="checked" value="1" /> <?php echo $text_yes; ?>
                    <input type="radio" name="jne_wooden_package" value="0" /> <?php echo $text_no; ?>
                        <?php } else { ?>
                    <input type="radio" name="jne_wooden_package" value="1" /> <?php echo $text_yes; ?>
                    <input type="radio" name="jne_wooden_package" checked="checked" value="0" /> <?php echo $text_no; ?>
                    <?php } ?>
                    </div>
              </div>
        
        </fieldset>  
    <fieldset>
        <legend><?php echo $text_shipping_basis; ?></legend>
<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-province"><?php echo $entry_province; ?></label>
            <div class="col-sm-10">
              <select name="jne_province_id" id="input-province" class="form-control">
                  <option><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $jne_province_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <select name="jne_city_id" id="input-city" class="form-control">
              </select>
            </div>
          </div>
        </fieldset>
          </form> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--      
$('select[name=\'jne_province_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=sale/order/city&token=<?php echo $token; ?>&province_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'jne_province_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
            var jne_city_id = '<?php echo $jne_city_id; ?>';
            
             $.map(json, function(item) {
			     html = '<option value=""><?php echo $text_select; ?></option>';
                $.each(item['results'], function( key, val ) {
                if(val['type'] == "Kabupaten")
                  var kab = 'Kab.';  
                else 
                    kab = val['type'];

                if(val['city_id'] == jne_city_id) {
                    html+="<option value='" + val['city_id'] + "' selected='selected'>" +  kab + ' ' + val['city_name'] + "</option>";
                } else {
                    html+="<option value='" + val['city_id'] + "'>" + kab + ' ' + val['city_name'] + "</option>";
                 }
                });
               
                $('select[name=\'jne_city_id\']').html(html);
               
                $('select[name=\'jne_city_id\']').trigger('change');
                 
             });
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'jne_province_id\']').trigger('change');
//--></script>
<?php echo $footer; ?>