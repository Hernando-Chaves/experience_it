(function ($) {
    $(document).ready(function () {
        let currentPage = 1;
        const resultsPerPage = 5;

        $('.eits_btn').click(function (e) {
            e.preventDefault();

            $('.result-table').html('<tr><td colspan="3">Cargando...</td></tr>');

            const $filter = $('#filter_users').val();
            const $search = $('#search_users').val();
            const $form = $('.eits_form');
            const $error_div = $('.error_div');

            if ($search === '' || $filter === '') {
                $error_div.removeClass('hidden');
            } else {
                setTimeout(function () {
                    $('.loader').show();

                    $.ajax({
                        type: 'POST',
                        url: AJAX_URL.url,
                        data: {
                            action: 'eits_custom_search',
                            filter: $filter,
                            search: $search,
                            page: currentPage,
                            per_page: resultsPerPage
                        },
                        dataType: 'json',
                        success: function (users) {
                            $form[0].reset();
                            $error_div.addClass('hidden');
                            $('#no_results').addClass('hidden');
                            $('#eits_table').removeClass('hidden');
                            $('.loader').hide();

                            if (users.length > 0) {
                                renderTable(users);
                            } else {
                                $('.result-table').html('<tr><td colspan="3">No se encontraron resultados.</td></tr>');
                                $('.pagination').empty(); 
                            }
                        },
                        error: function (error) {
                            console.log('Error:', error);
                            $('.loader').hide();
                            $('.result-table').html('<tr><td colspan="3">Hubo un error al procesar la solicitud.</td></tr>');
                        }
                    });
                }, 1000);
            }
        });

        function renderTable(users) {
            let tableHTML = '<table><thead><tr>';
            tableHTML += '<td>ID</td>';
            tableHTML += '<td>Nombre de usuario</td>';
            tableHTML += '<td>Nombre</td>';
            tableHTML += '<td>Apellido 1</td>';
            tableHTML += '<td>Apellido 2</td>';
            tableHTML += '<td>Correo</td>';
            tableHTML += '</tr></thead><tbody>';

            const startIndex = (currentPage - 1) * resultsPerPage;
            const endIndex = startIndex + resultsPerPage;

            users.slice(startIndex, endIndex).forEach(function (user) {
                tableHTML += '<tr>';
                tableHTML += '<td>' + user.id + '</td>';
                tableHTML += '<td>' + user.nickname + '</td>';
                tableHTML += '<td>' + user.nombre + '</td>';
                tableHTML += '<td>' + user.apellido + '</td>';
                tableHTML += '<td>' + user.apellido2 + '</td>';
                tableHTML += '<td>' + user.correo + '</td>';
                tableHTML += '</tr>';
            });

            tableHTML += '</tbody></table>';
            $('.result-table').html(tableHTML);
        }
    });
})(jQuery);
