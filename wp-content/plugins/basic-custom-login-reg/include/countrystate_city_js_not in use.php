<script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#user_country').on('change', function () {
                console.log(jQuery(this).val());
                var countryID = jQuery(this).val();
                if (countryID) {
                    //var url = '<?php echo get_template_directory_uri()?>/ajaxData.php';
                    
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: 'countryID='+countryID,
                        success: function (response) {
                        	//console.log('**********'+response);
                            jQuery('#user_state').html(response);
                            jQuery('#user_city').html('<option value="">Select state first</option>');
                        }
                    });
                } else {
                    jQuery('#user_state').html('<option value="">Select country first</option>');
                    jQuery('#user_city').html('<option value="">Select state first</option>');
                }
            });

            jQuery('#user_state').on('change', function () {
                var stateID = jQuery(this).val();
               // var url = '<?php echo get_template_directory_uri()?>/ajaxData.php';
                if (stateID) {
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: 'state_id=' + stateID,
                        success: function (response) {
                            jQuery('#user_city').html(response);
                        }
                    });
                } else {
                    jQuery('#user_city').html('<option value="">Select state first</option>');
                }
            });
        });
</script>