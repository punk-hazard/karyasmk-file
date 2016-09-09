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
                <label class="col-sm-3 control-label" for="install-table"><?php echo $text_install_table; ?></label>
                <div class="col-sm-8">
                
                <?php if (!$settings['installed']) { ?>
                  <a href="<?php echo $settings['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i></a>
                  <?php } else { ?>
                  <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $settings['uninstall']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>
                  <?php } ?>
                </div>
              </div>
    <div class="form-group">
                <label class="col-sm-3 control-label" for="install-table"><?php echo $text_login_confirmation; ?></label>
                  <div class="col-sm-8">
                    <label class="radio-inline">
                      <?php if ($konfirmasi_login_status) { ?>
                      <input type="radio" name="konfirmasi_login_status" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_login_status" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$konfirmasi_login_status) { ?>
                      <input type="radio" name="konfirmasi_login_status" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_login_status" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
              </div>
          <div class="form-group">
                <label class="col-sm-3 control-label" for="install-table"><?php echo $text_transfer_receipt_mandatory; ?></label>
                  <div class="col-sm-8">
                    <label class="radio-inline">
                      <?php if ($konfirmasi_transfer_receipt) { ?>
                      <input type="radio" name="konfirmasi_transfer_receipt" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_transfer_receipt" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$konfirmasi_transfer_receipt) { ?>
                      <input type="radio" name="konfirmasi_transfer_receipt" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_transfer_receipt" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
              </div>

      <div class="form-group">
            <label class="col-sm-3 control-label" for="input-order-status"><?php echo $text_order_status; ?></label>
            <div class="col-sm-9">
              <select name="konfirmasi_order_status" id="input-order-status" class="form-control">
                 <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $konfirmasi_order_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
              </select>
            </div>
          </div>
    <div class="form-group">
                <label class="col-sm-3 control-label" for="install-table"><?php echo $entry_substract_stock; ?></label>
                  <div class="col-sm-8">
                    <label class="radio-inline">
                      <?php if ($konfirmasi_substract_stock) { ?>
                      <input type="radio" name="konfirmasi_substract_stock" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_substract_stock" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$konfirmasi_substract_stock) { ?>
                      <input type="radio" name="konfirmasi_substract_stock" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="konfirmasi_substract_stock" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
              </div>
<div class="form-group">
                <label class="col-sm-3 control-label" for="install-table"><span data-toggle="tooltip" title="<?php echo $help_return_stock_status; ?>"><?php echo $entry_return_stock_status; ?></span></label>
                  <div class="col-sm-9">
                   <select name="konfirmasi_return_stock_status" id="input-order-status" class="form-control">
                 <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $konfirmasi_return_stock_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
              </select>
                  </div>
              </div>
     <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status"><?php echo $text_activate_confirmation; ?></label>
            <div class="col-sm-9">
              <select name="konfirmasi_status" id="input-status" class="form-control">
                <?php if ($konfirmasi_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
            </form>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>