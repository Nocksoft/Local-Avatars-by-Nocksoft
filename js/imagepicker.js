(function() {
	if (!document.body.contains(document.getElementById("nstla_setavatar"))) return;
	
	
	var img = document.getElementById("nstla_avatar");
	var inputUrl = document.getElementById("nstla_setting_avatarurl");
	var inputId = document.getElementById("nstla_setting_avatarid");

	var imagepicker = wp.media({
		library : {
			type : "image"
		},
		multiple: false
	});


	document.getElementById("nstla_setavatar").addEventListener("click", function() {
		if (imagepicker) {
			imagepicker.open();
		}
	});

	imagepicker.on("select", function() {
		var image = imagepicker.state().get("selection").first().toJSON();
		img.setAttribute("src", image.url);
		inputUrl.setAttribute("value", image.url);
		inputId.setAttribute("value", image.id);
	});

	imagepicker.on("open", function() {
		var id = inputId.getAttribute("value");
		if (id) {
			var selection = imagepicker.state().get("selection");
			attachment = wp.media.attachment(id);
			attachment.fetch();
			selection.add(attachment ? [attachment] : []);
		}
	});

	document.getElementById("nstla_deleteavatar").addEventListener("click", function() {
		var url = inputUrl.getAttribute("gravatarurl");
		img.setAttribute("src", url);
		inputUrl.setAttribute("value", url);
	});

})();