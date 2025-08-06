(function ($) {
    "use strict";

    const previewBtn = document.getElementById("preview-trigger");
    const fileInput = document.getElementById("balance_sheet_input");
    const previewContainer = document.getElementById("html-preview");
    const previewWrapper = document.getElementById("preview-wrapper");

    // Enable preview button when file selected
    fileInput.addEventListener("change", function () {
        const hasFile = this.files.length > 0;
        previewBtn.disabled = !hasFile;

        if (hasFile) {
            previewContainer.innerHTML = "";
            previewWrapper.classList.add("d-none");
        }
    });

    // Handle preview click
    previewBtn.addEventListener("click", function () {
        const file = fileInput.files[0];

        if (!file) {
            alert("Please choose a file first.");
            return;
        }

        const formData = new FormData();
        formData.append("file", file);

        previewBtn.textContent = "Loading...";
        previewBtn.disabled = true;

        previewContainer.innerHTML = "";
        previewWrapper.classList.remove("d-none");

        axios.post(AppHelpers.base_url + "/xl-file-preview", formData)
            .then((response) => {
                previewBtn.textContent = "Preview";
                previewBtn.disabled = false;

                previewContainer.innerHTML = response.data.html;
                previewWrapper.classList.remove("d-none");

                // Add table class
                previewContainer.querySelectorAll("table").forEach((table) => {
                    table.classList.add("custom-preview-table");
                });
            })
            .catch((error) => {
                console.error(error);
                previewBtn.textContent = "Preview";
                previewBtn.disabled = false;

                previewContainer.innerHTML = '<p class="text-danger">Failed to preview.</p>';
                previewWrapper.classList.remove("d-none");
            });
    });
})(jQuery);
