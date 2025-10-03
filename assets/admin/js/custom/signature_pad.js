$(function() {
   
    var pads = {};

    function resizeCanvas($canvas) {
        var canvas = $canvas[0];
        var ratio = Math.max(window.devicePixelRatio || 1, 1);

        // Get container width & height
        var width = $canvas.parent().width();
        var height = $canvas.height() || 150; // fallback height if not set

        // Save current data
        var data = pads[canvas.id] ? pads[canvas.id].toData() : null;

        // Resize canvas
        canvas.width = width * ratio;
        canvas.height = height * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // Restore drawing if any
        if (data && pads[canvas.id]) {
            pads[canvas.id].fromData(data);
        }
    }

    $("canvas[id^='sigpad_']").each(function() {
        var $canvas = $(this);
        var id = $canvas.attr("id");

        // Initialize signature pad
        var signaturePad = new SignaturePad($canvas[0]);
        pads[id] = signaturePad;

        // Resize properly first
        resizeCanvas($canvas);

        // On form submit, save base64 to hidden input
        $canvas.closest("form").on("submit", function() {
            if (!signaturePad.isEmpty()) {
                $("#siginput_" + id.replace("sigpad_", "")).val(signaturePad.toDataURL("image/png"));
            }
        });
    });

    // Clear button
    $(".clear-signature").on("click", function() {
        var targetId = $(this).data("target");
        if (pads[targetId]) {
            pads[targetId].clear();
            $("#siginput_" + targetId.replace("sigpad_", "")).val("");
        }
    });

    // Resize on window resize
    $(window).on("resize", function() {
        $("canvas[id^='sigpad_']").each(function() {
            resizeCanvas($(this));
        });
    });
});
