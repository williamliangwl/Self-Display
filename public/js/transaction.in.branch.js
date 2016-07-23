/**
 * Created by willi on 31-May-16.
 */
var productNames = [];

getAllProducts();

function showProduct(products) {
    $('#product-table').html(
        '<tr>' +
        '<th>Nama</th>' +
        '<th>Harga</th>' +
        '<th>Stok</th>' +
        '</tr>'
    );

    for (var i = 0; i < products.length; i++) {
        $('#product-table').append(
            '<tr>' +
            '<td>' + products[i]['name'] + '</td>' +
            '<td>Rp' + products[i]['price'] + '</td>' +
            '<td>' + products[i]['stock'] + '</td>' +
            '</tr>'
        );
        productNames.push(products[i]['name']);
    }
}

function getAllProducts() {
    $.post(
        '/product/all',
        {
            '_token': $('#_token').val()
        },
        function (data) {
            showProduct(data);
        }
    );
}

$('#add-in-transaction-btn').click(function (event) {
    event.preventDefault();
    var form = document.forms['add-in-transaction'];
    $('#success-msg').removeClass('text-success').html('Sedang di proses..');
    $.post(
        '/transaction/in/create',
        {
            '_token': $(form['_token']).val(),
            'name': $(form['name']).val(),
            'stock': $(form['stock']).val()
        },
        function (data) {
            if (!isNaN(data)) {
                getAllProducts();
                $('#success-msg').addClass('text-success').html('Sukses menambah stok ' + $(form['name']).val());
            }else
                window.location.href = '/transaction/in';
        }
    )
});

$('#name-text-box').autocomplete({
    source: function (request, response) {
        var suggestions = [];

        $.each(productNames, function(i, name) {
           if(name.indexOf($('#name-text-box').val()) != -1) {
               suggestions.push(name);
           }
        });

        response(suggestions);
    },
    minLength: 1
});