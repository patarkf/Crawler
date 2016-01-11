var SERVICES = {
	onReady: function() {
		$("#submitPageUrl").on("click", SERVICES.handlePageUrlSubmit);
	},

	handlePageUrlSubmit: function() {
		$("#submitPageUrl")
			.html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...')
			.prop('disabled', true);

		$("form").submit();

        setTimeout(SERVICES.setStillWorkingMessage, 20000)
	},

    setStillWorkingMessage: function() {
        $("#submitPageUrl")
            .html(
                '<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> ' +
                'Still working...'
            )
            .prop('disabled', true);
    }
}

$(document).ready(SERVICES.onReady());