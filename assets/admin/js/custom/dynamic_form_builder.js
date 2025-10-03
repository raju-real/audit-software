$(function () {
    let base_url = AppHelpers.base_url;

    // ---------- Load questions on page load ----------
    const audit_step_id = $("#audit_step").val();
    if (audit_step_id) {
        appendStepWiseQuestions(audit_step_id);
    }

    // ---------- On audit step change ----------
    $(document).on("change", "#audit_step", function () {
        const audit_step_id = $(this).val();
        appendStepWiseQuestions(audit_step_id);
    });

    // ---------- Function to append questions ----------
    function appendStepWiseQuestions(audit_step_id) {
        // Clear current options
        $("#question").html('<option value="">Select Question</option>');

        // Fetch step-wise questions
        $.ajax({
            url: base_url + "/audit-step-wise-questions/" + audit_step_id,
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response) {
                    response.forEach(function (item) {
                        const option = $("<option></option>")
                            .val(item.id)
                            .text(item.question);

                        const oldSelectedValue = $("#question").data("old-value");
                        if (
                            oldSelectedValue !== undefined &&
                            oldSelectedValue !== null &&
                            oldSelectedValue === item.id
                        ) {
                            option.attr("selected", "selected");
                        }

                        $("#question").append(option);
                    });
                }
            },
            error: function () {
                console.error("Failed to fetch step-wise questions.");
            },
        });
    }

    let formData = window.formData || [];

    const options = {
        formData,
        fields: [
            {
                label: "Signature",
                attrs: {
                    type: "signature",
                },
                icon: "🖊️",
            },
        ],
        templates: {
            signature: function (fieldData) {
                return {
                    field: '<div class="signature-field" style="border:1px solid grey; padding:5px; min-height:150px; background:#fafafa;width:100%">Signature will appear here</div>',
                    onRender: function () {
                        // preview inside builder only
                    },
                };
            },
        },
    };

    const fbEditor = $("#fb-editor").formBuilder(options);

    $("form").on("submit", function () {
        $("#form_json").val(JSON.stringify(fbEditor.actions.getData()));
    });
});
