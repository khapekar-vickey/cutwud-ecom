<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once (dirname (__FILE__) . '/woo.options.class.php');

$error = '';
$general_tab_txt = 'Account';

$base_options = ['SIRV_FOLDER', 'SIRV_ENABLE_CDN', 'SIRV_NETWORK_TYPE', 'SIRV_SHORTCODES_PROFILES', 'SIRV_CDN_PROFILES', 'SIRV_USE_SIRV_RESPONSIVE', 'SIRV_CROP_SIZES', 'SIRV_JS', 'SIRV_JS_FILE', 'SIRV_CDN_URL', 'SIRV_CUSTOM_CSS', 'SIRV_RESPONSIVE_PLACEHOLDER'];
$options_names = array_merge($base_options, Woo_options::get_option_names_list());

function isWoocommerce(){
  return is_plugin_active( 'woocommerce/woocommerce.php' );
}


function sirv_getStatus(){
  $status = get_option('SIRV_ENABLE_CDN');

  $class = $status == '1' ? 'sirv-status--enabled' : 'sirv-status--disabled';

  return $class;
}



$sirvAPIClient = sirv_getAPIClient();
$isMuted = $sirvAPIClient->isMuted();
if ($isMuted) {
  $reset_time = (int) get_option('SIRV_MUTE');
  $error = 'Module disabled due to exceeding API usage rate limit. Refresh this page in ' . $sirvAPIClient->calcTime($reset_time) . ' ' . date("F j, Y, H:i a (e)", $reset_time);
}

$sirvStatus = $sirvAPIClient->preOperationCheck();

if ($sirvStatus) {
  $general_tab_txt = 'General';
  $isWoocommerce = isWoocommerce();
  $isMultiCDN = false;
  $customCDNs = array();
  $is_direct = get_option('SIRV_NETWORK_TYPE') == "2" ? true : false;

  $accountInfo = $sirvAPIClient->getAccountInfo();
  if (!empty($accountInfo)) {

    $isMultiCDN = count((array) $accountInfo->aliases) > 1 ? true : false;
    $is_direct = ( isset($accountInfo->aliases->{$accountInfo->alias}->cdn) && $accountInfo->aliases->{$accountInfo->alias}->cdn ) ? false : true;
    $sirvCDNurl = get_option('SIRV_CDN_URL');


    update_option('SIRV_AWS_BUCKET', $accountInfo->alias);
    update_option('SIRV_NETWORK_TYPE', (isset($accountInfo->aliases->{$accountInfo->alias}->cdn) && $accountInfo->aliases->{$accountInfo->alias}->cdn) ? 1 : 2);
    update_option('SIRV_FETCH_MAX_FILE_SIZE', $accountInfo->fetching->maxFilesize);
    if (empty($sirvCDNurl) || !$isMultiCDN || $is_direct) {
      update_option('SIRV_CDN_URL', isset($accountInfo->cdnURL) ? $accountInfo->cdnURL : $accountInfo->alias . '.sirv.com');
    }

    if ($isMultiCDN) {
      foreach ($accountInfo->aliases as $alias) {
        $customCDNs[] = $alias->customDomain;
      }
    }
  }

  $storageInfo = sirv_getStorageInfo();
  $cacheInfo = sirv_getCacheInfo();
  $profiles = sirv_getProfilesList();


  $isOverCache = (int) $cacheInfo['q'] > (int) $cacheInfo['total_count'] ? true : false;
  $isFailed = (int) $cacheInfo['FAILED']['count'] > 0 ? true : false;
  $isGarbage = (int) $cacheInfo['garbage_count'] > 0 ? true : false;

  if ($isOverCache) {
    $cacheInfo['q'] = $isGarbage ? (int) $cacheInfo['q'] - (int) $cacheInfo['garbage_count'] > (int) $cacheInfo['total_count']
      ? (int) $cacheInfo['total_count']
      : (int) $cacheInfo['q'] - (int) $cacheInfo['garbage_count']
      : (int) $cacheInfo['total_count'];
  }

  $isSynced = ((int) $cacheInfo['q'] + (int) $cacheInfo['FAILED']['count']) == (int) $cacheInfo['total_count'];
  $is_sync_button_disabled = $isSynced ? 'disabled' : '';
  $sync_button_text = $isSynced ? (int) $cacheInfo['FAILED']['count'] == 0 ? '100% synced' : 'Synced' : 'Sync images';
  $is_show_resync_block = (int) $cacheInfo['q'] > 0 || $cacheInfo['FAILED']['count'] > 0 ? '' : 'display: none';
  $is_show_failed_block = (int) $cacheInfo['FAILED']['count'] > 0 ? '' : 'display: none';
}
?>

<style type="text/css">
  .sirv-wrapped-nav {
    /*display: flex;
    justify-content: space-between;
    min-height: 150px;
    flex-direction: column;*/
  }

  .sirv-logo-background{
    background-image: url("<?php echo plugin_dir_url(__FILE__) . "assets/logo.svg" ?>");
    background-position: center right;
    background-repeat: no-repeat;
    background-size: 68px 68px;
    min-height: 60px;
    margin: 0 !important;
  }

  a[href*="page=sirv/sirv/options.php"] img {
    padding-top:7px !important;
  }
</style>

<div class="wrap">
  <div class="sirv-s3-info-overlay" style="display: none;">
    <div class="sirv-s3-info sirv-no-select-text">
      <img src="<?php echo plugin_dir_url(__FILE__) . "assets/s3access.png" ?>" />
    </div>
  </div>

  <form action="options.php" method="post" id="sirv-save-options">

    <?php wp_nonce_field('update-options'); ?>

    <?php
    $active_tab = (isset($_POST['active_tab'])) ? $_POST['active_tab'] : '#sirv-account';
    ?>
    <div class="sirv-wrapped-nav">
      <h1 class="sirv-options-title sirv-logo-background">Welcome to Sirv</h1>
      <nav class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-sirv-account <?php echo ($active_tab == '#sirv-account') ? 'nav-tab-active' : '' ?>" href="#sirv-account"><span class="dashicons dashicons-admin-users"></span><span class="sirv-tab-txt"><?php echo $general_tab_txt; ?></span></a>
        <?php if ($sirvStatus) { ?>
          <?php if($isWoocommerce) { ?>
            <a class="nav-tab nav-tab-sirv-woo <?php echo ($active_tab == '#sirv-woo') ? 'nav-tab-active' : '' ?>" href="#sirv-woo"><span class="dashicons dashicons-cart"></span><span class="sirv-tab-txt">WooCommerce</span></a>
          <?php } ?>
          <a class="nav-tab nav-tab-sirv-cache <?php echo ($active_tab == '#sirv-cache') ? 'nav-tab-active' : '' ?>" href="#sirv-cache"><span class="dashicons dashicons-update"></span><span class="sirv-tab-txt">Synchronization</span></a>
          <a class="nav-tab nav-tab-sirv-stats <?php echo ($active_tab == '#sirv-stats') ? 'nav-tab-active' : '' ?>" href="#sirv-stats"><span class="dashicons dashicons-chart-bar"></span><span class="sirv-tab-txt">Stats</span></a>
        <?php } ?>
        <a class="nav-tab nav-tab-sirv-help <?php echo ($active_tab == '#sirv-help') ? 'nav-tab-active' : '' ?>" href="#sirv-help"><span class="dashicons dashicons-editor-help"></span><span class="sirv-tab-txt">Help</span></a>
        <a class="nav-tab nav-tab-sirv-feedback<?php echo ($active_tab == '#sirv-feedback') ? 'nav-tab-active' : '' ?>" href="#sirv-feedback"><span class="dashicons dashicons-feedback"></span><span class="sirv-tab-txt">Feedback</span></a>
      </nav>
    </div>

    <div class="sirv-tab-content sirv-tab-content-active" id="sirv-account">
      <?php if ($isMuted || $sirvStatus) { ?>
        <h2>Account info</h2>
        <div class="sirv-s3credentials-wrapper">
          <div class="sirv-optiontable-holder" style="<?php if ($error) echo 'width: 700px;'; ?>">
            <div class="sirv-error"><?php if ($error) echo '<div id="sirv-account" class="error-message">' . $error . '</div>'; ?></div>
            <?php if ($sirvStatus) { ?>
              <table class="optiontable form-table">
                <tr>
                  <th><label>Account</label></th>
                  <td><span><?php echo $storageInfo['account']; ?></span></td>
                </tr>
                <tr>
                  <th><label>Plan</label></th>
                  <td><span><?php echo $storageInfo['plan']['name']; ?>&nbsp;&nbsp;</span><a target="_blank" href="https://my.sirv.com/#/account/billing/plan">Upgrade plan</a></td>
                </tr>
                <tr>
                  <th><label>Allowance</label></th>
                  <td><span><?php echo $storageInfo['storage']['allowance_text'] . ' storage, ' . $storageInfo['plan']['dataTransferLimit_text'] . ' monthly transfer'; ?></span></td>
                </tr>
                <tr>
                  <th><label>User</label></th>
                  <td><span><?php echo get_option('SIRV_ACCOUNT_EMAIL'); ?> </span>&nbsp;&nbsp;<a class="sirv-disconnect" href="#">Disconnect</a></td>
                </tr>
                <tr>
                  <th><label>Domain</label></th>
                  <td>
                    <?php
                    $defaultCDN = get_option('SIRV_CDN_URL');
                    if ($isMultiCDN && !empty($customCDNs) && !$is_direct) { ?>
                      <select id="sirv-choose-domain" name="SIRV_CDN_URL">
                        <?php
                        foreach ($customCDNs as $customCDN) {
                          $selected = '';
                          if ($customCDN == $defaultCDN) {
                            $selected = 'selected';
                          }
                          echo '<option ' . $selected . ' value="' . $customCDN . '">' . $customCDN . '</option>';
                        }
                        ?>
                      </select>
                    <?php } else { ?>
                      <span><?php echo get_option('SIRV_CDN_URL'); ?></span>
                    <?php } ?>

                  </td>
                </tr>
              </table>
            <?php } ?>
          </div>
        </div>
      <?php } else { ?>
        <h2>Connect your Sirv account</h2>

        <div class="sirv-connect-account-wrapper">
          <div class="sirv-optiontable-holder">
            <div class="sirv-error"></div>
            <table class="optiontable form-table">
              <tr class="sirv-field">
                <th colspan="2">
                  <label class="sirv-acc-label">Don't have an account?</label>  <a href="#" class="sirv-switch-acc-login">Create account</a>
                </th>
                <!-- <td>
                  <input class="sirv-switch" type="checkbox" id="switch" checked /><label for="switch">Toggle</label>
                </td> -->
              </tr>
              <tr class="sirv-block-hide sirv-field">
                <th><label class="required">First & last Name</label></th>
                <td><input class="regular-text" type="text" name="SIRV_NAME" value=""></td>
              </tr>
              <tr class="sirv-field">
                <th><label class="required">Email</label></th>
                <td><input class="regular-text" type="text" name="SIRV_EMAIL" value=""></td>
              </tr>
              <tr class="sirv-field">
                <th><label class="required sirv-pass-field">Password</label></th>
                <td style="position: relative;">
                  <input class="regular-text input password-input sirv-pass" type="password" name="SIRV_PASSWORD" value="">
                  <button type="button" class="sirv-toogle-pass button" data-toggle="0" aria-label="Show password">
                    <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                  </button>
                </td>
              </tr>
              <!-- <tr class="sirv-block-hide sirv-field">
                <th><label class="required">Last name</label></th>
                <td><input class="regular-text" type="text" name="SIRV_LAST_NAME" value=""></td>
              </tr> -->
              <tr class="sirv-block-hide sirv-field">
                <th><label class="required sirv-acc-field">Account name</label></th>
                <td><input class="regular-text" type="text" name="SIRV_ACCOUNT_NAME" value=""></td>
              </tr>
              <tr class="sirv-select" style="display:none">
                <th><label class="required">Select account</label></th>
                <td><select name="sirv_account"></select>
                </td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <input type="button" class="button-primary sirv-init" value="Connect account">
                </td>
              </tr>
              <tr class="sirv-block-hide">
                <th></th>
                <td colspan="2">
                  <span class="sirv-new-acc-text">Start a 30 day free trial, with 5GB storage & 20GB transfer.
Then autoswitch to a free plan or upgrade to a <a href="https://sirv.com/pricing/">paid plan</a>.</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <br>
      <?php }
      if ($sirvStatus) { ?>
        <div class="sirv-network-wrapper">
          <h2>Enable the Sirv CDN</h2>

          <p class="sirv-options-desc">
            All WordPress media library images will be copied to Sirv (featured images, gallery images, WooCommerce images & images added via plugins). Sirv CDN will serve them optimized, resized and very fast.
          </p>

          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table">
              <tr>
                <th>
                  <label>Network status</label>
                </th>
                <td>
                  <label><input type="radio" name="SIRV_ENABLE_CDN" value='2' "<?php checked(2, get_option('SIRV_ENABLE_CDN'), true); ?>">Disabled</label><br />
                  <label><input type="radio" name="SIRV_ENABLE_CDN" value='1' "<?php checked(1, get_option('SIRV_ENABLE_CDN'), true); ?>">Enabled</label>
                </td>
                <td>
                  <span class="sirv-status <?php echo sirv_getStatus(); ?>"></span>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Network</label>
                </th>
                <td>
                  <label><input type="radio" name="SIRV_NETWORK_TYPE" value='1' "<?php checked(1, get_option('SIRV_NETWORK_TYPE'), true); ?>"><b>CDN</b> - deliver images from Sirv's global server network.</label>
                  <label><input type="radio" name="SIRV_NETWORK_TYPE" value='2' "<?php checked(2, get_option('SIRV_NETWORK_TYPE'), true); ?>"><b>DIRECT</b> - deliver images from Sirv's primary datacentre.</label>
                </td>
              </tr>
              <tr class='custom-domain'>
                <th>
                  <label>Custom domain</label>
                </th>
                <td><input class="regular-text" type="text" name="SIRV_CUSTOM_DOMAIN" value="<?php echo get_option('SIRV_CUSTOM_DOMAIN'); ?>" placeholder='e.g. cdn.mydomain.com'></td>
              </tr>
              <tr>
                <th>
                  <label>Folder name on Sirv</label>
                </th>
                <td colspan="2"><input class="regular-text" type="text" name="SIRV_FOLDER" value="<?php echo get_option('SIRV_FOLDER'); ?>"></td>
              </tr>
              <tr>
                <th>
                </th>
                <td><input type="submit" name="submit" class="button-primary sirv-save-settings" value="<?php _e('Save Settings') ?>" /></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="sirv-profiles-wrapper">
          <!-- profiles options-->
          <h2>Image settings</h2>
          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table">
              <tr>
                <th>
                  <label style="padding-bottom: 10px;">Lazy loading</label>
                </th>
                <td>
                  <label><input type="checkbox" name="SIRV_USE_SIRV_RESPONSIVE" id="SIRV_USE_SIRV_RESPONSIVE" value='1' "<?php checked('1', get_option('SIRV_USE_SIRV_RESPONSIVE'));  ?>"><span class="sirv-option-responsive-text">Load images on demand & scale them perfectly. Check your site after activation and deactivate any other lazy loading plugins.</span></label>
                </td>
              </tr>
              <tr>
                <th><label>Placeholder</label></th>
                <td>
                  <label><input type="radio" name="SIRV_RESPONSIVE_PLACEHOLDER" value='1' "<?php checked(1, get_option('SIRV_RESPONSIVE_PLACEHOLDER'), true); ?>">Blurred</label>
                  <label><input type="radio" name="SIRV_RESPONSIVE_PLACEHOLDER" value='2' "<?php checked(2, get_option('SIRV_RESPONSIVE_PLACEHOLDER'), true); ?>">Grey</label>
                </td>
                <td>
                  <div class="sirv-tooltip">
                    <i class="dashicons dashicons-editor-help sirv-tooltip-icon"></i>
                    <span class="sirv-tooltip-text sirv-no-select-text">While the image is loading, show a blurred or grey background.</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Featured images &amp; post thumbnails</label>
                </th>
                <td>
                  <!-- <span class="sirv-traffic-loading-ico sirv-shortcodes-profiles"></span> -->
                  <select id="sirv-cdn-profiles">
                    <?php if (isset($profiles)) echo sirv_renderProfilesOptopns($profiles); ?>
                  </select>
                  <input type="hidden" id="sirv-cdn-profiles-val" name="SIRV_CDN_PROFILES" value="<?php echo get_option('SIRV_CDN_PROFILES'); ?>">
                </td>
                <td>
                  <div class="sirv-tooltip">
                    <i class="dashicons dashicons-editor-help sirv-tooltip-icon"></i>
                    <span class="sirv-tooltip-text sirv-no-select-text">Apply one of <a target="_blank" href="https://my.sirv.com/#/profiles/">your profiles</a> for watermarks, text and other image customizations. Learn <a target="_blank" href="https://sirv.com/help/articles/dynamic-imaging/profiles/">about profiles</a>.</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Shortcodes</label>
                </th>
                <td>
                  <!-- <span class="sirv-traffic-loading-ico sirv-shortcodes-profiles"></span> -->
                  <select id="sirv-shortcodes-profiles">
                    <?php if (isset($profiles)) echo sirv_renderProfilesOptopns($profiles); ?>
                  </select>
                  <input type="hidden" id="sirv-shortcodes-profiles-val" name="SIRV_SHORTCODES_PROFILES" value="<?php echo get_option('SIRV_SHORTCODES_PROFILES'); ?>">
                </td>
                <td>
                  <div class="sirv-tooltip">
                    <i class="dashicons dashicons-editor-help sirv-tooltip-icon"></i>
                    <span class="sirv-tooltip-text sirv-no-select-text">Apply one of <a target="_blank" href="https://my.sirv.com/#/profiles/">your profiles</a> for watermarks, text and other image customizations. Learn <a target="_blank" href="https://sirv.com/help/articles/dynamic-imaging/profiles/">about profiles</a>.</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th><label>Crop images</label></th>
                <td>
                      <a
                      class="sirv-hide-show-a"
                      data-status="false"
                      data-selector=".sirv-crop-wrap"
                      data-show-msg="Show crop options"
                      data-hide-msg="Hide crop options"
                      data-icon-show="dashicons dashicons-arrow-right-alt2"
                      data-icon-hide="dashicons dashicons-arrow-down-alt2"><span class="dashicons dashicons-arrow-right-alt2"></span>Show crop options</a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="sirv-crop-wrap" style="display: none;">
                    <div class="sirv-crop-wrap__desc">
                      <span>Show consistently sized images either via crop or adding background.</span>
                      <div class="sirv-crop-wrap__img">
                        <img src="https://sirv.sirv.com/website/screenshots/wordpress/crop-example.jpg">
                      </div>

                    </div>
                  <?php
                    $crop_data = json_decode(get_option('SIRV_CROP_SIZES'), true);
                    if( empty($crop_data) ){
                      $encoded_default_crop = sirv_get_default_crop();
                      update_option('SIRV_CROP_SIZES', $encoded_default_crop);
                      $crop_data = json_decode($encoded_default_crop, true);
                    }
                    $wp_sizes = sirv_get_image_sizes();
                    ksort($wp_sizes);

                    foreach ($wp_sizes as $size_name => $size) {
                      $size_str = $size_name . "<span>". $size['width'] ."x". $size['height'] ."</span>";
                      $cropMethod = @$crop_data[$size_name];
                      if( empty($cropMethod) ) $cropMethod = 'none';
                  ?>
                    <div class="sirv-crop-row">
                      <span class="sirv-crop-row__title"><?php echo $size_str; ?></span>
                      <div class="sirv-crop-row__checkboxes">
                        <input type="radio" class="sirv-crop-radio" name="<?php echo $size_name; ?>" id="<?php echo $size_name; ?>1" value="none" <?php checked('none', $cropMethod, true); ?>><label class="fchild" for="<?php echo $size_name; ?>1">No crop</label>
                        <input type="radio" class="sirv-crop-radio" name="<?php echo $size_name; ?>" id="<?php echo $size_name; ?>2" value="wp_crop" <?php checked('wp_crop', $cropMethod, true); ?>><label for="<?php echo $size_name; ?>2">Crop</label>
                        <input type="radio" class="sirv-crop-radio" name="<?php echo $size_name; ?>" id="<?php echo $size_name; ?>3" value="sirv_crop" <?php checked('sirv_crop', $cropMethod, true); ?>><label for="<?php echo $size_name; ?>3">Uniform</label>
                      </div>
                    </div>
                  <?php } ?>
                  <input type="hidden" id="sirv-crop-sizes" name="SIRV_CROP_SIZES" value="<?php echo htmlspecialchars(get_option('SIRV_CROP_SIZES')); ?>">
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                </th>
                <td><input type="submit" name="submit" class="button-primary sirv-save-settings" value="<?php _e('Save Settings') ?>" /></td>
              </tr>
            </table>
          </div>
        </div>


        <div class="sirv-miscellaneous-wrapper">
          <h2>Miscellaneous</h2>
          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table">
              <tr>
                <th>
                  <label>Include Sirv JS</label>
                </th>
                <td>
                  <label><input type="radio" name="SIRV_JS" value="1" <?php checked(1, get_option('SIRV_JS'), true); ?>><b>All pages</b> - always add script (select this if images are not loading).</label>
                  <label><input type="radio" name="SIRV_JS" value="2" <?php checked(2, get_option('SIRV_JS'), true); ?>><b>Detect</b> - add script only to pages that require it.</label>
                  <label><input type="radio" name="SIRV_JS" value="3" <?php checked(3, get_option('SIRV_JS'), true); ?>><b>No pages</b> - don't add script (may break shortcodes & responsive images).</label>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Sirv JS version</label>
                </th>
                <td>
                  <label>
                    <input type="radio" name="SIRV_JS_FILE" value="1" <?php checked(1, get_option('SIRV_JS_FILE'), true); ?>>Original
                  </label>
                  <label>
                    <input type="radio" name="SIRV_JS_FILE" value="2" <?php checked(2, get_option('SIRV_JS_FILE'), true); ?>>Original light (excludes <a href="https://sirv.com/features/360-product-viewer/" target="_blank">Sirv Spin</a>)
                  </label>
                  <label>
                    <input type="radio" name="SIRV_JS_FILE" value="3" <?php checked(3, get_option('SIRV_JS_FILE'), true); ?>>Latest (uses <a href="https://sirv.com/help/resources/sirv-media-viewer/" target="_blank">Sirv Media Viewer</a>)
                  </label>
                </td>
              </tr>
              <tr>
                <th>
                  <label>Custom CSS</label>
                </th>
                <td>
                  <textarea name="SIRV_CUSTOM_CSS" placeholder="Example:
.here-is-a-style img {
  width: auto !important;
}" value="<?php echo get_option('SIRV_CUSTOM_CSS'); ?>" rows="4"><?php echo get_option('SIRV_CUSTOM_CSS'); ?></textarea>
                  <span>Add styles to fix any rendering conflicts caused by other CSS.</span>
                </td>
              </tr>
              <tr>
                <th>
                </th>
                <td><input type="submit" name="submit" class="button-primary sirv-save-settings" value="<?php _e('Save Settings') ?>" /></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- END Account&CDN options-->
    </div>
    <?php if($isWoocommerce) { ?>
      <div class="sirv-tab-content" id="sirv-woo">
        <h2>Sirv Media Viewer for WooCommerce</h2>
        <p class="sirv-options-desc">Image zoom, 360 spin and product videos to make your products look glorious. Replaces your existing media gallery with <a target="_blank" href="https://sirv.com/help/articles/sirv-media-viewer/">Sirv Media Gallery</a> on your product pages.</p>
        <div class="sirv-optiontable-holder">
          <table class="sirv-woo-settings optiontable form-table">
            <?php
              echo Woo_options::render_options($profiles);
            ?>
            <tr>
              <th></th>
              <td><input type="submit" name="submit" class="button-primary sirv-save-settings" value="<?php _e('Save Settings') ?>" /></td>
            </tr>
          </table>
        </div>
        <h2>Cache settings</h2>
        <div class="sirv-optiontable-holder">
          <table class="sirv-woo-settings optiontable form-table">
            <?php
              echo Woo_options::render_view_clean_cache();
            ?>
            <!-- <tr>
              <th></th>
              <td><input type="submit" name="submit" class="button-primary sirv-save-settings" value="<?php _e('Save Settings') ?>" /></td>
            </tr> -->
          </table>
        </div>

      </div>
    <?php } ?>


    <div class="sirv-tab-content" id="sirv-cache">
      <h2>Synchronization</h2>
      <p class="sirv-options-desc">Copy your WordPress media library to Sirv, for supreme optimization and fast CDN delivery.</p>
      <div class="sirv-optiontable-holder">
        <table class="optiontable form-table">
          <?php if (get_option('SIRV_ENABLE_CDN') != 1) { ?>
            <tr>
              <th class="no-padding" colspan="2">
                <div class="sirv-message warning-message">
                  <span style="font-size: 15px;font-weight: 800;">Note:</span> <a class="sirv-show-account-tab">network status</a> is currently Disabled.
                </div>
              </th>
            </tr>
          <?php } ?>
          <tr>
            <th class="sirv-sync-messages no-padding" colspan="2"></th>
          </tr>
          <tr>
            <td colspan="2">
              <h3>Status</h3>
            </td>
          </tr>
          <tr class="small-padding">
            <th><label style="white-space:nowrap;">Synchronized images</label></th>
            <td><span class="cache-img-num"><?php echo $cacheInfo['q'] . ' of ' . $cacheInfo['total_count']; ?></td>
          </tr>
          <tr class="small-padding">
            <th><label>Total file size</label></th>
            <td><span class="cache-size"><?php echo $cacheInfo['size_s']; ?></td>
          </tr>
          <tr class="small-padding failed-images-block" style="<?php echo $is_show_failed_block; ?>">
            <th><label>Failed images</label></th>
            <td class="failed-images-count-row"><span class="failed-images-count"><?php echo $cacheInfo['FAILED']['count']; ?></span> <span class="sirv-traffic-loading-ico" style="display: none;"></span><a href="#">Show</a></td>
          </tr>
          <tr class="sync-errors-wrap">
            <th colspan="2">
              <div class="sync-errors">
                <table class="optiontable form-table sirv-form-table">
                  <thead>
                    <tr>
                      <td style="width: 65%;"><b>Error message</b></td>
                      <td><b>Count</b></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody class='sirv-fetch-errors'></tbody>
                </table>
              </div>
            </th>
          </tr>
          <tr>
            <td colspan="2">
              <h2>Progress</h2>
              <p class="sirv-options-desc">Images are copied to Sirv the first time they are viewed, which can take 1-2 seconds per image. To perform a full synchronization now, click Sync images:</p>
            </td>
          </tr>
          <tr class="small-padding">
            <th colspan="2">
              <div class="sirv-sync-images-progress-block">
                  <div class="sirv-progress">
                    <div class="sirv-progress__text">
                      <div class="sirv-progress__text--percents"><?php echo $cacheInfo['progress'] . '%'; ?></div>
                      <div class="sirv-progress__text--complited"><span><?php echo $cacheInfo['q'] . ' out of ' . $cacheInfo['total_count']; ?></span> items completed</div>
                    </div>
                    <div class="sirv-progress__bar <?php if ($isSynced) echo 'sirv-failed-imgs-bar'; ?>">
                      <div class="sirv-progress__bar--line" style="width: <?php echo $cacheInfo['progress'] . '%;'; ?>"></div>
                    </div>
                  </div>
                  <?php if (!$isMuted) { ?>
                  <div class="sirv-sync-button-container">
                    <input type="button" name="sirv-sync-images" class="button-primary sirv-sync-images" value="<?php echo $sync_button_text; ?>" <?php echo $is_sync_button_disabled; ?> />
                  </div>
                  <?php } ?>
              </div>
            </th>
          </tr>
          <?php if (!$isMuted) { ?>
          <tr class="sirv-processing-message" style='display: none;'>
            <td colspan="2">
              <span class="sirv-traffic-loading-ico"></span><span class="sirv-queue">Images in queue: calculating...</span>
              <p style="margin: 10px 0 !important; font-weight: bold; color: #8a6d3b;">
                Keep this page open until synchronisation reaches 100%. Your account can sync 2,000 images per hour (<a class='sirv-show-stats-tab' href="#sirv-stats">check current usage</a>).
                If sync stops, refresh this page and resume the sync.
              </p>
            </td>
          </tr>
          <tr class='sirv-resync-block' style="<?php echo $is_show_resync_block; ?>">
            <td colspan="2">
              <span>
                <h2>Re-Synchronize</h2>
              </span>
            </td>
          </tr>
          <?php
                  $g_disabled = $isGarbage ? '' : 'disabled';
                  $g_checked = $isGarbage ? 'checked' : '';
                  $g_show = $isGarbage ? '' : 'style="display: none;"';
                  $g_dis_class = $isGarbage ? '' : 'sirv-dis-text';
                  $f_disabled = $isFailed ? '' : 'disabled';
                  $f_dis_class = $isFailed ? '' : 'sirv-dis-text';
                  $f_checked = $isFailed ? 'checked' : '';
                  $a_checked = !$isFailed ? 'checked' : '';
          ?>
          <tr class="sirv-discontinued-images" <?php echo $g_show; ?>>
            <td class="no-padding" colspan="2">
              <div class="sirv-message warning-message">
                <span style="font-size: 15px;font-weight: 800;">Recomendation:</span> <span class="sirv-old-cache-count"><?php echo $cacheInfo['garbage_count'] ?></span> images in plugin database no longer exist.&nbsp;&nbsp;
                <input type="button" name="optimize_cache" class="button-primary optimize-cache" value="Clean up" />&nbsp;
                <span class="sirv-traffic-loading-ico" style="display: none;"></span>
              </div>
            </td>
          </tr>
          <tr class="sirv-resync-block small-padding" style="<?php echo $is_show_resync_block; ?>">
            <td colspan="2">
              <!-- <label class="sirv-ec-garbage-item <?php echo $g_dis_class; ?>">
                <input type="radio" name="empty_cache" value="garbage" <?php echo $g_disabled . '' . $g_checked; ?>><b>Optimize</b> - clear cache of <abbr title="Images that no longer exist in your WordPress media library">discontinued</abbr> images (<span class="sirv-old-cache-count"><?php echo $cacheInfo['garbage_count'] ?></span> images).
              </label><br> -->
              <label class="sirv-ec-failed-item <?php echo $f_dis_class; ?>">
                <input type="radio" name="empty_cache" value="failed" <?php echo $f_disabled . ' ' . $f_checked; ?>><b>Failed</b> - clear cache of failed images.
              </label>
              <br>
              <label class="sirv-ec-all-item">
                <input type="radio" name="empty_cache" value="all" <?php echo $a_checked; ?>><b>All</b> - clear cache of all images.
              </label>
            </td>
          </tr>
          <tr class="sirv-resync-block sirv-resync-button-block" style="<?php echo $is_show_resync_block; ?>">
            <td>
              <input type="button" name="empty_cache" class="button-primary empty-cache" value="Empty cache" />&nbsp;
              <span class="sirv-traffic-loading-ico" style="display: none;"></span>
            </td>
          <?php } ?>
          </tr>
        </table>
      </div>
    <?php } ?>
    </div>


    <?php if ($sirvStatus && !empty($storageInfo)) { ?>
      <div class="sirv-tab-content" id="sirv-stats">
        <div class="sirv-stats-messages"></div>
        <h2>Stats</h2>
        <p class="sirv-options-desc">Check the storage and CDN transfer of your Sirv account.</p>
        <div class="sirv-storage-traffic-wrapper">
          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table sirv-form-table">
              <tr>
                <td colspan="2">
                  <h3>Storage</h3>
                </td>
              </tr>
              <tr class="small-padding">
                <th><label>Allowance</label></th>
                <td><span class="sirv-allowance"><?php if (isset($storageInfo)) echo $storageInfo['storage']['allowance_text']; ?></span></td>
              </tr>
              <tr class="small-padding">
                <th><label>Used</label></th>
                <td><span class="sirv-st-used"><?php if (isset($storageInfo)) echo $storageInfo['storage']['used_text']; ?><span> (<?php if (isset($storageInfo)) echo $storageInfo['storage']['used_percent']; ?>%)</span></span></td>
              </tr>
              <tr class="small-padding">
                <th><label>Available</label></th>
                <td><span class="sirv-st-available"><?php if (isset($storageInfo)) echo $storageInfo['storage']['available_text']; ?><span> (<?php if (isset($storageInfo)) echo $storageInfo['storage']['available_percent']; ?>%)</span></span></td>
              </tr>
              <tr class="small-padding">
                <th><label>Files</label></th>
                <td><span class="sirv-st-files"><?php if (isset($storageInfo)) echo $storageInfo['storage']['files']; ?></span></td>
              </tr>
            </table>
          </div>

          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table sirv-form-table">
              <tr>
                <td>
                  <h3>Transfer</h3>
                </td>
              </tr>
              <tbody cellspacing="0" class="optiontable form-table sirv-form-table traffic-wrapper">
                <tr class="small-padding">
                  <th><label>Allowance</label></th>
                  <td colspan="2"><span style="" class="sirv-trf-month"><?php if (isset($storageInfo)) echo $storageInfo['traffic']['allowance_text']; ?></span></td>
                </tr>
                <?php
                if (isset($storageInfo['traffic']['traffic'])) {
                  foreach ($storageInfo['traffic']['traffic'] as $label => $text) {
                ?>
                    <tr class="small-padding">
                      <th><label><?php echo $label; ?></label></th>
                      <td><span><?php echo $text['size_text']; ?></span></td>
                      <td>
                        <div class="sirv-progress-bar-holder">
                          <div class="sirv-progress-bar">
                            <div>
                              <div style="width: <?php echo $text['percent_reverse']; ?>%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <h2>API usage</h2>
        <!-- <p class="sirv-options-desc">Check how much sirv api requests is using.</p> -->
        <p class="sirv-options-desc">Last update: <span class='sirv-stat-last-update'><?php echo $storageInfo['lastUpdate']; ?></span>&nbsp;&nbsp;<a class="sirv-stat-refresh" href="#">Refresh</a></p>
        <div class="sirv-api-usage">
          <div class="sirv-optiontable-holder">
            <table class="optiontable form-table sirv-form-table">
              <thead>
                <tr>
                  <td><b>Type</b></td>
                  <td><b>Limit</b></td>
                  <td><b>Used</b></td>
                  <td><b>Next reset</b></td>
                </tr>
              </thead>
              <tbody class='sirv-api-usage-content'>
                <?php foreach ($storageInfo['limits'] as $limit) {
                  $is_limit_reached = ((int) $limit['count'] >= (int) $limit['limit']) ? 'style="color: red;"' : '';
                ?>
                  <tr <?php echo $is_limit_reached; ?>>
                    <td><?php echo $limit['type'] ?></td>
                    <td><?php echo $limit['limit'] ?></td>
                    <?php if ($limit['count'] > 0) { ?>
                      <td><?php echo $limit['count'] . ' (' . $limit['used'] . ')'; ?></td>
                      <!-- <td><span class="sirv-limits-reset" data-timestamp="<?php echo $limit['reset_timestamp']; ?>"><?php echo $limit['reset_str']; ?></span></td> -->
                      <td><span class="sirv-limits-reset" data-timestamp="<?php echo $limit['reset_timestamp']; ?>"><?php echo $limit['count_reset_str']; ?> <span class="sirv-grey">(<?php echo $limit['reset_str']; ?>)</span></span></td>
                    <?php } else { ?>
                      <td>-</td>
                      <td>-</td>
                      <td></td>
                    <?php } ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } ?>


    <div class="sirv-tab-content" id="sirv-help">
      <div class="sirv-help-wrapper">
        <div class="sirv-help-menu">
          <ul class="sirv-nav">
            <li class="active"><a href="#sirv-help-about">About Sirv</a></li>
            <li><a href="#sirv-help-sync">Sync your Media Library</a></li>
            <li><a href="#sirv-help-upload-images">Upload images</a></li>
            <li><a href="#sirv-help-static">Embed static images</a></li>
            <li><a href="#sirv-help-responsive">Embed responsive images</a></li>
            <li><a href="#sirv-help-gallery">Embed image galleries</a></li>
            <li><a href="#sirv-help-zoom-image">Embed zoom images</a></li>
            <li><a href="#sirv-help-zoom-galleries">Embed zoom galleries</a></li>
            <li><a href="#sirv-help-spin">Embed 360 spins</a></li>
            <li><a href="#sirv-help-zoom-and-spin">Embed spins & zooms</a></li>
            <li><a href="#sirv-help-serve-other-files">Serve other files</a></li>
            <li><a href="#sirv-help-learn-more">Learn more about Sirv</a></li>
          </ul>
        </div>
        <div class="sirv-help-data">
          <a class="sirv-anchor-help" id="sirv-help-about"></a>
          <h2>About Sirv</h2>

          <p>Sirv is an image hosting, processing and optimisation service which intelligently serves the most optimal image to each user.</p>

          <p>Best-practice in every way:
            <ul style="list-style: disc; margin-left: 25px;">
              <li>Responsive image resizing.</li>
              <li>Outstanding image optimisation.</li>
              <li>Optimal image format (including WebP).</li>
              <li>Lazy loading.</li>
              <li>CDN delivery from servers all around the world.</li>
              <li>HTTP/2 and TLS1.3 for fast, secure delivery.</li>
            </ul>
          </p>

          <a class="sirv-anchor-help" id="sirv-help-sync"></a>
          <h2>Sync your Media Library</h2>

          <p>Sirv can serve your WordPress media library faster than your own server can.</p>

          <p>First, it synchronizes your media library to your Sirv account. Then it serves your images from Sirv instead of your server.</p>

          <p>Images are perfectly sized and incredibly well optimized. They are delivered to each visitor by the closest server on Sirv's fast global CDN.</p>

          <p>1. Enable the Sirv CDN:</p>

          <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/simply-enable-the-Sirv-CDN.png?profile=wp-plugin-help" class="card" alt=""></p>

          <p>2. Sirv will fetch the images from your server the first time they are requested.</p>

          <p>Images will automatically stay in sync whenever you upload new images.</p>

          <p>3. Go to the Synchronization tab to check the status. To trigger a full sync of all images, click the <strong>Sync Images</strong> button:</p>

          <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/check-the-status-of-synchronization.png?profile=wp-plugin-help" class="card" alt=""></p>

          <h2>
            <a class="sirv-anchor-help" id="sirv-help-upload-images"></a>
            Upload images
          </h2>

          <p>You can either upload images to the WordPress media library (and Sirv will sync them if you enable the CDN) or you can upload images directly to your Sirv media library.</p>

          <p>Upload directly to Sirv in various ways:</p>

          <ol>
            <li>Browser</li>
            <li>FTP</li>
            <li>S3</li>
          </ol>

          <p>To upload through your browser, either drag and drop images into your <a href="admin.php?page=sirv/sirv/media_library.php" target="_blank">Sirv Media Library</a>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/upload-through-your-browser.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>You can also upload images after clicking <strong>Add Sirv Media</strong> from any page/post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-Sirv-Media-from-any-page.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Upload by FTP by copying <a href="https://my.sirv.com/#/account/settings" target="_blank">your Sirv FTP settings</a>. Either <a href="https://sirv.com/help/resources/upload-images-with-filezilla/" target="_blank">configure FileZilla</a> or another FTP program.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-static"></a>
              Embed static images
            </h2>

            <p>Static images are fixed in width or height. Whatever width or height you choose, Sirv will generate a new perfectly sized image on-the-fly. You can also add options to crop, change the canvas, add watermarks, add text, rotate, adjust colours, vignette and borders. See examples of all the <a href="https://sirv.com/help/resources/dynamic-imaging/%5Ddynamic" target="_blank">dynamic</a> imaging options[/a].</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the image(s) you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/static-image-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/static-image-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. You will see your image(s) embedded in your page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/static-image-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the image(s) in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/static-image-save-and-enjoy.png?profile=wp-plugin-help" class="card" alt=""></p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-responsive"></a>
              Embed responsive images
            </h2>

            <p>Responsive images are perfectly resized to fit the screen. During page load, Sirv detects the users' device, browser and screen size and generates an ideal image. This prevents images being larger than necessary and speeds up page loading.</p>

            <p>Images can also be lazy loaded, if they come into view. This can also reduce the total size of your page significantly and speed up loading.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the image(s) you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/responsive-images-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/responsive-images-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. You will see your image(s) embedded in your page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/responsive-images-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the image(s) in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/responsive-images-save-and-enjoy.png?profile=wp-plugin-help" class="card" alt=""></p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-gallery"></a>
              Embed image galleries
            </h2>

            <p>Image galleries are a great way to display lots of images. Galleries have one large image and lots of small images. Click the small images to swap the large image.</p>

            <p>Images are dynamically generated on-the-fly, to perfectly fit the users screen - not too big, not too small. Served over Sirv's CDN, its a fast and easy way to serve beautiful photo galleries.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the image(s) you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-gallery-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-gallery-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. You will see your images embedded in your page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-gallery-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the images in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-gallery-save-and-enjoy.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Get some inspiration! Check out <a href="https://sirv.com/demos/" target="_blank">11 examples</a> of zoom, responsive and 360 spin images using Sirv.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-zoom-image"></a>
              Embed zoom images
            </h2>

            <p>Sirv Zoom quickly zooms deep inside large images. The bigger your image, the better. They always load fast - even huge images - because of the way Sirv generates hundreds of tiny square images. Just like Google Maps, you can zoom and pan any image, effortlessly.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the image you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-zoom-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-zoom-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. Your image will show as a gallery. You can edit it with the settings icon and delete it with the X icon.</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-zoom-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the image in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/image-zoom-save-and-enjoy.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Get some inspiration! Check out <a href="https://sirv.com/demos/" target="_blank">11 examples</a> of zoom, responsive and 360 spin images using Sirv.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-zoom-galleries"></a>
              Embed zoom galleries
            </h2>

            <p>Sirv Zoom images can be embedded as a gallery. Perfectly for displaying lots of high resolution images, it has a stunning full-screen option that enlarges your image to the entire screen. Click between thumbnails to swap the images.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the images you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/zoom-gallery-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/zoom-gallery-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. Your images will show as a gallery, with arrows to navigate between thumbnails. You can edit it with the settings icon and delete it with the X icon.</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/zoom-gallery-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the images in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/zoom-gallery-save-and-enjoy.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Get some inspiration! Check out <a href="https://sirv.com/demos/" target="_blank">11 examples</a> of zoom, responsive and 360 spin images using Sirv.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-spin"></a>
              Embed 360 spins
            </h2>

            <p>Sirv Spin is the ultimate way to embed 360 spinning images in your site. Images automatically scale to fit the page or can be embedded at a fixed size. They load fast and can contain watermarks, text overlays and image effects.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the spin you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/360-spin-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/360-spin-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. Your spin will show as a gallery. You can edit it with the settings icon and delete it with the X icon.</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/360-spin-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>5. Save your page and enjoy the spin in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/360-spin-save-and-enjoy.gif?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Get some inspiration! Check out <a href="https://sirv.com/demos/" target="_blank">11 examples</a> of zoom, responsive and 360 spin images using Sirv.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-zoom-and-spin"></a>
              Embed spins &amp; zooms
            </h2>

            <p>Show a mixture of zoomable images and 360 spin images. Sirv can create a gallery of images and display them as a main image with thumbnails to switch image. A great way to showcase products with 360 spins and highly detailed zooms.</p>

            <p>1. Click the <strong>Add Sirv Media</strong> button on a page or post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/add-sirv-media.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>2. Click the spins and images you wish to embed:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/spin-and-zoom-click-the-image.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>3. Choose your options and click Insert into page:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/spin-and-zoom-choose-your-options.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>4. Your spins and zooms will show as a gallery. You can edit it with the settings icon and delete it with the X icon.</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/spin-and-zoom-see-your-images.png?profile=wp-plugin-help" class="card" alt=""></p>

            <p>.5. Save your page and enjoy the spin/zoom gallery in your post:</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/spin-and-zoom-save-and-enjoy.gif?profile=wp-plugin-help" class="card" alt=""></p>

            <p>Get some inspiration! Check out <a href="https://sirv.com/demos/" target="_blank">11 examples</a> of zoom, responsive and 360 spin images using Sirv.</p>


            <h2>
              <a class="sirv-anchor-help" id="sirv-help-serve-other-files"></a>
              Serve other files
            </h2>

            <p>Rapidly serve your other files from Sirv too. It is designed to quickly deliver any static files over its global CDN using HTTPS to all your users around the world.</p>

            <p>All kinds of file can be served:</p>

            <ul>
              <li>CSS</li>
              <li>JS</li>
              <li>SVG</li>
              <li>ICO</li>
              <li>PDF</li>
              <li>CSV</li>
              <li>XML</li>
              <li>Fonts</li>
              <li>Documents</li>
              <li>Spreadsheets</li>
              <li>Presentations</li>
            </ul>

            <p>Upload your images to your Sirv account, then copy the CDN link and use it in your page.</p>

            <p><img src="https://sirv-cdn.sirv.com/website/screenshots/wordpress/serve-other-files.png?profile=wp-plugin-help" class="card" alt=""></p>

            <h2>
              <a class="sirv-anchor-help" id="sirv-help-learn-more"></a>
              Learn more about Sirv
            </h2>

            <p>Use your Sirv account for your other websites too (not just WordPress). Files hosted on Sirv can be served to any website including Magento, Drupal, Squarespace, Joomla, PrestaShop and custom built sites.</p>

            <p>Search our <a href="https://sirv.com/help" target="_blank">Help Center</a>, for tutorials that get the best out of Sirv.</p>

            <p>Popular articles:</p>

            <ul>
              <li><a href="https://sirv.com/help/resources/dynamic-imaging" target="_blank">Dynamic imaging guide</a> - for resizing, watermarking, optimizing and all other dynamic options.</li>
              <li><a href="https://sirv.com/help/resources/responsive-imaging/" target="_blank">Responsive imaging guide</a> - for serving images to perfectly fit each users screen.</li>
              <li><a href="https://sirv.com/help/resources/sirv-zoom/" target="_blank">Zoom guide</a> - for customizing your deep image zooms.</li>
              <li><a href="https://sirv.com/help/resources/sirv-spin/" target="_blank">360 guide</a> - for customizing your 360 spins.</li>
            </ul>
        </div>
      </div>

    </div>

    <div class="sirv-tab-content" id="sirv-feedback">
      <!-- <h2>How can we help?</h2> -->
      <!-- <p>
                Search our <a target="_blank" href="https://sirv.com/help">help section</a>, for tutorials that help you get the best out of Sirv.<br /><br />
                <a href="mailto:support@sirv.com">support@sirv.com</a>
                Popular articles:
            </p>
            <ul style="list-style-type: circle; padding-left: 2%;">
                <li><a href="https://sirv.com/help/resources/dynamic-imaging">Dynamic imaging guide</a> - for resizing, watermarking, optimizing and all other dynamic options</li>
                <li><a href="https://sirv.com/help/resources/responsive-imaging/">Responsive imaging guide</a> - for serving images to perfectly fit each users screen</li>
                <li><a href="https://sirv.com/help/resources/sirv-zoom/">Zoom guide</a> - for customizing your deep image zooms</li>
                <li><a href="https://sirv.com/help/resources/sirv-spin/">360 guide</a> - for customizing your 360 spins</li>
            </ul>
            <br /> -->
      <p>
        <h2>Contact us</h2>
        <div class="sirv-optiontable-holder">
          <table class="optiontable form-table">
            <tr>
              <td>
                <label class='required'><b>Your name:</b></label>
                <input type="text" name="name" id="sirv-writer-name">
              </td>
            </tr>
            <tr>
              <td>
                <label class='required'><b>Your email:</b></label>
                <input type="text" name="contact-email" id="sirv-writer-contact-email">
              </td>
            </tr>
            <!--<tr>
                        <td>
                            <label>Priority:</label>
                            <select id="sirv-priority" name="priority">
                                <option label="Low" value="Low">Low</option>
                                <option label="Normal" value="Normal" selected="selected">Normal</option>
                                <option label="High" value="High">High</option>
                                <option label="Urgent" value="Urgent">Urgent</option>
                            </select>
                        </td>
                    </tr>-->
            <tr>
              <td>
                <label class='required'><b>Summary:</b></label>
                <input type="text" name="summary" id="sirv-summary">
              </td>
            </tr>
            <tr>
              <td>
                <label class='required'><b>Describe your issue or share your ideas:</b></label>
                <textarea style="width:100%;height:200px;" name="text" id="sirv-text"></textarea>
              </td>
            </tr>


            <tr>
              <td>
                <input id="send-email-to-magictoolbox" type="button" class="button-primary test-connect" value="Send message">
                <div class="sirv-show-result"></div>
              </td>
            </tr>
          </table>
        </div>

    </div>

    <input type="hidden" name="active_tab" id="active_tab" value="#sirv-account" />
    <input type="hidden" name="action" value="update" />
    <!-- <input type="hidden" name="page_options" value="SIRV_FOLDER, SIRV_ENABLE_CDN, SIRV_NETWORK_TYPE, SIRV_SHORTCODES_PROFILES, SIRV_CDN_PROFILES, SIRV_USE_SIRV_RESPONSIVE, SIRV_JS, SIRV_JS_FILE, SIRV_CDN_URL" /> -->
    <input type="hidden" name="page_options" value="<?php echo implode(', ', $options_names); ?>" />

  </form>
</div>
