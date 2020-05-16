vanilla = $("#image_demo").croppie({
	enableExif: true,
	viewport: { width: 200, height: 200, type: "circle" }, // circle or square
	boundary: { width: 300, height: 300 },
	showZoomer: false,
	enableOrientation: true
  });
  $("#file").on("change", function() {
	var reader = new FileReader();
	reader.onload = function(event) {
	  vanilla
		.croppie("bind", {
		  url: event.target.result
		})
		.then(function() {
		  // console.log('jQuery bind complete');
		});
	};
	reader.readAsDataURL(this.files[0]);
	$("#uploadimageModal").modal("show");
  });
  $("#cropImageBtn").click(function(event) {
	vanilla.croppie('result', {
			type: 'base64',
			format: 'jpeg'
			
		}).then(function (resp) {
			$('#item-img-output').attr('src', resp);
			$('#uploadimageModal').modal('hide');
		});
  });
