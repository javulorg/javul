// $(document).ready(function () {
//     $('.see_more').click(function () {
//         $(this).parent().parent().find('.hidden_row').show(300);
//         $(this).parent().parent().find('.table_block').addClass('active');
//         return false;
//     });
//
//     $('#burger').click(function () {
//         $(this).toggleClass('active');
//         $('#mob_menu').toggleClass('active');
//     });
//
//     $('.sidebar_block_ttl').click(function () {
//         if ( $(window).width() < 576 ) {
//             $(this).parent().toggleClass('active');
//         }
//     });
//
//     $('.table_block_head').click(function () {
//         if ( $(window).width() < 768 ) {
//             $(this).parent().toggleClass('active');
//         }
//     });
//     document.getElementById('search_modal').addEventListener('click', (e) => {
//         var content = document.getElementById('search_modal').querySelector('.search_modal_content');
//         const withinBoundaries = e.composedPath().includes(content);
//  
//         if (!withinBoundaries) {
//             document.getElementById('search_modal').classList.remove('active');
//         }
//     });
//
//     $('#search_btn').click(function () {
//         $('#search_modal').addClass('active');
//     });
//     $('.clear_search').click(function () {
//         $(this).parent().find('input').val('');
//     });
// });












$(document).ready(function () {
    $('.see_more').click(function () {
        $(this).parent().parent().find('.hidden_row').show(300);
        $(this).parent().parent().find('.table_block').addClass('active');
        return false;
    });

    $('#burger').click(function () {
        $(this).toggleClass('active');
        $('#mob_menu').toggleClass('active');
    });

    $('.sidebar_block_ttl').click(function () {
        if ( $(window).width() < 576 ) {
            $(this).parent().toggleClass('active');
        }
    });

    $('.objective_content_info .sidebar_block_ttl').click(function () {
        if ( $(window).width() < 576 ) {
            $(this).parent().addClass('active');
        }
    });

    $('.table_block_head').click(function () {
        if ( $(window).width() < 768 ) {
            $(this).parent().toggleClass('active');
        }
    });
    document.getElementById('search_modal').addEventListener('click', (e) => {
        var content = document.getElementById('search_modal').querySelector('.search_modal_content');
        const withinBoundaries = e.composedPath().includes(content);

        if (!withinBoundaries) {
            document.getElementById('search_modal').classList.remove('active');
        }
    });

    $('#search_btn').click(function () {
        $('#search_modal').addClass('active');
    });
    $('.clear_search').click(function () {
        $(this).parent().find('input').val('');
    });
});
