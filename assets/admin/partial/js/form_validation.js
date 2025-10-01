// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    "use strict";
    // Only for Select2 focus fix
    $(document).on("change", ".required-checker", function () {
        $(this).siblings(".select2-container").css({
            "border": "1px solid #d8d6de"
        });
    });
    // Select2 focus fix end 
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener(
            "submit",
            function (event) {
                // Only for Select2 focus fix
                let isValid = true;
                $(".required-checker").each(function () {
                    if ($(this).val() == "") {
                        if ($(this).data("select2")) {
                            $(".select2-selection--single").css(
                                "border",
                                "none"
                            );
                            let op1 = $(this).data("select2");
                            if (focus == 1) {
                                op1.open();
                                focus++;
                            }
                            $(this).siblings(".select2-container").css({
                                border: "1px solid #f46a6a",
                                "border-radius": "4px",
                            });
                            isValid = false;
                        } else {
                            $(this).focus();
                            $(this).css("border-color", "#f46a6a");
                            isValid = false;
                        }
                    } else {
                        if ($(this).data("select2")) {
                            $(this).siblings(".select2-container").css({
                                "border": "1px solid #d8d6de",
                                "border-radius": "4px",
                            });
                        } else {
                            $(this).css("border-color", "#d8d6de");
                        }
                    }
                });
                // Select2 focus fix end    

                // Check native form validity
                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
})();
