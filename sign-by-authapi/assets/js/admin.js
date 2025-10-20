/**
 * Admin JavaScript
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Test LibreSign Connection
        $('.sign-test-connection').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            button.prop('disabled', true).text('Testing...');

            $.ajax({
                url: signAdminData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'sign_test_libresign_connection',
                    nonce: signAdminData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        alert('Connection successful!');
                    } else {
                        alert('Connection failed: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Connection test failed. Please check your settings.');
                },
                complete: function() {
                    button.prop('disabled', false).text('Test Connection');
                }
            });
        });

        // Color picker initialization
        if (typeof $.fn.wpColorPicker !== 'undefined') {
            $('.sign-color-picker').wpColorPicker();
        }

        // Confirm delete actions
        $('.sign-delete-action').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
                return false;
            }
        });
    });

})(jQuery);
