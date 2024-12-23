jQuery(document).ready(function() {
    jQuery('#logPageView').click(function() {
        var page_id = 123; // Replace this with the actual page ID

        jQuery.ajax({
            url: '/wp-json/easyanalytics/v1/addPageView',
            type: 'POST',
            data: {
                'page_id': page_id
            },
            success: function(response) {
                console.log('Page view logged successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error logging page view:', error);
            }
        });
    });
});

jQuery(document).ready(function() {
    jQuery('#logPageAnalytics').click(function() {
        var page_id = 123,
        time_on_page = 12.34,
        bounce_rate = 43.21;

        jQuery.ajax({
            url: '/wp-json/easyanalytics/v1/addPageAnalytics',
            type: 'POST',
            data: {
                'page_id': page_id,
                'time_on_page': time_on_page,
                'bounce_rate': bounce_rate
            },
            success: function(response) {
                console.log('Page view logged successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error logging page view:', error);
            }
        });
    });
});

jQuery(document).ready(function() {
    jQuery('#logUserInteraction').click(function() {
        var page_id = 123,
        user_action = "Click"; 

        jQuery.ajax({
            url: '/wp-json/easyanalytics/v1/addUserInteraction',
            type: 'POST',
            data: {
                'page_id': page_id,
                'user_action': user_action
            },
            success: function(response) {
                console.log('Page view logged successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error logging page view:', error);
            }
        });
    });
});

