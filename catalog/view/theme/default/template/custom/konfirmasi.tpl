<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
<div id="notification"></div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
 
    <div id="content" class="<?php echo $class; ?>">
      <h1><?php echo $heading_title; ?></h1>
       <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
          	<div class="col-sm-8">
           <?php echo $text_konfirmasi; ?>
          	</div>
          </div>
        </div>
       </div> 
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
   <fieldset id="konfirmasi">
   	          <h3><?php echo $text_form_konfirmasi; ?></h3>
 <div class="form-group required">
            <label class="col-sm-2 control-label" for="input_email"><?php echo $entry_email; ?></label>
            <div class="col-sm-5">

       <input type="text" name="email" id="input_email" maxlength="50" value="<?php echo $email; ?>"  class="form-control" />
   
    <?php if ($error_email) { ?>
    <span class="text-danger"><?php echo $error_email; ?></span>
    <?php } ?>
    	</div>
    </div>
     <div class="form-group required">
            <label class="col-sm-2 control-label" for="input_no_order"><?php echo $entry_no_order; ?></label>
            <div class="col-sm-3">
    <?php if(count($orders)) { ?> 
            <select name="no_order" id="input-no-order" class="form-control">
        <?php foreach($orders as $order) { ?>
                 <?php if($no_order == $order['order_id']) { ?>
                 <option value="<?php echo $order['order_id']; ?>" selected="selected"><?php echo '#'.$order['order_id']; ?> a.n. <?php echo $order['name']; ?></option>
                    <?php } else { ?>
                          <option value="<?php echo $order['order_id']; ?>"><?php echo '#'.$order['order_id']; ?> a.n. <?php echo $order['name']; ?></option>
                    <?php } ?>
                 <?php } ?>
                </select>
    <?php } else { ?>
    <input type="text" name="no_order" id="input-no-order" maxlength="15" value="<?php echo $no_order; ?>"  class="form-control" />
        <?php } ?>
    <?php if ($error_no_order) { ?>
    <span class="text-danger"><?php echo $error_no_order; ?></span>
    <?php } ?>
    </div>
    </div>
    <div class="form-group required">
       <label class="col-sm-2 control-label" for="input_tgl_bayar"><?php echo $entry_tgl_bayar; ?></label>
              <div class="input-group date col-sm-3" style="padding-left: 15px;">
                <input type="text" name="tgl_bayar" id="input_tgl_bayar" value="<?php echo isset($_POST['tgl_bayar']) ? date("Y-m-d"):$tgl_bayar; ?>" data-date-format="YYYY-MM-DD" id="input_tgl_bayar" class="form-control" />
					 <?php if ($error_tgl_bayar) { ?>
    <span class="text-danger"><?php echo $error_tgl_bayar; ?></span>
    <?php } ?>                
                <span class="input-group-btn">
                <button class="btn btn-default" id="button_tgl_bayar" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
    </div>
<div class="form-group required">
            <label class="col-sm-2 control-label" for="input_jml_bayar">  <?php echo $entry_jml_bayar; ?></label>
    <span class="symbol_left" style="float: left;"></span>
            <div class="col-sm-4">
            <input type="text" name="jml_bayar" maxlength="11" id="input_jml_bayar"  class="form-control" value="<?php echo $jml_bayar; ?>" />
    <?php if ($error_jml_bayar) { ?>
    <span class="text-danger"><?php echo $error_jml_bayar; ?></span>
    <?php } ?>
 			</div>
    </div>
     <div class="form-group required">
            <label class="col-sm-2 control-label" for="bank_transfer"><span data-toggle="tooltip" title="<?php echo $help_bank_transfer; ?>"><?php echo $entry_bank_transfer; ?></span></label>
            <div class="col-sm-4"> 
<?php if ($payment_methods) { ?>
    <select name="bank_transfer" id="bank_transfer" class="form-control">
<?php foreach ($payment_methods as $payment_method) { ?>
     <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <option selected="selected" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></option>
    <?php } ?>

	<?php } ?> // end of foreach
	<select/>
<?php } ?>
 <?php if ($error_bank_transfer) { ?>
    <span class="text-danger"><?php echo $error_bank_transfer; ?></span>
    <?php } ?>
		</div>
    </div>
   <div class="form-group required">
      <label class="col-sm-2 control-label" for="input_metode_pembayaran">  <?php echo $entry_metode_pembayaran; ?></label>
       <div class="col-sm-4"> 

    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
    <option value='ATM'>ATM</option>
    <option value='Internet Banking'>Internet Banking</option>
    <option value='Mobile Banking'>Mobile Banking</option>
    <option value='Setoran Tunai'>Setoran Tunai</option>
    </select>
    <?php if ($error_metode_pembayaran) { ?>
    <span class="text-danger"><?php echo $error_metode_pembayaran; ?></span>
    <?php } ?>
		</div>
    </div>
     <div class="form-group required">
      <label class="col-sm-2 control-label" for="input_pengirim"> <?php echo $entry_pengirim; ?> </label>
       <div class="col-sm-5"> 
    <input type="text" name="pengirim" maxlength="40" value="<?php echo $pengirim; ?>" class="form-control" />
    
    <?php if ($error_pengirim) { ?>
    <span class="text-danger"><?php echo $error_pengirim; ?></span>
    <?php } ?>
	    </div>
    </div> 
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input_pengirim"> <?php echo $entry_nama_bank_pengirim; ?></label>
       <div class="col-sm-5"> 
    <input type="text" name="nama_bank_pengirim" maxlength="40" value="<?php echo $nama_bank_pengirim; ?>"  class="form-control" />
    <?php if ($error_nama_bank_pengirim) { ?>
    <span class="text-danger"><?php echo $error_nama_bank_pengirim; ?></span>
    <?php } ?>
   	</div>
    </div> 
 		<div class="form-group <?php echo $konfirmasi_status ? 'required' : ''; ?>">
              <label class="col-sm-2 control-label"><?php echo $entry_upload_bukti_transfer; ?></label>
              <div class="col-sm-2"> 
	             <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
   				</div>           
              <input type="hidden" name="code" value="" id="upload_bukti_transfer" />
                <div class="col-sm-3" id="filename"></div>
               <?php if ($error_code) { ?>
    <span class="text-danger"><?php echo $error_code; ?></span>
    <?php } ?>
            </div>
			<br />
    <?php if(!$logged) { ?>     
     <?php if ($site_key) { ?>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                <?php if ($error_captcha) { ?>
                  <div class="text-danger"><?php echo $error_captcha; ?></div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
         <?php } ?>
          </fieldset> 
  
  </form>
      <div class="col-sm-2"></div>
         <div class="col-sm-3">
      <input type="submit" name="submit" class="btn btn-primary"  id="button-konfirmasi" value="<?php echo $button_submit; ?>" />
    		</div>

    <?php echo $content_bottom; ?></div>

    <?php echo $column_right; ?></div>

 </div> 
 <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

 <script type="text/javascript"><!--
$('#button_tgl_bayar').on('click', function() {
$('.date').datetimepicker({
	pickTime: false
});

});
//--></script> 
 <script type="text/javascript"><!--
     
$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;
	
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				url: 'index.php?route=custom/konfirmasi/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();
					
					if (json['error']) {
						$('input[name=\'code\']').after('<div class="text-danger">' + json['error'] + '</div>');
					}
					
					if (json['success']) {
				  $('#filename').html(json['success']);
				  $('#filename').addClass("alert alert-danger");
						
					$('input[name=\'code\']').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
    
       
<script type="text/javascript"><!--
$('#button-konfirmasi').on('click', function() {

	$.ajax({
		url: 'index.php?route=custom/konfirmasi/save',
		type: 'post',
		data: $('#konfirmasi input[type=\'text\'], #konfirmasi input[type=\'hidden\'], #konfirmasi textarea, #konfirmasi select'),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-konfirmasi').button('loading');
		},
		complete: function() {
		$('#button-konfirmasi').button('reset');
			
		},		
		success: function(json) {
		$('.alert-danger').remove();	
		$('.text-danger').remove();	
		
			if (json['error']) {					
				if (json['error']['no_order']) {
						$('input[name=\'no_order\']').after('<div class="text-danger">' + json['error']['no_order'] + '</div>');
				}	
				if (json['error']['email']) {
					$('input[name=\'email\']').after('<div class="text-danger">' + json['error']['email'] + '</div>');
				}
				if (json['error']['jml_bayar']) {
					$('input[name=\'jml_bayar\']').after('<div class="text-danger">' + json['error']['jml_bayar'] + '</div>');
				}
                
                	if (json['error']['bank_transfer']) {
					$('select[name=\'bank_transfer\']').after('<div class="text-danger">' + json['error']['bank_transfer'] + '</div>');
				}
				if (json['error']['tgl_bayar']) {
					$('input[name=\'tgl_bayar\']').after('<div class="text-danger">' + json['error']['tgl_bayar'] + '</div>');
				}
                
                if (json['error']['pengirim']) {
					$('input[name=\'pengirim\']').after('<div class="text-danger">' + json['error']['pengirim'] + '</div>');
				}
                
                if (json['error']['nama_bank_pengirim']) {
					$('input[name=\'nama_bank_pengirim\']').after('<div class="text-danger">' + json['error']['nama_bank_pengirim'] + '</div>');
				}
				
				if (json['error']['code']) {
					$('#button-upload').after('<div class="text-danger">' + json['error']['code'] + '</div>');
				}
                
                if (json['error']['warning']) {
                                        
				$('.breadcrumb').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('.alert-danger').fadeIn('slow');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
				}
                
			}
	
			if (json['success']) {
                
                $('.breadcrumb').after('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('.alert-danger').fadeIn('slow');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
		$('input[name=\'no_order\']').val('');
		$('input[name=\'email\']').val('');
		$('input[name=\'jml_bayar\']').val('');
		$('input[name=\'pengirim\']').val('');
		$('input[name=\'nama_bank_pengirim\']').val('');
		$('input[name=\'tgl_bayar\']').val('');
		$('textarea[name=\'catatan\']').val('');
		$('input[name=\'code\']').val('');
		$('#filename').removeClass('alert alert-danger');
		$('#filename').html('');
			}
		}
	});
});

$('select[name=\'no_order\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=custom/konfirmasi/paymentAmount&order_id=' + this.value,
	    dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},		
		success: function(json) {
						
			if (json['total'] != '') {
			$('input[name=\'jml_bayar\']').val(json['total']);
            $('.symbol_left').html(json['symbol_left'] + ' ');
			} 
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'no_order\']').trigger('change');
//--></script>
<?php echo $footer; ?>