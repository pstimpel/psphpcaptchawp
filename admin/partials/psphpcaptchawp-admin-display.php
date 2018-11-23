<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wp.peters-webcorner.de
 * @since      1.0.0
 *
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/admin/partials
 */
?>
<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">
        
        <?php
        //Grab all options
        
        $imagepath = $this->urlRenderImage;
        
        $options = get_option($this->plugin_name);

        if($options == false) {
            $options = Psphpcaptchawp_Admin::getPresets();
        }
        
        $stringlength = $options['stringlength'];
        $charstouse = $options['charstouse'];
        $strictlowercase = $options['strictlowercase'];
        $bgcolor = $options['bgcolor'];
        $textcolor = $options['textcolor'];
        $linecolor = $options['linecolor'];
        $sizewidth = $options['sizewidth'];
        $sizeheight = $options['sizeheight'];
        $fontsize = $options['fontsize'];
        $numberoflines = $options['numberoflines'];
        $thicknessoflines = $options['thicknessoflines'];
        $allowad = $options['allowad'];
        
        $multisite = Psphpcaptchawp_Admin::isMultisite();
        $blogId = Psphpcaptchawp_Admin::getBlogId();
        
        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );
        ?>

        <?php
        if($multisite == true) {
	        
	        echo '<p><strong>';
	        printf(
	                __('This is a multisite installation, each site has its own settings. Blog-Id: %s', 'psphpcaptchawp'),
                    $blogId);
            echo '</strong></p>';
	        
        } else {
	
	        echo '<p><strong>';
	        _e('This is a singlesite installation, turned multisite features off.', 'psphpcaptchawp');
	        echo '</strong></p>';
	
	        
        }
        ?>
        
        <h4><?php echo esc_attr_e('Captcha content','psphpcaptchawp'); ?></h4>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Number of characters', 'psphpcaptchawp');
            ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-stringlength">
                <input type="text" id="<?php echo $this->plugin_name;?>-stringlength" name="<?php echo
                $this->plugin_name;?>[stringlength]"  value="<?php echo $stringlength;?>"  />
                <span><?php esc_attr_e('Number of characters', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Characters allowed', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-charstouse">
                <input type="text" id="<?php echo $this->plugin_name;?>-charstouse" name="<?php echo
                $this->plugin_name;?>[charstouse]"  value="<?php echo $charstouse;?>"  />
                <span><?php esc_attr_e('Characters allowed', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Strict lower case', 'psphpcaptchawp'); ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-strictlowercase">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-strictlowercase" name="<?php echo $this->plugin_name;?>[strictlowercase]" value="1" <?php checked( $strictlowercase, 1 ); ?> />
                <span><?php esc_attr_e( 'Strict lower case', 'psphpcaptchawp' ); ?></span>
            </label>
        </fieldset>


        <h4><?php echo esc_attr_e('Captcha colors','psphpcaptchawp'); ?></h4>
        <fieldset class="wp_cbf-admin-colors">
            <span><?php esc_attr_e('Background Color', 'psphpcaptchawp');?></span>
            <legend class="screen-reader-text"><span><?php _e('Background Color', $this->plugin_name);?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-bgcolor">
                <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo
                'psphpcaptchawp';?>-bgcolor" name="<?php echo $this->plugin_name;?>[bgcolor]"
                       value="<?php echo $bgcolor;?>"  />
            </label>
            
        </fieldset>

        <fieldset class="wp_cbf-admin-colors">
            <span><?php esc_attr_e('Text Color', 'psphpcaptchawp');?></span>
            <legend class="screen-reader-text"><span><?php _e('Text Color', $this->plugin_name);?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-textcolor">
                <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo
                $this->plugin_name;?>-textcolor" name="<?php echo $this->plugin_name;?>[textcolor]"
                       value="<?php echo $textcolor;?>" />
            </label>
        </fieldset>

        <fieldset class="wp_cbf-admin-colors">
            <span><?php esc_attr_e('Line Color', 'psphpcaptchawp');?></span>
            <legend class="screen-reader-text"><span><?php _e('Line Color', $this->plugin_name);?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-linecolor">
                <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo
                $this->plugin_name;?>-linecolor" name="<?php echo $this->plugin_name;?>[linecolor]"
                       value="<?php echo $linecolor;?>" />
            </label>
        </fieldset>

        <h4><?php echo esc_attr_e('Captcha appearance','psphpcaptchawp'); ?></h4>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Image width', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-sizewidth">
                <input type="text" id="<?php echo $this->plugin_name;?>-sizewidth" name="<?php echo
                $this->plugin_name;?>[sizewidth]"  value="<?php echo $sizewidth;?>"  />
                <span><?php esc_attr_e('Image width', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Image height', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-sizeheight">
                <input type="text" id="<?php echo $this->plugin_name;?>-sizeheight" name="<?php echo
                $this->plugin_name;?>[sizeheight]"  value="<?php echo $sizeheight;?>"  />
                <span><?php esc_attr_e('Image height', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Font size', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-fontsize">
                <input type="text" id="<?php echo $this->plugin_name;?>-fontsize" name="<?php echo
                $this->plugin_name;?>[fontsize]"  value="<?php echo $fontsize;?>"  />
                <span><?php esc_attr_e('Font size', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <h4><?php echo esc_attr_e('OCR confusion options','psphpcaptchawp'); ?></h4>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Number of lines', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-numberoflines">
                <input type="text" id="<?php echo $this->plugin_name;?>-numberoflines" name="<?php echo
                $this->plugin_name;?>[numberoflines]"  value="<?php echo $numberoflines;?>"  />
                <span><?php esc_attr_e('Number of lines', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Thickness of lines', 'psphpcaptchawp');
                    ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-thicknessoflines">
                <input type="text" id="<?php echo $this->plugin_name;?>-thicknessoflines" name="<?php echo
                $this->plugin_name;?>[thicknessoflines]"  value="<?php echo $thicknessoflines;?>"  />
                <span><?php esc_attr_e('Thickness of lines', 'psphpcaptchawp');?></span>
            </label>
        </fieldset>
        
        <h4><?php echo esc_attr_e('Allow advertisment for Plugin','psphpcaptchawp'); ?></h4>
        <fieldset>
            <legend class="screen-reader-text"><span><?php _e('Allow small advertisement below Captcha image', 'psphpcaptchawp'); ?></span></legend>
            <label for="<?php echo $this->plugin_name;?>-allowad">
                <input type="checkbox" id="<?php echo $this->plugin_name;?>-allowad" name="<?php echo $this->plugin_name;?>[allowad]" value="1" <?php checked( $allowad, 1 ); ?> />
                <span><?php esc_attr_e( 'Allow small advertisement below Captcha image', 'psphpcaptchawp' ); ?></span>
            </label>
        </fieldset>





        <?php submit_button(__('Save all changes', 'psphpcaptchawp'), 'primary','submit', TRUE); ?>

        
        
    </form>

    <h4><?php echo esc_attr_e('Example captcha','psphpcaptchawp'); ?></h4>

    <p><img src="<?php echo $imagepath; ?>" alt="PS PHPCaptcha WP" title="PS PHPCaptcha WP"/></p>

    <p>&nbsp;</p>
    
    <h3><?php echo esc_attr_e('Reset settings','psphpcaptchawp'); ?></h3>

    <form method="post" name="cleanup_options" action="options.php">
        <?php
        $options = Psphpcaptchawp_Admin::getPresets();


        $stringlength = $options['stringlength'];
        $charstouse = $options['charstouse'];
        $strictlowercase = $options['strictlowercase'];
        $bgcolor = $options['bgcolor'];
        $textcolor = $options['textcolor'];
        $linecolor = $options['linecolor'];
        $sizewidth = $options['sizewidth'];
        $sizeheight = $options['sizeheight'];
        $fontsize = $options['fontsize'];
        $numberoflines = $options['numberoflines'];
        $thicknessoflines = $options['thicknessoflines'];
        
        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );
        
        ?>
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[stringlength]" value="<?php echo $stringlength;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[charstouse]" value="<?php echo $charstouse;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[strictlowercase]" value="<?php echo $strictlowercase;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[bgcolor]" value="<?php echo $bgcolor;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[textcolor]" value="<?php echo $textcolor;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[linecolor]" value="<?php echo $linecolor;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[sizewidth]" value="<?php echo $sizewidth;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[sizeheight]" value="<?php echo $sizeheight;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[fontsize]" value="<?php echo $fontsize;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[numberoflines]" value="<?php echo $numberoflines;?>">
        <input type="hidden"
               name="<?php echo $this->plugin_name;?>[thicknessoflines]" value="<?php echo $thicknessoflines;?>">

        <?php submit_button(__('Set to defaults', 'psphpcaptchawp'), 'delete','submit', TRUE); ?>

    </form>

</div>
