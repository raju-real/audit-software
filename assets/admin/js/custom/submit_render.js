$(function () {
    let formData = window.formData || [];
    const responses = window.responses || {};

    // Ensure array
    if (typeof formData === "string") {
        try {
            formData = JSON.parse(formData);
        } catch (e) {
            formData = [];
        }
    }

    // Render only supported fields
    const supportedFields = formData.filter(
        (f) => f.type !== "signature" && f.type !== "paragraph"
    );
    $("#rendered-form").formRender({ formData: supportedFields });

    // Handle custom fields
    formData.forEach((field, index) => {
        let $target = $("#rendered-form")
            .find(`[name="${field.name}"]`)
            .closest(".form-group");
        // Select the rendered input by name
        const $input = $(`#rendered-form [name="${field.name}"]`);

        // Add text-center class if type is header
        if (field.type === "header" && $input.length) {
            $input.addClass("text-center");
        }
        // Add datepicker class if type is date
        if (field.type === "date" && $input.length) {
            $input.attr("type", "text");
            $input.addClass("datepicker");
            $input.datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
            });
        }
        // Add form select class if type is select
        if (field.type === "select" && $input.length) {
            $input.removeClass("form-control").addClass("form-select");
        }

        // Populate signature response
        if (field.type === "signature") {
            if ($target.length === 0) {
                $("#rendered-form").append(
                    `<div class="form-group" id="group_${field.name}"><label>${field.label}</label></div>`
                );
                $target = $("#group_" + field.name);
            } else {
                $target.find("input, textarea, select").remove();
            }

            const canvasId = "sigpad_" + field.name;
            const inputId = "siginput_" + field.name;

            $target.append(`
                <div class="signature-wrapper">
                    <canvas id="${canvasId}" class="signature-pad" height="150"></canvas>
                    <input type="hidden" name="${field.name}" id="${inputId}">
                    <button type="button" class="btn btn-sm btn-secondary mt-2 clear-signature" data-target="${canvasId}">Clear</button>
                </div>
            `);
        }
        // Populate paragraph response
        if (field.type === "paragraph") {
            // Always create a unique container
            const groupId = `group_paragraph_${index}`;
            $("#rendered-form").append(
                `<div class="form-group" id="${groupId}"></div>`
            );
            const $target = $(`#${groupId}`);

            const decodedValue = decodeParagraph(field.label ?? "");

            $target.html(`
                <textarea id="paragraph_${index}" 
                        name="paragraph_${index}" 
                        class="readonly-paragraph mt-2" rows="4" 
                        readonly>${decodedValue}</textarea>
            `);
        }
    });

    // Helper: Decode HTML entities AND strip HTML tags
    function decodeParagraph(htmlString) {
        const txt = document.createElement("textarea");
        txt.innerHTML = htmlString; // decode entities
        const decoded = txt.value;

        // Strip HTML tags
        const div = document.createElement("div");
        div.innerHTML = decoded;
        return div.textContent || div.innerText || "";
    }
});
