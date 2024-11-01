(function( $ ) {
	'use strict';

	window.WPDashboard = {

	    set_api_key: function(key) {
	        this.api_key = key;
        },

        remove_from_wp_dashboard: function() {
            let data = new FormData();
            data.append("key", this.api_key);
            let xhr = new XMLHttpRequest();
            xhr.addEventListener("readystatechange", function () {
                if (this.readyState === 4) {
                    let resp = JSON.parse(this.responseText);
                    if(resp.success) {
                        location.href = '?page=wpdashboard_menu&action=remove_plugin' + location.hash;
                    }
                }
            });
            xhr.open("POST", "http://my.wpdashboard.io/api/plugin/remove");
            xhr.send(data);
        }

    }

})( jQuery );
