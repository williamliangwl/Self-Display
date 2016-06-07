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
    $('#success-msg').toggleClass('text-success').html('Sedang di proses..');
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
                $('#success-msg').toggleClass('text-success').html('Sukses menambah stok ' + $(form['name']).val());
            }else
                window.location.href = '/transaction/in';
        }
    )
});

$('#name-text-box').autocomplete({
    source: function (request, response) {
        $.post(
            "/product/findByName",
            {
                '_token': $('#_token').val() ,
                'name': $('#name-text-box').val()
            },
            function (data) {
                var productNames = [];
                $.each(data, function(i, product){
                    productNames.push(product['name']);
                });
                response(productNames);
            });
    },
    minLength: 1
});