var delLink = 0;
var tableInfoShow = 0;
//keep session alive
var refreshSn = function () {
    var time = 600000; // 10 mins
    settimeout(
        function () {
            $.ajax({
                url: '',
                cache: false,
                complete: function () {
                    refreshSn();
                }
            });
        },
        time
    );
};
$(function () {
    richTextEditor();
    datePicker();
    multiSelect();
    multiSelectSort();
    multiCheckboxSort();
    admikoGlobalSearchStart()
    // multiSelectTags();
    if ($(".tableSort").length > 0) {
        if($(".tableSort .dragMe").length > 0){
            tableInfoShow = dragDropTableInfo;
            dragDrop();
        } else {
            tableInfoShow = tableInfo;
        }
    }
    if ($(".tableBox table").length > 0) {
        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sLengthSelect": "form-select"
        });
        var oTable = $('.tableBox table').DataTable({
            "language": {
                "paginate": {
                    "next": "&raquo;",
                    "previous": "&laquo;"
                },
                sLengthMenu: "_MENU_",
                sInfoFiltered: "",
                sInfoEmpty: "",
                sInfo: tableInfoShow,
                "sEmptyTable": noTableData
            },
            "lengthMenu": lengthMenu,
            "order": [],
            initComplete: (settings) => {
                $(settings.nTableWrapper).find('.dataTables_paginate').appendTo('.paginationBox');
                $(settings.nTableWrapper).find('.dataTables_length').appendTo('.lengthTable').find('select').removeClass('custom-select-sm');
                $(settings.nTableWrapper).find('.dataTables_info').appendTo('.paginationInfo');
            },
            "fnDrawCallback": function (settings) {
                if (settings._iDisplayLength > settings.fnRecordsDisplay()) {
                    $(settings.nTableWrapper).find('.dataTables_paginate').hide();
                }
            }
        });
        $('.searchTable input').keyup(function () {
            oTable.search($(this).val()).draw();
        })
    }
});

//hide/show left menu
$('.sidebar-toggle').on('click', function (event) {
    event.preventDefault();
    $('header').toggleClass('toggled');
    
});
/*save button spinner*/
var saveButtonText = '';
$('.save-button').on('click', function (event) {
    saveButtonText = $(this).html();
    $(this).html('<div class="spinner-border spinner-border-sm" role="status"></div>');
});
var start = function (e, ui) {
    let $originals = ui.helper.children();
    ui.placeholder.children().each(function (index) {
        $(this).width($originals.eq(index).width());
    });
}
// Return a helper with preserved width of cells
var helper = function (e, tr) {
    let $helper = tr.clone();
    let $originals = tr.children();
    $helper.children().each(function (index) {
        $(this).width($originals.eq(index).outerWidth(true));
    });
    return $helper;
};


$('.tableLength').on('change', function () {
    window.location = "?length="+$(this).val();
    return false;
});
//single delete confirm
$('.tableLayout').on('click', '.admiko_deleteConfirm', function (event) {
    event.preventDefault();
    $('.dataDelete').html('');
    delLink = $(this).data('id');
    $('<input>').attr({
        type: 'hidden',
        value: delLink,
        name: 'idDel[]'
    }).appendTo('.dataDelete');
});

//select all records to delete in table
$('.tableLayout').on('click', '.deleteSelectAll', function (event) {
    event.preventDefault();
    var checkBoxes = $(".deleteSelectMe");
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    showDelButton();
});
//select one records to delete in table
$('.tableLayout').on('click', '.deleteSelectMe', function (event) {
    showDelButton();
});
$('.multiDeleteButton').on('click', function (event) {
    if ($(".deleteSelectMe:checked").length > 0) {
        $('.dataDelete').html('');
        $(".deleteSelectMe:checked").each(function (i) {
            delLink = $(this).val();
            $('<input>').attr({
                type: 'hidden',
                value: delLink,
                name: 'idDel[]'
            }).appendTo('.dataDelete');
        })
        $('#deleteConfirm').modal('show');
    }
});

$(".dropzoneShow").on("click", function (e) {
    e.preventDefault();
    $('.dropzoneBox').slideToggle();
});
$(".imageUpload").change(function () {
    imagePreview($(this), this);
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
$('form.needs-validation').on('submit',  function (event) {
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

function validateDate() {
    $(".datePicker").each(function (e) {
        if ($(this).prop('required')) {
            var datePicker = Date.parse($(this).val());
            if (isNaN(datePicker)) {
                $(this)[0].setCustomValidity('Invalid date!');
            } else {
                $(this)[0].setCustomValidity('');
            }
        }
    })
    $(".dateTimePicker").each(function (e) {
        if ($(this).prop('required')) {
            var dateTimePicker = Date.parse($(this).val());
            if (isNaN(dateTimePicker)) {
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

function limitPozNegDecNumbers(element, action) {
    if (action == 'keyCheck') {
        console.log(element.target.value)
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

function updateOrder() {
    var data_array = new Array();
    $('.dragMe').each(function () {
        data_array.push($(this).data('id'));
    });
    $.post(reorderUrl, {action: 'admiko_sort', "sortData": data_array,"_token": csrf_token}, function (data) {
        if (data != 'done') {
            console.log(data);
        }
    })
}

function showDelButton() {
    if ($(".deleteSelectMe:checked").length > 0) {
        $(".multiDeleteButton").show();
    } else {
        $(".multiDeleteButton").hide();
    }
}

function richTextEditor() {
    tinymce.init({
        selector: '.simple_text_editor',
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | undo redo | code',
        toolbar_mode: 'sliding',
        statusbar:  false,
        height: 220
    });

    tinymce.init({
        selector: '.advanced_text_editor',
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor codesample',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link codesample | fontselect fontsizeselect formatselect | removeformat | undo redo | code',
        toolbar_mode: 'sliding',
        statusbar:  false,
        height: 250
    });
}

//datePicker
function datePicker() {
    $('.dateTimePicker').each(function () {
        var date = '';
        var id = '#' + 'dateTimePicker_' + $(this).attr('id');
        var dateFormat = $(this).data('date_time_format');
        if ($(id).prop('required',true)) {
            date = moment();
            if ($(id).val() != "") {
                date = moment($(id).val()).toDate();
            }
        }
        $(id).datetimepicker({
            format: dateFormat,
            defaultDate: date,
            icons: {
                time: 'far fa-clock',
            }
        });
    })
    $('.datePicker').each(function () {
        var date = '';
        var id = '#' + 'datePicker_' + $(this).attr('id');
        var dateFormat = $(this).data('date_time_format');
        if ($(id).prop('required',true)) {
            date = moment();
            if ($(id).val() != "") {
                date = moment($(id).val()).toDate();
            }
        }
        $(id).datetimepicker({
            format: dateFormat,
            defaultDate: date
        });
    })
    $('.timePicker').each(function () {
        var date = '';
        var id = '#' + 'timePicker_' + $(this).attr('id');
        var timeFormat = $(this).data('date_time_format');
        if ($(id).prop('required',true)) {
            date = moment();
            if ($(id).val() != "") {
                date = $(id).val();
            }
        }

        $(id).datetimepicker({
            format: timeFormat,
            defaultDate: date
        });
    })
}
function dragDrop() {
    if ($(".dragMe").length > 0) {
        $(".tableLayout tbody").sortable({
            placeholder: 'highlight',
            items: 'tr',
            axis: 'y',
            handle: '.dragMe',
            forcePlaceholderSize: true,
            helper: 'clone',
            opacity: .8,
            tabSize: 60,
            tolerance: 'pointer',
            grid: [1, 1],
            helper: helper,
            start: start,
            stop: function (event, ui) {
                updateOrder();
            }
        });
    }
}
function multiCheckboxSort() {
    if ($(".multiCheckboxSort").length > 0) {
        $(".multiCheckboxSort").each(function () {
            var selElement = $(this);
            selElement.each(function () {
                $(this).html($(this).find(".multiCheckbox").sort(function (a, b) {
                    return Number(a.dataset.order) == Number(b.dataset.order) ? 0 : Number(a.dataset.order) < Number(b.dataset.order) ? -1 : 1
                }))
            })
            selElement.sortable({
                placeholder: 'highlight',
                handle: 'i',
                opacity: .8,
                items: '.multiCheckbox',
                tolerance: 'pointer',
                grid: [1, 1],
                forcePlaceholderSize: true,
                start: function(e, ui){
                    ui.placeholder.width(ui.item.find('.panel').width());
                    ui.placeholder.height(ui.item.find('.panel').height());
                    ui.placeholder.addClass(ui.item.attr("class"));
                },
                stop: function (event, ui) {
                    $(this).find('.multiCheckboxOrder').each(function (index) {
                        $(this).val(index);
                    })
                }
            });
        })
    }
}
function multiSelect() {
    if ($(".multiSelect").length > 0) {
        $(".multiSelect").each(function () {
            var selElement = $(this);
            selElement.find("select").select2({
                width: '100%',
                allowClear: true,
            }).on("select2:clear", function (evt) {
                //on clear prevent opening
                $(this).on("select2:opening.cancelOpen", function (evt) {
                    evt.preventDefault();
                    $(this).off("select2:opening.cancelOpen");
                });
            })
        })
    }
}
function multiSelectSort() {
    if ($(".multiSelectSort").length > 0) {
        $(".multiSelectSort").each(function () {
            var selElement = $(this);
            selElement.find("select").each(function(){
                $(this).html($(this).find("option").sort(function(a, b) {
                    return Number(a.dataset.order) == Number(b.dataset.order) ? 0 : Number(a.dataset.order) < Number(b.dataset.order) ? -1 : 1
                }))
            })
            selElement.find("select").select2({
                width: '100%',
                allowClear: true,
                containerCssClass : "multiSelectSortBox",
                templateSelection: formatMultiSelectSort,
                escapeMarkup: function(m) {
                    return m;
                }
            }).on("select2:select", function (evt) {
                //add to the end
                var element = evt.params.data.element;
                var $element = $(element);
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");
            }).on("select2:clear", function (evt) {
                //on clear prevent opening
                $(this).on("select2:opening.cancelOpen", function (evt) {
                    evt.preventDefault();
                    $(this).off("select2:opening.cancelOpen");
                });
            }).next().children().children().children().sortable({
                items       : 'li',
                stop: function (event, ui) {
                    ui.item.parent().children('[title]').each(function () {
                        var title = $(this).attr('title');
                        var original = $( 'option:contains(' + title + ')', selElement.find("select") ).first();
                        original.detach();
                        selElement.find("select").append(original)
                    });
                    selElement.find("select").change();
                }
            });
        })
    }
}
function formatMultiSelectSort(value) {
    if (!value.id) return value.text;
    return value.text + ' <i class="fas fa-arrows-alt fa fw"></i>';
}
function startGoogleMaps() {
    $(".admiko_google_map").each(function () {
        googleMap($(this));
    })
}

function googleMap(mapBox) {
    var varLatitude = mapStarLatitude;
    var varLongitude = mapStarLongitude;
    var latlng = '';
    var map_lat = mapBox.find('.admiko_map_lat').val();
    var map_lng = mapBox.find('.admiko_map_lng').val();

    if (map_lat == '' || map_lng == '') {
        latlng = new google.maps.LatLng(varLatitude, varLongitude);
    } else {
        latlng = new google.maps.LatLng(map_lat, map_lng);
    }
    var mapOptions = {
        zoom: mapStartZoom,
        center: latlng,
        draggable: true
    }
    var map = new google.maps.Map(mapBox.find('.showMap')[0], mapOptions);
    var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        draggable: true
    });

    google.maps.event.addListener(marker, 'drag', function (event) {
        mapBox.find('.admiko_map_lat').val(event.latLng.lat());
        mapBox.find('.admiko_map_lng').val(event.latLng.lng());
    });
}

function startBingMaps() {
    $(".admiko_bing_map").each(function () {
        bingMap($(this));
    })
}

function bingMap(mapBox) {
    var varLatitude = mapStarLatitude;
    var varLongitude = mapStarLongitude;
    var map_lat = mapBox.find('.admiko_map_lat').val();
    var map_lng = mapBox.find('.admiko_map_lng').val();
    if (map_lat != '' || map_lng != '') {
        varLatitude = map_lat;
        varLongitude = map_lng;
    }

    var map = new Microsoft.Maps.Map(mapBox.find('.showMap')[0], {
        credentials: bingKey,
        center: new Microsoft.Maps.Location(varLatitude, varLongitude),
        zoom: mapStartZoom
    });

    var center = map.getCenter();
    var Events = Microsoft.Maps.Events;

    //Create custom Pushpin
    var pin = new Microsoft.Maps.Pushpin(center, {
        draggable: true,
        color: '#00f'
    });
    //Add the pushpin to the map
    map.entities.push(pin);
    // Binding the events for the pin
    Events.addHandler(pin, 'dragend', function () {
        mapBox.find('.admiko_map_lat').val(pin.getLocation().latitude);
        mapBox.find('.admiko_map_lng').val(pin.getLocation().longitude);

    });

}

function imagePreview(element, input) {
    if (input.files && input.files[0]) {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = $('<img>');
            img.attr('src', e.target.result);
            img.attr('id', element.attr('id') + '_preview');
            element.after('<div class="image_preview mt-1">' + element.data('selected') + '<br>' + img[0].outerHTML + '</div>');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
    }
}


$(".dropdown-link").on("click", function (e) {
    e.preventDefault();
    toggleDropdown($(this));
});

function toggleDropdown(elm) {
    let el = elm.closest(".dropdown");
    if (el.hasClass("open")) {
        el.removeClass("open").find(".dropdown-content").slideUp();
    } else {
        $(".dropdown.open").removeClass("open").find(".dropdown-content").slideUp();
        el.addClass("open").find(".dropdown-content").slideDown();
    }
}


$(".imageAvatarUpload").change(function () {
    imageAvatarPreview($(this), this);
});
function imageAvatarPreview(element, input) {
    if (input.files && input.files[0]) {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
        var reader = new FileReader();
        var imgTemp = document.createElement("img");

        reader.onload = function (e) {
            imgTemp.src = e.target.result;
            imgTemp.onload = function () {
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(imgTemp, 0, 0);
                var MAX_WIDTH = 200;
                var MAX_HEIGHT = 200;
                var width = imgTemp.width;
                var height = imgTemp.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(imgTemp, 0, 0, width, height);
                if(hasAlpha (ctx, canvas)){
                    dataurl = canvas.toDataURL("image/png");
                } else {
                    dataurl = canvas.toDataURL("image/jpeg");
                }
                var img = $('<img>');
                img.attr('src', dataurl);
                $('#imageData').val(dataurl);
                img.attr('id', element.attr('id') + '_preview');
                element.after('<div class="image_preview mt-1">' + element.data('selected') + '<br>' + img[0].outerHTML + '</div>');

            } // img.onload
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
    }
}

function hasAlpha (context, canvas) {
    var data = context.getImageData(0, 0, canvas.width, canvas.height).data,
        hasAlphaPixels = false;
    for (var i = 3, n = data.length; i < n; i+=4) {
        if (data[i] < 255) {
            hasAlphaPixels = true;
            break;
        }
    }
    return hasAlphaPixels;
}

function admikoGlobalSearchStart(){
    if ($(".admikoGlobalSearch").length > 0) {
        $(".admikoGlobalSearch").on('keyup click', 'input', function () {
            var search = $(this).val();
            if (search.length >= 3) {
                $.ajax({
                    url: AdmikoGlobalSearchUrl,
                    type: 'get',
                    data: {search: search},
                    dataType: 'json',
                    success: function (results) {
                        var constructHtml = '';
                        if (results.length > 0) {
                            $.each(results, function (index, data) {
                                constructHtml += "<div><a class='modelPage' href='" + data.index_url + "'>" + data.name + "</a></div>";
                                $.each(data.items, function (index, item) {
                                    constructHtml += "<div><a href='" + item.url + "'>" + item.title + "</a></div>";
                                })
                            });
                            $('.admikoGlobalSearchResults').html(constructHtml).show();
                        } else {
                            $('.admikoGlobalSearchResults').html("<div class='noresults'>" + searchNoResults + "</div>").show();
                        }
                    },
                    error: function () {
                        $('.admikoGlobalSearchResults').html("<div class='noresults'>" + searchError + "</div>").show();
                    }
                });
            } else if (search.length >= 1) {
                $('.admikoGlobalSearchResults').html("<div class='noresults'>" + searchTypeMore + "</div>").show();
            } else {
                $('.admikoGlobalSearchResults').html('').hide();
            }
        })
        $(document).on('click', function (e) {
            if ($('.admikoGlobalSearchResults').html() != '' && $(e.target).closest(".admikoGlobalSearch").length === 0) {
                $('.admikoGlobalSearchResults').html('').hide();
            }
        });
    }
}
