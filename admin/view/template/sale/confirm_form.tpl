<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
    
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_confirm; ?></h3>
      </div>
      <div class="panel-body">
       <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          <li><a href="#tab-history" data-toggle="tab"><?php echo $tab_history; ?></a></li>
        </ul>
        
           <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div id="notification"></div>
             <table class="table table-bordered">
                  <tr>
                <td><?php echo $entry_store; ?></td>
                <td><?php echo $store; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_no_order; ?></td>
                <td>#<?php echo $no_order; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_tgl_bayar; ?></td>
                <td><?php echo $tgl_bayar; ?></td>
              </tr>
               <tr>
                <td><?php echo $entry_jml_bayar; ?></td>
                <td><?php echo $jml_bayar; ?></td>
              </tr>
                <tr>
                <td><?php echo $entry_email; ?></td>
                <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
              </tr>
                <tr>
                <td><?php echo $entry_bank_transfer; ?></td>
                <td><?php echo $bank_transfer; ?></td>
              </tr>
                  <tr>
                <td><?php echo $entry_metode_pembayaran; ?></td>
                <td><?php echo $metode_pembayaran; ?></td>
              </tr>
                 <tr>
                <td><?php echo $entry_pengirim; ?></td>
                <td><?php echo $pengirim; ?></td>
              </tr>
                 <tr>
                <td><?php echo $entry_nama_bank_pengirim; ?></td>
                <td><?php echo $nama_bank_pengirim; ?></td>
              </tr>
                 <tr>
                <td><?php echo $entry_bukti_transfer; ?></td>
                <td>   <?php if(!empty($bukti_transfer))  { ?>
       <small><a href="<?php echo $bukti_transfer['href']; ?>"><?php echo $bukti_transfer['value']; ?></a></small>
            <?php } else { ?>
		<small> - </small>            
              <?php } ?></td>
              </tr>
              
                <tr>
                <td><?php echo $entry_receipt; ?></td>
                <td>     
                <div class="form-group">
                  <input type="text" name="no_receipt" value="<?php echo $no_receipt; ?>" id="no_receipt" class="form-control" />
                  </div>
                     <div class="text-left buttons">
                <button id="button-receipt-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_receipt_add; ?></button>
            
					</div>  
                  </td>

              </tr>
              
              </table>


         </div>
      
         <div class="tab-pane" id="tab-history">
            <div id="history"></div>
            <br />
            <fieldset>
              <legend><?php echo $text_history; ?></legend>
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                  <div class="col-sm-10">
                    <select name="order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_statuses) { ?>
                      <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                  <div class="col-sm-10">
                    <input type="checkbox" name="notify" value="1" id="input-notify" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
              </form>
              <div class="text-right">
                <button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
              </div>
            </fieldset>
          </div>
          </div>
            </div>

    </div>
  </div>
</div>
<script type="text/javascript"><!--

var token = '';

// Login to the API
$.ajax({
	url: '<?php echo $store_url; ?>index.php?route=api/login',
	type: 'post',
	dataType: 'json',
	data: 'key=<?php echo $api_key; ?>',
	crossDomain: true,
	success: function(json) {
		$('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    		}
        }

        if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=sale/confirm/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-history').on('click', function() {
	if (typeof verifyStatusChange == 'function'){
		if (verifyStatusChange() == false){
			return false;
		} else{
			addOrderInfo();
		}
	} else{
		addOrderInfo();
	}

	$.ajax({
		url: '<?php echo $store_url; ?>index.php?route=api/order/history&token=' + token + '&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()) + '&konfirmasi_id=<?php echo $konfirmasi_id; ?>',
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#history').load('index.php?route=sale/confirm/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function changeStatus(){
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbay-info').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/getorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		dataType: 'html',
		success: function(html) {
			$('#history').after(html);
		}
	});
}

function addOrderInfo(){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=extension/openbay/addorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbay-data").serialize()
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});
//--></script>

<script type="text/javascript"><!--
$('#button-receipt-add').on('click', function() {
	var no_receipt=$('input[name=\'no_receipt\']').val();

	$.ajax({
		url: 'index.php?route=sale/confirm/addReceipt&token=<?php echo $token; ?>',
		type: 'post',
		data: 'order_id=<?php echo $order_id; ?>&konfirmasi_id=<?php echo $konfirmasi_id; ?>&no_receipt=' + no_receipt,
		dataType: 'json',		
		beforeSend: function() {
			$('#button-receipt-add').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
		$('.fa-spin').remove();
			
		},		
		success: function(json) {
			$('.alert, .text-danger').remove();	
			if (json['error']) {
					if (json['error']['no_receipt']) {
					$('input[name=\'no_receipt\']').after('<div class="text-danger">' + json['error']['date_reference'] + '</div>');
				}				
			}
	
			if (json['success']) {
				$('#notification').html('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['description'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
$('html, body').animate({ scrollTop: 0 }, 'slow');
			
		  }
		},
			error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	
	

});
//--></script>
<?php echo $footer; ?>
