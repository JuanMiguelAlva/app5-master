
if ($('.formPage').length > 0) {

    $(".imageUpload").change(function () {
        imagePreview($(this), this);
    });

    richTextEditor();
    datePicker();
    multiSelect();
    multiSelectSort();
    multiCheckboxSort();
}

function richTextEditor() {
    if ($('.simple_text_editor').length > 0) {
        tinymce.init({
            selector: '.simple_text_editor',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | undo redo | code fullscreen',
            toolbar_mode: 'sliding',
            statusbar: false,
            height: 220
        });
    }
    if ($('.advanced_text_editor').length > 0) {
        tinymce.init({
            selector: '.advanced_text_editor',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor codesample',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link codesample | fontselect fontsizeselect formatselect | removeformat | undo redo | code fullscreen',
            toolbar_mode: 'sliding',
            statusbar: false,
            height: 250
        });
    }
}

//datePicker
function datePicker() {
    $('.dateTimePicker').each(function () {
        var date = false;
        var id = '#' + 'dateTimePicker_' + $(this).attr('id');
        var dateFormat = $(this).data('date_time_format');
        if ($(this).prop('required')) {
            date = moment();
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
        var date = false;
        var id = '#' + 'datePicker_' + $(this).attr('id');
        var dateFormat = $(this).data('date_time_format');
        if ($(this).prop('required')) {
            date = moment();
        }
        $(id).datetimepicker({
            format: dateFormat,
            defaultDate: date
        });
    })
    $('.timePicker').each(function () {
        var date = false;
        var id = '#' + 'timePicker_' + $(this).attr('id');
        var timeFormat = $(this).data('date_time_format');
        if ($(this).prop('required')) {
            date = moment();
            // alert(date);
        }

        $(id).datetimepicker({
            format: timeFormat,
            defaultDate: 'Tue Mar 07 2023 08:00:00 GMT-0500'
        });
    })
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
            selElement.find("select").each(function () {
                $(this).html($(this).find("option").sort(function (a, b) {
                    return Number(a.dataset.order) == Number(b.dataset.order) ? 0 : Number(a.dataset.order) < Number(b.dataset.order) ? -1 : 1
                }))
            })
            selElement.find("select").select2({
                width: '100%',
                allowClear: true,
                containerCssClass: "multiSelectSortBox",
                templateSelection: formatMultiSelectSort,
                escapeMarkup: function (m) {
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
                items: 'li',
                stop: function (event, ui) {
                    ui.item.parent().children('[title]').each(function () {
                        var title = $(this).attr('title');
                        var original = $('option:contains(' + title + ')', selElement.find("select")).first();
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



