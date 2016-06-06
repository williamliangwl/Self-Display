/**
 * Created by willi on 29-May-16.
 */
var items = [];

$('#confirm-button').click(function () {
    $('#confirm-button').html('Processing...');
    $.post(
        '/transaction/out/create',
        {
            '_token': $('#_token').val(),
            'recipient': $('#recipient').val(),
            'items': items
        },
        function (data) {
            if (!isNaN(data)) { //expect transactionid
                $('#confirm-button').html('Berhasil');
                $('#confirm-button').addClass('hidden');
                $('#cancel-button').addClass('hidden');
                $('#report-button').removeClass('hidden').attr('href', '/transaction/out/report/' + data);
                $('#error-msg').html('');
                //window.location.href = '/transaction/out/report/' + data;
            }
            else {
                $('#success-msg').html('');
                $('#error-msg').html(data);
                $('#confirm-button').html('Coba lagi');
                $('#confirm-button').addClass('btn-danger');
                $('#report-button').addClass('hidden');
            }
        }
    );
});

$('#checkout-button').click(function () {
    items = [];
    var total = 0;
    var checkeds = $('.selected-product:checked');
    $('#selected-product-table').html(
        '<tr>' +
        '<th>Name</th>' +
        '<th>Price</th>' +
        '<th>Quantity</th>' +
        '<th>Subtotal</th>' +
        '</tr>'
    );
    for (var i = 0; i < checkeds.length; i++) {
        var subtotal = 0;
        var siblings = $(checkeds[i]).parent().siblings();
        items.push({
            'id': $(checkeds[i]).val(),
            'name': $(siblings[0]).html(),
            'price': $(siblings[1]).html(),
            'stock': $(siblings[2]).html(),
            'quantity': $(siblings[3]).children('input').val()
        });

        subtotal = items[i].price.substring(2) * items[i].quantity;
        total += subtotal;

        $('#selected-product-table').append(
            '<tr>' +
            '<td>' + items[i].name + '</td>' +
            '<td>' + items[i].price + '</td>' +
            '<td>' + items[i].quantity + '</td>' +
            '<td>Rp' + subtotal + '</td>' +
            '</tr>'
        );
    }
    $('#selected-product-table').append(
        '<tr>' +
        '<td colspan="3" style="text-align:center; font-weight:bold;" >Total</td>' +
        '<td>Rp' + total + '</td>' +
        '</tr>'
    );
});

$('.selected-product').click(function () {
    var quantity_input = $(this).parent().siblings('.quantity-column').children('input');
    $(quantity_input).toggleClass('hidden');
});

$('#recordOutTransaction').on('show.bs.modal', function () {
    $('#confirm-button').removeClass('btn-success');
    $('#confirm-button').removeClass('btn-danger');
    $('#cancel-button').removeClass('hidden');
});