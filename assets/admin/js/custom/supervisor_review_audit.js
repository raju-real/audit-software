$(document).ready(function () {
    // The selector now targets a common class for all submit buttons
    $('.dynamic-submit-btn').on('click', function () {
        // Get the ID of the form to submit from the data attribute
        const formId = $(this).data('form-id');
        const form = $('#' + formId);

        // Find all required fields within this specific form
        const requiredInputs = form.find('[required]');
        let isValid = true;

        // Loop through each required input and validate it
        requiredInputs.each(function () {
            const input = $(this);
            const errorSpan = input.siblings('.text-danger'); // Assuming error spans are siblings
            
            if (input.val().trim() === '') {
                errorSpan.text('This field is required.');
                input.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                errorSpan.text('');
                input.addClass('is-valid').removeClass('is-invalid');
            }
        });

        // If all fields are valid, submit the form
        if (isValid) {
            form.submit();
        }
    });

    // Handle the live feedback and reset on modal close for all modal forms
    $('.modal-validated-form').each(function() {
        const form = $(this);
        const modal = form.closest('.modal'); // Find the parent modal
        
        // Add keyup listener to all required inputs in this form
        form.find('[required]').on('keyup', function () {
            if ($(this).val().trim() !== '') {
                $(this).addClass('is-valid').removeClass('is-invalid');
                $(this).siblings('.text-danger').text('');
            }
        });

        // Reset the form state when its parent modal is hidden
        modal.on('hidden.bs.modal', function () {
            form[0].reset();
            form.find('[required]').removeClass('is-valid is-invalid');
            form.find('.text-danger').text('');
        });
    });
});