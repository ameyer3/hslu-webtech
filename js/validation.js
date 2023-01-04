function validate(event) {
    event.preventDefault();
    validateSection = function (section) {
        let input = section.querySelector("input,select,textarea");
        let errorElement = section.querySelector("span.error-message")
        errorElement.textContent = "";
        if (!input.validity.valid) {
            errorElement.textContent = input.validationMessage;
        }
    }

    let formElement = event.target;
    if (!formElement.checkValidity()) {
        let sections = formElement.querySelectorAll("section");
        for (let section of sections) {
            if (section.id.includes("radio-buttons")) {
                let errorElement = section.querySelector("span.error-message");
                errorElement.textContent = "";
                if (!section.querySelector("input:checked")) {
                    errorElement.textContent = section.querySelector("input").validationMessage;
                }
            } else {
                validateSection(section);
            }
        }
        return false;
    }
    formElement.submit();
    return true;
}

let form = document.querySelector("#review-form")
form.noValidate = true;
form.onsubmit = validate;