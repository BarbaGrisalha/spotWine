(function ($) {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        const cartButton = document.querySelector("#dropdownCart");
        const cartMenu = document.querySelector(".cart-dropdown");

        if (cartButton && cartMenu) {
            cartButton.addEventListener("click", function () {
                cartMenu.classList.toggle("show");
            });

            document.addEventListener("click", function (e) {
                if (!cartMenu.contains(e.target) && !cartButton.contains(e.target)) {
                    cartMenu.classList.remove("show");
                }
            });
        }
    });


    $(document).on('click', '.btn-plus, .btn-minus', function () {
        var button = $(this);
        var input = button.closest('.input-group').find('input.quantity-input'); // Corrige a seleção do input
        var oldValue = parseInt(input.val()) || 0; // Garante que o valor seja um número válido

        // Ajusta o valor com base na classe do botão
        var newVal = button.hasClass('btn-plus')
            ? oldValue + 1
            : Math.max(1, oldValue - 1); // Valor mínimo é 1

        input.val(newVal); // Atualiza o valor no input
    });


    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    $(document).ready(function () {
        // Alterna a exibição do dropdown quando o botão "Filtrar" for clicado
        $('#dropdownFilterButton').on('click', function () {
            // Garante que o dropdown seja exibido e preencha toda a tela
            $('.dropdown-menu').addClass('show').css({
                display: 'block', // Garante que o display seja alterado corretamente
                position: 'fixed', // Fixa na tela
                top: '0', // Gruda no topo
                left: '0', // Gruda à esquerda
                height: '100%', // Ocupa 100% da altura
                width: '30%', // Ocupa 50% da largura
            });
        });

        // Fecha o dropdown ao clicar no botão "X"
        $('#closeDropdownButton').on('click', function () {
            $('.dropdown-menu').removeClass('show').css({
                display: 'none', // Esconde o dropdown
            });
        });

        // Fecha o dropdown ao clicar fora dele
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown-menu, #dropdownFilterButton').length) {
                $('.dropdown-menu').removeClass('show').css({
                    display: 'none', // Esconde o dropdown
                });
            }
        });
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


})(jQuery);




