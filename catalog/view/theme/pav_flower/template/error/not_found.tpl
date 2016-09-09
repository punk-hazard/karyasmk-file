<?php  echo $header; ?> <?php require( ThemeControlHelper::getLayoutPath( 'common/mass-header.tpl' )  ); ?>
<div class="main-columns container space-30">
   <div class="container-inside bg-white"> 
  
  <div class="row"><?php if( $SPAN[0] ): ?>
			<aside id="sidebar-left" class="col-md-<?php echo $SPAN[0];?>">
				<?php echo $column_left; ?>
			</aside>	
		<?php endif; ?> 
  
   <div id="sidebar-main" class="col-md-<?php echo $SPAN[1];?>"><div id="content"><?php echo $content_top; ?>
   <div class="well">
      <h1 class="page-title"><?php echo $heading_title; ?></h1>
      <p><?php echo $text_error; ?></p>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      </div><?php echo $content_bottom; ?>
   </div> 
   </div> 
<?php if( $SPAN[2] ): ?>
	<aside id="sidebar-right" class="col-md-<?php echo $SPAN[2];?>">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?></div>
</div>
</div>
<?php echo $footer; ?>