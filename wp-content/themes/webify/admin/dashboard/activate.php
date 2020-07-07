<?php
/**
 * View Activate Theme
 *
 * @package webify
 * @since 1.0
 */
$purchase_key = get_option('purchase_key');
$is_valid     = get_option('is_valid');

 if ( isset( $_POST['webify_verify_nonce'] ) && wp_verify_nonce( $_POST['webify_verify_nonce'], 'webify_verify_nonce' ) && ! empty($_POST['webify_envato_code']) && isset($_POST['webify_envato_code'] ) ) {
  $envato_code = $_POST['webify_envato_code'];
  if(!empty($envato_code)) {
    $is_valid = webify_envato_verify_purchase($envato_code);
    if(!empty($is_valid) && $is_valid != false) {
      update_option('is_valid', true);
      update_option('purchase_key', $envato_code);
      $purchase_key = $envato_code;
      $output       = 'Congratulations! Webify is Activated.';
    }
  }
} else if($is_valid == true) {
  $output = 'Congratulations! Webify is Activated.';
} else {
  $output = '';
}

require_once 'header.php';
$theme_details = wp_get_theme();

?>

<div class="tb-admin-wrapper tb-plugins-wrapper about-wrap">
  <div class="tb-wc-header">
    <h1>Activate <?php echo esc_html($theme_details->get('Name')); ?></h1>
    <div class="about-text">
      <p> Please activate <?php echo esc_html($theme_details->get('Name')); ?>. This activation enables all features of the theme (i.e. Demo import etc.). This step is taken for mass piracy of our theme, and to serve our paying customers better. </p>
    </div>

    <?php if(!empty($output)): ?>
      <div class="msg-box text-center">
        <div class="icon-box"><img src="<?php echo get_theme_file_uri('admin/assets/img/dashboard/icons/06.png'); ?>" alt="<?php echo esc_attr__('icon', 'webify'); ?>" /></div>
        <?php echo esc_html($output); ?>
      </div>
    <?php endif; ?>

      <?php if($is_valid == false): ?>
      <form method="post" action="admin.php?page=webify_theme_activate">
        <div class="form-table tb-theme-activate">
          <div class="tb-form-title"><?php echo esc_html__('Envato Purchase Code:', 'webify'); ?></div>
          <div class="tb-input-box">
            <input type="text" placeholder="for e.g 4507f06b-ab21-4a97-8a1b-67w03d778345" name="webify_envato_code" value="<?php echo esc_attr($purchase_key); ?>">
          </div>
          <input type="hidden" name="webify_active" value="<?php echo esc_attr__('auto', 'webify'); ?>">
          <?php wp_nonce_field( 'webify_verify_nonce', 'webify_verify_nonce' ); ?>
          <p class="submit"><input type="submit" name="submit" id="submit" class="btn-style-1 btn-blue" value="<?php echo esc_attr__('Activate Theme', 'webify'); ?>"></p>
          <div class="tb-info"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank"><?php echo esc_html__('Where to find your purchase code ?', 'webify'); ?></a></div>
        </div>
      </form>
      <?php endif; ?>
  </div>


</div>
