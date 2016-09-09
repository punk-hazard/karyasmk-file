<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-confirm').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">    
             <div class="well">
          <div class="row">
            <div class="col-sm-4">
                    <div class="form-group">
                <label class="control-label" for="input-store"><?php echo $entry_store; ?></label>
               <select name="filter_store_id" id="input-store" class="form-control">
                <?php if($filter_store_id == "") { ?>
               <option value="" selected="selected"><?php echo $text_all_store; ?></option>
                   <?php } else { ?>
               <option value=""><?php echo $text_all_store; ?></option>                   
                <?php  } ?>
                 <?php if($filter_store_id == "0") { ?>
               <option value="0" selected="selected"><?php echo $text_default_store; ?></option>
                <?php } else { ?>
               <option value="0"><?php echo $text_default_store; ?></option>
                <?php } ?>   
                <?php foreach ($stores as $store) { ?>
                  <?php if ($store['store_id'] == $filter_store_id) { ?>                  
                <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
              	  <?php } ?>
                <?php } ?>
              </select>
             	 </div>
              </div>
            <div class="col-sm-4">
               <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
               <select name="filter_order_status_id" id="input-order-status" class="form-control">
                    <?php if($filter_order_status_id == "") { ?>
               <option value="" selected="selected"><?php echo $text_all_order_statuses; ?></option>
                   <?php } else { ?>
               <option value=""><?php echo $text_all_order_statuses; ?></option>                   
                <?php  } ?>
                <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>                  
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              	  <?php } ?>
                <?php } ?>
              </select>
             	 </div>
            </div>

              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
          
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-confirm">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'no_order') { ?>
                <a href="<?php echo $sort_no_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_no_order; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_no_order; ?>"><?php echo $column_no_order; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_tgl_bayar; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_tgl_bayar;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_tgl_bayar; ?>"><?php echo $column_tgl_bayar; ?></a>
                <?php } ?></td>
                
                    <td class="right"><?php if ($sort == 'store_id') { ?>
                <a href="<?php echo $sort_store_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_store_id; ?>"><?php echo $column_store; ?></a>
                <?php } ?></td>
                
						<td class="left">
                	<?php echo $column_bukti_transfer; ?>
                 </td>
<td class="right"><?php if ($sort == 'jml_bayar') { ?>
                <a href="<?php echo $sort_jml_bayar; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_jml_bayar;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_jml_bayar; ?>"><?php echo $column_jml_bayar; ?></a>
                <?php } ?></td>
             <td class="right"><?php if ($sort == 'bank_transfer') { ?>
                <a href="<?php echo $sort_bank_transfer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bank_transfer;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_bank_transfer; ?>"><?php echo $column_bank_transfer; ?></a>
                <?php } ?></td>
<!--
                <td class="right"><?php if ($sort == 'metode_pembayaran') { ?>
                <a href="<?php echo $sort_metode_pembayaran; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_metode_pembayaran;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_metode_pembayaran; ?>"><?php echo $column_metode_pembayaran; ?></a>
                <?php } ?></td>
-->
                <td class="right"><?php if ($sort == 'pengirim') { ?>
                <a href="<?php echo $sort_pengirim; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_pengirim;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_pengirim; ?>"><?php echo $column_pengirim; ?></a>
                <?php } ?></td>
                <td class="right"><?php if ($sort == 'status_order') { ?>
                <a href="<?php echo $sort_status_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status_order;?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status_order; ?>"><?php echo $column_status_order; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($confirms) { ?>
            <?php foreach ($confirms as $confirm) { ?>
            <tr>
               <td class="text-center"><?php if (in_array($confirm['konfirmasi_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $confirm['konfirmasi_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $confirm['konfirmasi_id']; ?>" />
                    <?php } ?></td>
              <td class="left"><?php echo $confirm['no_order']; ?></td>
              <td class="right"><?php echo $confirm['tgl_bayar']; ?></td>
              <td class="right"><?php echo $confirm['store']; ?></td>
<td class="left">  
<?php if(!empty($confirm['bukti_transfer']))  { ?>
<small><a href="<?php echo $confirm['bukti_transfer']['href']; ?>"><?php echo $confirm['bukti_transfer']['value']; ?></a></small>
            <?php } else { ?>
		<small> - </small>            
              <?php } ?>
</td>
		<td class="right"><?php echo $confirm['jml_bayar']; ?></td>
		<td class="right"><?php echo $confirm['bank_transfer']; ?></td>
<!--		<td class="right"><?php echo $confirm['metode_pembayaran']; ?></td>-->
		<td class="right"><?php echo $confirm['pengirim']; ?></td>
		<td class="right"><?php echo $confirm['status_order']; ?></td>
      <td class="text-right"><a href="<?php echo $confirm['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
     <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=sale/confirm&token=<?php echo $token; ?>';

	var filter_store_id = $('select[name=\'filter_store_id\']').val();

	if (filter_store_id) {
		url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
	}
    
    var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();

	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

	location = url;
});
//--></script> 
<?php echo $footer; ?>