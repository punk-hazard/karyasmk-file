<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-shipping" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $heading_title; ?> <i class="fa fa-caret-down"></i></a></h4>
  </div>
  <div id="collapse-shipping" class="panel-collapse collapse">
    <div class="panel-body">
      <p><?php echo $text_shipping; ?></p>
      <div class="form-horizontal">
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
          <div class="col-sm-10">
            <select name="country_id" id="input-country" class="form-control">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
          <div class="col-sm-10">
            <select name="zone_id" id="input-zone" class="form-control">
            </select>
          </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
          <div class="col-sm-10">
            <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
          </div>
        </div>
        <button type="button" id="button-quote" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_quote; ?></button>
      </div>
      <script type="text/javascript"><!--
$('#button-quote').on('click', function() {
	$.ajax({
		url: 'index.php?route=total/shipping/quote',
		type: 'post',
				
		data: 'sub_district_id=' + $('select[name=\'sub_district_id\']').val() + '&country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=0',
			
		dataType: 'json',
		beforeSend: function() {
			$('#button-quote').button('loading');
		},
		complete: function() {
			$('#button-quote').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				if (json['error']['warning']) {
					$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}

				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<div class="text-danger">' + json['error']['country'] + '</div>');
				}

				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<div class="text-danger">' + json['error']['zone'] + '</div>');
				}

				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<div class="text-danger">' + json['error']['postcode'] + '</div>');
				}
			}

			if (json['shipping_method']) {
				$('#modal-shipping').remove();

				html  = '<div id="modal-shipping" class="modal">';
				html += '  <div class="modal-dialog">';
				html += '    <div class="modal-content">';
				html += '      <div class="modal-header">';
				html += '        <h4 class="modal-title"><?php echo $text_shipping_method; ?></h4>';
				html += '      </div>';
				html += '      <div class="modal-body">';

				for (i in json['shipping_method']) {
					html += '<p><strong>' + json['shipping_method'][i]['title'] + '</strong></p>';

					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<div class="radio">';
							html += '  <label>';

							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" />';
							} else {
								html += '<input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" />';
							}

									
        if (json['shipping_method'][i]['quote'][j]['image']) {
            html += '<img src="' + json['shipping_method'][i]['quote'][j]['image'] +'" /><br />' + json['shipping_method'][i]['quote'][j]['title'] + ' - ' + json['shipping_method'][i]['quote'][j]['text'] + ' ( ' + json['shipping_method'][i]['quote'][j]['weight']  + '' + json['text_kg']  + ', ' + json['shipping_method'][i]['quote'][j]['etd']  + '' + json['text_day'] + ') </label></div>';	
        } else {
            html += json['shipping_method'][i]['quote'][j]['title'] + ' - ' + json['shipping_method'][i]['quote'][j]['text'] + '</label></div>';
			}		
			
						}
					} else {
						html += '<div class="alert alert-danger">' + json['shipping_method'][i]['error'] + '</div>';
					}
				}

				html += '      </div>';
				html += '      <div class="modal-footer">';
				html += '        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $button_cancel; ?></button>';

				<?php if ($shipping_method) { ?>
				html += '        <input type="button" value="<?php echo $button_shipping; ?>" id="button-shipping" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />';
				<?php } else { ?>
				html += '        <input type="button" value="<?php echo $button_shipping; ?>" id="button-shipping" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" disabled="disabled" />';
				<?php } ?>

				html += '      </div>';
				html += '    </div>';
				html += '  </div>';
				html += '</div> ';

				$('body').append(html);

				$('#modal-shipping').modal('show');

				$('input[name=\'shipping_method\']').on('change', function() {
					$('#button-shipping').prop('disabled', false);
				});
			}
		}
	});
});

$(document).delegate('#button-shipping', 'click', function() {
	$.ajax({
		url: 'index.php?route=total/shipping/shipping',
		type: 'post',
		data: 'shipping_method=' + encodeURIComponent($('input[name=\'shipping_method\']:checked').val()),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping').button('loading');
		},
		complete: function() {
			$('#button-shipping').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
	
$('input[name=\'postcode\']').parent().parent().hide();
html = '<div class="form-group required"><input type="hidden" name="postcode" value="<?php echo $postcode; ?>" />';
html += '<label class="col-sm-2 control-label" for="input-sub-district"><?php echo $entry_postcode; ?></label>';
html += '<div class="col-sm-10"><select name="sub_district_id" id="input-sub-district" class="form-control"></select></div></div>';

$('select[name=\'zone_id\']').parent().parent().after(html);

$('select[name=\'zone_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/subdistrict&city_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'zone_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {    
    if(json['rajaongkir']['results']) {
             $.map(json, function(item) {
			html = '<option value=""><?php echo $text_select; ?></option>';
                $.each(item['results'], function( key, val ) {
                if(val['subdistrict_name'] == '<?php echo $postcode; ?>') {
                html+="<option value='" + val['subdistrict_id'] + "' selected='selected'>" + val['subdistrict_name'] + "</option>";                
                } else { 
                html+="<option value='" + val['subdistrict_id'] + "'>" + val['subdistrict_name'] + "</option>";
                  }
                });
            
            $('select[name=\'sub_district_id\']').html(html);

            var the_value = $('select[name=\'sub_district_id\'] option:selected').text();
            $('input[name=\'postcode\']').val(the_value);

            });
          }
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'sub_district_id\']').on('change', function() {
    var the_value = $('select[name=\'sub_district_id\'] option:selected').text();
    $('input[name=\'postcode\']').val(the_value);
});
   
$('select[name=\'country_id\']').on('change', function() {
	$.ajax({
			
		url: 'index.php?route=checkout/cart/city&province_id=' + this.value,
            
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

				
          if(json['rajaongkir']['results']) {
             $.map(json, function(item) {
			 html = '<option value=""><?php echo $text_select; ?></option>';
                $.each(item['results'], function( key, val ) {
                if(val['type'] == "Kabupaten")
                  var kab = 'Kab.';  
                else 
                    kab = val['type'];

                if(val['city_id'] == '<?php echo $zone_id; ?>') {
                    html+="<option value='" + val['city_id'] + "' selected='selected'>" +  kab + ' ' + val['city_name'] + "</option>";
                } else {
                    html+="<option value='" + val['city_id'] + "'>" + kab + ' ' + val['city_name'] + "</option>";
                 }
                });
            
                $('select[name=\'zone_id\']').html(html);
                $('select[name=\'zone_id\']').trigger('change'); 
                });			
            }
            

				
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
    </div>
  </div>
</div>
