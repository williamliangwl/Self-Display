/**
 * Created by willi on 31-May-16.
 */
var productList = [];

getAllProducts();

function showProduct(products) {
    $('#product-table').html(
        '<tr>' +
        '<th>Nama</th>' +
        '<th>Harga</th>' +
        '<th>Stok</th>' +
        '</tr>'
    );
    productList = [];
    for (var i = 0; i < products.length; i++) {
        $('#product-table').append(
            '<tr>' +
            '<td>' + products[i]['name'] + '</td>' +
            '<td>Rp' + money(products[i]['price']) + '</td>' +
            '<td>' + products[i]['stock'] + '</td>' +
            '</tr>'
        );
        productList.push({
            'id': products[i]['id'],
            'name': products[i]['name']
        });
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
    $('#msg').removeClass('text-danger').removeClass('text-success').html('Sedang di proses..');
    $.post(
        '/transaction/in/create',
        {
            '_token': $(form['_token']).val(),
            'name': $(form['name']).val(),
            'stock': $(form['stock']).val()
        },
        function (data) {
            if (data != '' && !isNaN(data)) {
                getAllProducts();
                $('#msg').addClass('text-success').html('Sukses menambah stok ' + $(form['name']).val());
            } else {
                $('#msg').addClass('text-danger').html('Gagal menambah stok ' + $(form['name']).val());
                //window.location.href = '/transaction/in';
            }
        }
    )
});

$('#name-text-box').autocomplete({
    source: function (request, response) {
        var suggestions = [];

        $.each(productList, function (i, product) {
            if (product.name.toLowerCase().indexOf($('#name-text-box').val().toLowerCase()) != -1) {
                suggestions.push(product.name);
            }
        });

        response(suggestions);
    },
    minLength: 3,
    select: function (event, ui) {
        var selectedName = ui.item.value;

        $.each(productList, function (i, product) {
            if (product.name == selectedName) {
                $('#id-text').val(product.id);
            }
        });
    }
});

function money(text) {
    text = text.toString();
    if (text.indexOf('Rp') == 0) {
        text = text.substr(2);
    }
    var chars = text.split('').reverse();
    for (var i = 3; i < text.length; i += 4) {
        chars.splice(i, 0, ".");
    }
    return chars.reverse().join('');
}