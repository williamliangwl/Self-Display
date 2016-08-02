/**
 * Created by willi on 25-Jul-16.
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

    for (var i = 0; i < products.length; i++) {
        $('#product-table').append(
            '<tr>' +
            '<td>' + products[i].name + '</td>' +
            '<td>Rp' + money(products[i].price) + '</td>' +
            '<td>' + products[i].stock + '</td>' +
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
            productList = [];
            for (var i = 0; i < data.length; i++) {
                productList.push({
                    'id': data[i]['id'],
                    'name': data[i]['name'],
                    'price': data[i]['price'],
                    'stock': data[i]['stock']
                });
            }
            showProduct(productList);
        }
    );
}

//$('#name-text-box').autocomplete({
//    source: function (request, response) {
//        var suggestions = [];
//
//        $.each(productList, function (i, product) {
//            if (product.name.toLowerCase().indexOf($('#name-text-box').val().toLowerCase()) != -1) {
//                suggestions.push(product.name);
//            }
//        });
//
//        response(suggestions);
//    },
//    minLength: 2,
//    select: function (event, ui) {
//        var selectedName = ui.item.value;
//        var result = searchProduct(selectedName);
//
//        showProduct(result);
//    }
//});

$('#name-text-box').keyup(function () {
    var selectedName = $(this).val();
    var result = searchProduct(selectedName);

    showProduct(result);
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

function searchProduct(name) {
    var result = $.grep(productList, function (item, i) {
        return item.name.toLowerCase().indexOf(name.toLowerCase()) != -1;
    });

    return result;
}