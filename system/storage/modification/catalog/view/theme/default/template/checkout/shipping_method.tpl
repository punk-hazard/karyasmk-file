<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { ?>
<p><?php echo $text_shipping_method; ?></p>
<?php foreach ($shipping_methods as $shipping_method) { ?>
<p><strong><?php echo $shipping_method['title']; ?></strong></p>
<?php if (!$shipping_method['error']) { ?>
<?php foreach ($shipping_method['quote'] as $quote) { ?>
<div class="radio">
  <label>
    <?php if ($quote['code'] == $code || !$code) { ?>
    <?php $code = $quote['code']; ?>
    <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" />
    <?php } ?>
    	
 			<?php 
                $gambar=explode(".",$quote['code']);	
                if(file_exists('catalog/view/theme/default/image/shipping/'.$gambar[0].'.png')) { 
			 ?>
						
		<?php echo "<img src='catalog/view/theme/default/image/shipping/".$gambar[0].".png' /><br />"; ?>
     	<?php echo $quote['title']; ?> - <?php echo $quote['text']; ?> (<?php echo $quote['weight']." ".$quote['text_kg']; ?>, <?php echo $quote['etd']." ".$quote['text_day']; ?>) </label>
     <?php } else { ?>			    
    <?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></label>
    <?php } ?>
 				
</div>
<?php } ?>
<?php } else { ?>
<div class="alert alert-danger"><?php echo $shipping_method['error']; ?></div>
<?php } ?>
<?php } ?>
 
            <?php if($use_wooden_package) { ?> 
           <input type="checkbox" name="packing_kayu" value="1" /> <?php echo $text_packing_kayu; ?>
            <?php } ?>
            
<?php } ?>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
