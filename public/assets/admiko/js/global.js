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

$('a.delete').on('click', function(event) {
    event.preventDefault();
    $('.dataDelete').html('');
    delLink = $(this).data('id');
    ciclo= $(this).data('ciclo');
    $('<input>').attr({
        type: 'hidden',
        value: delLink,
        name: 'idDel[]'
    }).appendTo('.dataDelete');
    $('<input>').attr({
        type: 'hidden',
        value: ciclo,
        name: 'ciclo'
    }).appendTo('.dataDelete');
});

//hide/show left menu
$('.sidebar-toggle').on('click', function (event) {
    event.preventDefault();
    $('header').toggleClass('toggled');
    $('.main').toggleClass('toggled');
});

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

// Horarios

const selectCiclo = document.getElementById('select-ciclo');

window.addEventListener('DOMContentLoaded', () => {
  selectCiclo.dispatchEvent(new Event('change'));
});

selectCiclo.addEventListener('change', () => {
    const cicloSeleccionado = selectCiclo.value;

    const contenedores = document.querySelectorAll('.cont');

    contenedores.forEach(contenedor => {
      contenedor.style.display = 'none';
    });

    const contenedorSeleccionado = document.querySelector(`.cont[data-ciclo="${cicloSeleccionado}"]`);
    if (contenedorSeleccionado) {
        contenedorSeleccionado.style.display = 'block';
    }
    
    contenedores.forEach(contenedor => {
        if (contenedor.dataset.ciclo != cicloSeleccionado) {
            contenedor.style.display = 'none';
        }
    });
});
