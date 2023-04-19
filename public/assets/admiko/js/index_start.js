var delLink = 0;
var tableInfoShow = tableInfo;
var cardList;

if ($('.tableBox').length > 0) {
    dragDropSorting();
    showData();
    deleteAndSelect();
    tableLength();

    $(".dropzoneShow").on("click", function (e) {
        e.preventDefault();
        $('.dropzoneBox').slideToggle();
    });
}


function tableLength() {
    if ($('.tableLength').length > 0) {
        if ($('.tableLength').hasClass('pagination_length')) {
            $('.pagination_length').on('change', function () {
                window.location = "?length=" + $(this).val();
                return false;
            });
        } else if ($('.tableLength').hasClass('pagination_js_length')) {
            $('.pagination_js_length').on('change', function () {
                cardList.page = $(this).val();
                cardList.update();
                cardList.show(1, cardList.page);
            });
        }
    }
}

function deleteAndSelect() {

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
    $('.tableBox').on('click', '.deleteSelectAll', function (event) {
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
}

function showDelButton() {
    if ($(".deleteSelectMe:checked").length > 0) {
        $(".multiDeleteButton").show();
    } else {
        $(".multiDeleteButton").hide();
    }
}


function showData() {

    if ($(".tableBox table").length > 0) {
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sLengthSelect": "form-select"
        });
        if ($(".tableSort .dragMe").length > 0) {
            tableInfoShow = dragDropTableInfo;
        }
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
    } else if ($(".tableBox .cardElements").hasClass('pagination_js_data')) {
        if ($('.cardElements .rowElement').length > 0) {
            var classNames = [];
            $('.cardElements .rowElement:first [class*="search-js-"]').each(function (i, el) {
                var name = (el.className.match(/(^|\s)(search\-js\-[^\s]*)/) || [, , ''])[2];
                if (name) {
                    classNames.push(name);
                }
            });

            if ($(".tableBox .cardElements").hasClass('cardSort')) {
                var options = {
                    valueNames: classNames,
                    searchClass: 'searchTableInput',
                    listClass: 'cardElements'
                };

                cardList = new List('tableBox', options);
                $('.total_items_js').text(cardList.size());

                cardList.on('updated', function () {
                    $('.total_items_js').text(cardList.matchingItems.length);
                });
            } else {
                var options = {
                    valueNames: classNames,
                    searchClass: 'searchTableInput',
                    listClass: 'cardElements',
                    page: $('.pagination_js_length').val(),
                    pagination: [{
                        outerWindow: 1,
                        item: "<li class='page-item'><a class='page-link page' href='#'></a></li>",
                    }]
                };

                cardList = new List('tableBox', options);

                $('.total_items_js').text(cardList.size());
                $('.from_items_js').text(cardList.i);
                var total = parseInt(cardList.i) - 1 + parseInt(cardList.page);
                if (total > cardList.matchingItems.length) {
                    total = cardList.matchingItems.length;
                }
                $('.to_items_js').text(total);
                cardList.on('updated', function (list) {
                    $('.from_items_js').text(cardList.i);
                    total = parseInt(cardList.i) - 1 + parseInt(cardList.page);
                    if (total > cardList.matchingItems.length) {
                        total = cardList.matchingItems.length;
                    }
                    $('.to_items_js').text(total);
                    $('.total_items_js').text(cardList.matchingItems.length);
                });
            }
        } else {
            $('.paginationInfo').hide()
        }
    }
}


function dragDropSorting() {
    if ($(".tableSort .dragMe").length > 0 || $(".admikoIndex .cardSort").length > 0) {
        dragDrop();
    }
}

function dragDrop() {
    if ($(".cardElements .rowElement").length > 0) {
        $(".cardElements").sortable({
            placeholder: "highlight rowElement col-12 col-md-6 col-xxl-4 mb-3",
            items: '.rowElement',
            handle: '.dragMe',
            forcePlaceholderSize: true,
            helper: 'clone',
            opacity: .8,
            //tabSize: 60,
            tolerance: 'pointer',
            //grid: [1, 1],
            stop: function (event, ui) {
                updateOrder();
            }
        });
    } else if ($(".dragMe").length > 0) {
        $(".tableLayout tbody").sortable({
            placeholder: 'highlight',
            items: 'tr',
            axis: 'y',
            handle: '.dragMe',
            forcePlaceholderSize: true,
            // helper: 'clone',
            opacity: .8,
            tabSize: 60,
            tolerance: 'pointer',
            grid: [1, 1],
            helper: function (e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function (index) {
                    // Set helper cell sizes to match the original sizes
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            stop: function (event, ui) {
                updateOrder();
            }
        });
    }
}

function updateOrder() {
    var data_array = new Array();
    $('.dragMe').each(function () {
        data_array.push($(this).data('id'));
    });
    $.post(reorderUrl, {action: 'admiko_sort', "sortData": data_array, "_token": csrf_token}, function (data) {
        // if (data != 'done') {
        //     console.log(data);
        // }
    })
}
