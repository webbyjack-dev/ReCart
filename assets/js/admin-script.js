jQuery(document).ready(function($) {
    // Nav Dropdown Logic
    $('.rc-nav-dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#rc-date-menu').fadeOut(100);
        $(this).siblings('.rc-nav-dropdown-menu').slideToggle(150);
    });

    // CRM Toggle
    $('#wj_crm_provider').on('change', function() {
        $('#wj-hubspot-config, #wj-mailchimp-config').hide();
        if ( $(this).val() === 'hubspot' ) {
            $('#wj-hubspot-config').slideDown();
            $('#rc-integrations-footer').show();
        } else if ( $(this).val() === 'mailchimp' ) {
            $('#wj-mailchimp-config').slideDown();
            $('#rc-integrations-footer').hide();
        } else {
            $('#rc-integrations-footer').show();
        }
    });
    $('#wj_crm_provider').trigger('change');

    // Email Engine Toggle
    $('#wj_email_engine').on('change', function() {
        if ( $(this).val() === 'smtp' ) {
            $('#wj-smtp-config').slideDown();
        } else {
            $('#wj-smtp-config').slideUp();
        }
    });

    // Date Picker Toggle Logic
    $('#rc-date-toggle').on('click', function(e) {
        e.stopPropagation();
        $('.rc-nav-dropdown-menu').slideUp(150);
        $('#rc-date-menu').fadeToggle(100);
    });

    // Close all dropdowns on outside click
    $(document).on('click', function() {
        $('#rc-date-menu').fadeOut(100);
        $('.rc-nav-dropdown-menu').slideUp(150);
    });
});
