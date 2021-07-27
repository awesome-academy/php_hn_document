var fileTypes = ['jpeg', 'png', 'jpg'];
imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        var extension = file.name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;
        if (isSuccess) {
            this.value = file.name
            blah.src = URL.createObjectURL(file)
        }
    }
}
(function () {
    var constraints = {
        email: {
            presence: true,
            email: true
        },
        password: {
            presence: true,
            length: {
                minimum: 8
            }
        },
        "password_confirmation": {
            presence: true,
            equality: {
                attribute: "password",
                message: "^The passwords does not match"
            }
        },
        name: {
            presence: true,
            length: {
                minimum: 3,
                maximum: 20,
                message: "must be more than 3 letters"
            },
        },
        phone: {
            presence: false,
            format: {
                pattern: "^(0)[0-9]{9}",
                flags: "i",
                message: "can only 10 numbers from 0-9 and start  with '0'"
            }
        },
        about: {
            presence: false,
            length: {
                maximum: 255,
            },
        },
        address: {
            presence: false,
            length: {
                maximum: 255,
            },
        },
    };

    var form = document.querySelector("form#main");

    var inputs = document.querySelectorAll("input, textarea, select")
    for (var i = 0; i < inputs.length; ++i) {
        inputs.item(i).addEventListener("change", function (ev) {
            var errors = validate(form, constraints) || {};
            showErrorsForInput(this, errors[this.name])
        });
    }

    function handleFormSubmit(form, input) {
        var errors = validate(form, constraints);
        showErrors(form, errors || {});
    }

    function showErrors(form, errors) {
        _.each(form.querySelectorAll("input[name], select[name]"), function (input) {
            showErrorsForInput(input, errors && errors[input.name]);
        });
    }

    function showErrorsForInput(input, errors) {
        var formGroup = closestParent(input.parentNode, "form-group")
            , messages = formGroup.querySelector(".messages");
        resetFormGroup(formGroup);
        if (errors) {
            formGroup.classList.add("has-error");
            _.each(errors, function (error) {
                addError(messages, error);
            });
        }
    }

    function closestParent(child, className) {
        if (!child || child == document) {
            return null;
        }
        if (child.classList.contains(className)) {
            return child;
        } else {
            return closestParent(child.parentNode, className);
        }
    }

    function resetFormGroup(formGroup) {
        formGroup.classList.remove("has-error");
        _.each(formGroup.querySelectorAll(".errorInput"), function (el) {
            el.parentNode.removeChild(el);
        });
    }
    function addError(messages, error) {
        var block = document.createElement("p");
        block.classList.add("errorInput");
        block.classList.add("text-danger");
        block.innerText = error;
        messages.appendChild(block);
    }
})();
