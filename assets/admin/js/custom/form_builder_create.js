$(function () {
    // Initialize fields array: existing fields if in edit mode, else empty
    let fields = window.existingFields ? JSON.parse(JSON.stringify(window.existingFields)) : [];

    const $area = $("#builder-area");
    const $fieldsJson = $("#fields-json");

    // Render all fields in builder
    function renderFields() {
        $area.empty();

        $.each(fields, function (idx, f) {
            let optionsHtml = f.options ? f.options.map(o => `<li>${o}</li>`).join('') : '';
            let paragraphHtml = f.paragraph ? `<div><textarea class="form-control" readonly>${f.paragraph}</textarea></div>` : '';

            const html = `
                <div class="field-item border bg-white p-2 mb-2" data-index="${idx}">
                    <div class="d-flex justify-content-between">
                        <strong>${f.label}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-field">Remove</button>
                    </div>
                    <div>Type: ${f.type}</div>
                    <div>Required: ${f.required ? "Yes" : "No"}</div>
                    ${f.multiple ? `<div>Multiple: Yes</div>` : ""}
                    ${optionsHtml ? `<div>Options:<ul>${optionsHtml}</ul></div>` : ""}
                    ${paragraphHtml}
                </div>
            `;

            $area.append(html);
        });

        // Update hidden input for submission
        $fieldsJson.val(JSON.stringify(fields));
    }

    // Add Field button click
    $("#add-field, #add-field-btn").on("click", function () {
        let label = $("#field-label").val().trim();
        let type = $("#field-type").val();
        const required = $("#field-required").is(":checked");
        const multiple = (type === "file") ? $("#field-multiple").is(":checked") : false;

        let options = null;
        let paragraph = null;

        // Paragraph field
        if (type === "paragraph") {
            paragraph = $("#field-paragraph").val().trim();
            if (!paragraph) {
                alert("Paragraph content cannot be empty");
                return;
            }
            // Paragraph label fallback if empty
            if (!label) label = "Paragraph";
        } else {
            if (!label) {
                alert("Field label cannot be empty");
                return;
            }
            // Uppercase first letter
            label = label.charAt(0).toUpperCase() + label.slice(1);
        }

        // Options for select/checkbox/radio
        if (["select", "checkbox", "radio"].includes(type)) {
            const opts = $("#field-options").val().trim();
            options = opts ? opts.split(",").map(s => s.trim()) : [];
        }

        // Add field to array
        fields.push({ label, type, options, paragraph, required, multiple, placeholder: "" });

        // Reset inputs
        $("#field-label").val("");
        $("#field-options").val("");
        $("#field-paragraph").val("");
        $("#field-required").prop("checked", false);
        $("#field-multiple").prop("checked", false);
        $("#options-wrapper, #multiple-wrapper, #paragraph-wrapper").hide();

        renderFields();
    });

    // Remove field
    $area.on("click", ".remove-field", function () {
        const idx = $(this).closest(".field-item").data("index");
        fields.splice(idx, 1);
        renderFields();
    });

    // Show/hide extra inputs based on type
    $("#field-type").on("change", function () {
        const type = $(this).val();

        if (["select", "checkbox", "radio"].includes(type)) {
            $("#options-wrapper").show();
        } else {
            $("#options-wrapper").hide();
            $("#field-options").val("");
        }

        if (type === "file") {
            $("#multiple-wrapper").show();
        } else {
            $("#multiple-wrapper").hide();
            $("#field-multiple").prop("checked", false);
        }

        if (type === "paragraph") {
            $("#paragraph-wrapper").show();
        } else {
            $("#paragraph-wrapper").hide();
            $("#field-paragraph").val("");
        }
    });

    // Make fields draggable
    new Sortable($area[0], {
        animation: 150,
        onEnd: function (evt) {
            const item = fields.splice(evt.oldIndex, 1)[0];
            fields.splice(evt.newIndex, 0, item);
            renderFields();
        }
    });

    // Initial render
    renderFields();
});
