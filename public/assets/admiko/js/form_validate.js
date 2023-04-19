/*validate on user input*/
/*validate on user input*/
/*validate on user input*/
if ($('.formPage').length > 0) {

    /*save button spinner*/
    var saveButtonText = '';
    $('.save-button').on('click', function (event) {
        saveButtonText = $(this).html();
        $(this).html('<div class="h-100 d-flex align-items-center justify-content-around"><div class="spinner-border spinner-border-sm" role="status"></div></div>');
    });

    $(".limitPozNegDecNumbers").on("keypress", function (event) {
        return limitPozNegDecNumbers(event, 'keyCheck');
    });
    $(".limitPozNegDecNumbers").on("keyup blur paste", function (event) {
        limitPozNegDecNumbers($(this), 'valCheck');
    });

    $(".limitPozNegNumbers").on("keypress", function (event) {
        return limitPozNegNumbers(event, 'keyCheck');
    });

    $(".limitPozNegNumbers").on("keyup blur paste", function (event) {
        limitPozNegNumbers($(this), 'valCheck');
    });
}


function limitPozNegDecNumbers(element, action) {
    if (action == 'keyCheck') {
        var validate = new RegExp(/^[.\-0-9]*$/);
        if (validate.test(element.key)) {
            return true;
        }
        return false;
    } else if (action == 'valCheck') {
        var nums = element.val();
        if (nums.indexOf('.') == 0) {
            nums = "0.";
            element.val(nums);
        } else if (nums.indexOf('.') == 0 && nums.indexOf('-') == 1) {
            nums = "0.";
            element.val(nums);
        } else if (nums.indexOf('-') == 0 && nums.indexOf('.') == 1) {
            nums = "-0.";
            element.val(nums);
        } else {
            if (nums.indexOf('-') == 0 && nums.length == 1) {
            } else {
                if (typeof element.data('decimal') !== 'undefined') {
                    var dec = element.data('decimal');
                    var ttlNums = nums.length - (nums.indexOf('.') + 1);
                    if (nums.indexOf('.') > 0 && ttlNums > dec) {
                        nums = nums.substr(0, nums.length - (ttlNums - dec));
                    }
                }
                nums = nums.replace(/[^0-9.-]/g, '')       // remove chars except number, hyphen, point.
                    .replace(/(\..*)\./g, '$1')     // remove multiple points.
                    .replace(/(?!^)-/g, '')         // remove middle hyphen.
                    .replace(/^0+(\d)/gm, '$1');
                if (isNaN(nums)) {
                    nums = "";
                }
                element.val(nums);
            }
        }
    }
}

function limitPozNegNumbers(element, action) {
    if (action == 'keyCheck') {
        var validate = new RegExp(/^[\-0-9]*$/);
        if (validate.test(element.key)) {
            return true;
        }
        return false;
    } else if (action == 'valCheck') {
        var nums = element.val();
        if (nums.indexOf('-') == 0 && nums.length == 1) {
        } else {

            nums = nums.replace(/[^0-9.-]/g, '')       // remove chars except number, hyphen, point.
                .replace(/(\.*)\./g, '$1')     // remove multiple points.
                .replace(/(?!^)-/g, '')         // remove middle hyphen.
                .replace(/^0+(\d)/gm, '$1');
            nums = parseInt(nums);
            if (isNaN(nums)) {
                nums = "";
            }
        }
        element.val(nums);
    }
}


/*validate fields on form submit*/
/*validate fields on form submit*/
/*validate fields on form submit*/

$('.formPage form.needs-validation').on('submit', function (event) {
    var form = $(this)[0];

    validateFields();

    if (form.checkValidity() === false) {
        $('.save-button').html(saveButtonText);
        event.preventDefault();
        event.stopPropagation();
    }
    form.classList.add('was-validated');
});

function validateFields() {
    validateMinMaxNumbers();
    validateDate();
    validateFiles();
}

function validateMinMaxNumbers() {
    $(".limitPozNegDecNumbers").each(function (e) {
        if ($(this).prop('required')) {
            minMaxNumbersCheck($(this));
        }
    })
    $(".limitPozNegNumbers").each(function (e) {
        if ($(this).prop('required')) {
            minMaxNumbersCheck($(this));
        }
    })
}

function minMaxNumbersCheck(element) {
    var nums = element.val();
    if (typeof element.data('min') !== 'undefined' || typeof element.data('max') !== 'undefined') {
        if (element.data('min') > nums || element.data('max') < nums) {
            element[0].setCustomValidity('Invalid value!');
        } else {
            element[0].setCustomValidity('');
        }
    }
}

function validateDate() {
    $(".datePicker").each(function (e) {
        if ($(this).prop('required')) {
            var datePicker = moment($(this).val(), $(this).data('date_time_format'), true).isValid();
            if (datePicker === false) {
                $(this)[0].setCustomValidity('Invalid date!');
            } else {
                $(this)[0].setCustomValidity('');
            }
        }
    })
    $(".dateTimePicker").each(function (e) {
        if ($(this).prop('required')) {
            var datePicker = moment($(this).val(), $(this).data('date_time_format'), true).isValid();
            if (datePicker === false) {
                $(this)[0].setCustomValidity('Invalid date and time!');
            } else {
                $(this)[0].setCustomValidity('');
            }
        }
    })
}

function validateFiles() {

    $(".fileUpload,.imageUpload").each(function (e) {
        var requiredCheck = true;
        var typeCheck = true;
        var sizeCheck = true;
        var fileName = $(this).val();
        var idName = $(this).attr('id');
        var errorText = '';

        if ($(this).prop('required') && fileName == '' && $('#' + idName + '_admiko_current').val() == '') {
            requiredCheck = false;
            errorText = $(this).siblings(".invalid-feedback").data('required');
        }

        if (typeof $(this).data('type') !== 'undefined' && this.files[0]) {
            var extension = '.' + fileName.split('.').pop();
            if ($(this).data('type').split(",").indexOf(extension) < 0) {
                typeCheck = false;
                errorText = errorText + ' ' + $(this).siblings(".invalid-feedback").data('type');
            }
        }

        if (typeof $(this).data('size') !== 'undefined' && this.files[0]) {
            var fileSize = this.files[0].size / 1048576;
            if (fileSize > $(this).data('size')) {
                sizeCheck = false;
                errorText = errorText + ' ' + $(this).siblings(".invalid-feedback").data('size');
            }
        }
        if (requiredCheck == true && typeCheck == true && sizeCheck == true) {
            $(this)[0].setCustomValidity('');
        } else {
            $(this).siblings(".invalid-feedback").text(errorText);
            $(this)[0].setCustomValidity('Invalid file size or type!');
        }
    })
}
