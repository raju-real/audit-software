$(function() {
    var pads = {};

    function resizeCanvas(canvas) {
        // Handle high DPI screens
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = $(canvas).width() * ratio;
        canvas.height = 200 * ratio; // Fixed 200px height or change as needed
        canvas.getContext("2d").scale(ratio, ratio);
    }

    $("canvas[id^='sigpad_']").each(function() {
        var $canvas = $(this)[0];
        resizeCanvas($canvas); // Resize properly
        var id = $($canvas).attr("id").replace("sigpad_", "");
        var signaturePad = new SignaturePad($canvas);
        pads[id] = signaturePad;

        // On form submit
        $($canvas).closest("form").on("submit", function() {
            if (!signaturePad.isEmpty()) {
                $("#siginput_" + id).val(signaturePad.toDataURL("image/png"));
            }
        });
    });

    // Clear button
    $(".clear-signature").on("click", function() {
        var targetId = $(this).data("target").replace("sigpad_", "");
        if (pads[targetId]) {
            pads[targetId].clear();
            $("#siginput_" + targetId).val("");
        }
    });

    // Resize canvas when window resizes
    $(window).on("resize", function() {
        $("canvas[id^='sigpad_']").each(function() {
            var id = $(this).attr("id").replace("sigpad_", "");
            var data = pads[id].toData(); // save current drawing
            resizeCanvas(this);
            pads[id].fromData(data); // restore drawing
        });
    });
});
