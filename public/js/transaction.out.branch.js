/**
 * Created by willi on 29-May-16.
 */
var items = [];
var selectedIds = [];
var allProducts = [];

$.post('/product/all', {
    '_token': $('#_token').val()
}, function (data) {
    allProducts = data;
    refreshProducts(allProducts);
});

function refreshProducts(products) {
    $('#product-table').html('' +
        '<tr>' +
        '<th>Pilih</th>' +
        '<th>Nama</th>' +
        '<th>Stok</th>' +
        '<th>Harga Jual</th>' +
        '</tr>');

    for (var i = 0; i < products.length; i++) {
        if (products[i].stock > 0 && selectedIds.indexOf(products[i].id) == -1) {
            $('#product-table').append('' +
                '<tr>' +
                '<td>' +
                '<input class="selected-product" type="checkbox" value="' + products[i].id + '">' +
                '</td>' +
                '<td>' + products[i].name + '</td>' +
                '<td>' + products[i].stock + '</td>' +
                '<td>Rp' + money(products[i].price) + '</td>' +
                '<td class="quantity-column" >' +
                '<input class="hidden" style="width:50px" type="number" min="1" max="' + products[i].stock + '" value="1">' +
                '</td>' +
                '<td class="deal-price-column" >' +
                '<input class="hidden" style="width:70px" type="number" min="1" value="' + products[i].price + '">' +
                '</td>' +
                '</tr>');
        }
    }


    $('.selected-product').unbind("click");
    $('.selected-product').click(toggleInputs);
}

$('#confirm-button').click(function () {
    $('#confirm-button').html('Processing...');

    $.post('/buyer/create',
        {
            '_token': $('#_token').val(),
            'name': $('#name-text').val(),
            'address': $('#address-text').val(),
            'phone': $('#phone-text').val()
        },
        function (data) {
            if (!isNaN(data)) {// expect buyer id
                var buyerId = data;
                //create transaction
                $.post(
                    '/transaction/out/create',
                    {
                        '_token': $('#_token').val(),
                        'items': items,
                        'buyer_id': buyerId
                    },
                    function (data) {
                        if (!isNaN(data)) { //expect transactionid
                            $('#confirm-button').html('Berhasil');
                            $('#confirm-button').addClass('hidden');
                            $('#cancel-button').addClass('hidden');
                            $('#report-button').removeClass('hidden').attr('href', '/transaction/out/report/' + data);
                            $('#error-msg').html('');

                            $.post('/product/all', {
                                '_token': $('#_token').val()
                            }, function (data) {
                                selectedIds.splice();
                                $('.selected-product:checked').click();
                                refreshProducts(data);
                            });

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
            }
        });


});

$('#checkout-button').click(function () {
    items = [];
    var total = 0;
    var checkeds = $('.selected-product:checked');
    $('#selected-product-table').html(
        '<tr>' +
        '<th>Name</th>' +
        '<th>Qty</th>' +
        '<th>Price</th>' +
        '<th>Subtotal</th>' +
        '</tr>'
    );
    for (var i = 0; i < checkeds.length; i++) {
        var subtotal = 0;
        var siblings = $(checkeds[i]).parent().siblings();
        items.push({
            'id': $(checkeds[i]).val(),
            'name': $(siblings[0]).html(),
            'stock': $(siblings[1]).html(),
            'quantity': $(siblings[3]).children('input').val(),
            'price': $(siblings[4]).children('input').val()
        });

        subtotal = items[i].price * items[i].quantity;
        total += subtotal;

        $('#selected-product-table').append(
            '<tr>' +
            '<td>' + items[i].name + '</td>' +
            '<td>' + items[i].quantity + '</td>' +
            '<td>Rp' + money(items[i].price) + '</td>' +
            '<td>Rp' + money(subtotal) + '</td>' +
            '</tr>'
        );
    }
    $('#selected-product-table').append(
        '<tr>' +
        '<td colspan="3" style="text-align:center; font-weight:bold;" >Total</td>' +
        '<td>Rp' + money(total) + '</td>' +
        '</tr>'
    );
});

$('.selected-product').click(toggleInputs);

$('#recordOutTransaction').on('show.bs.modal', function () {
    $('#confirm-button').removeClass('btn-success');
    $('#confirm-button').removeClass('btn-danger');
    $('#confirm-button').removeClass('hidden');
    $('#confirm-button').html('Yakin');
    $('#cancel-button').removeClass('hidden');
    $('#report-button').addClass('hidden');
});

$('#phone-text').focusout(function () {
    var phone = $('#phone-text').val();
    if (phone.length >= 10) {
        $.post('/buyer/get', {
            '_token': $('#_token').val(),
            'phone': phone
        }, function (data) {
            var buyer = data;
            $('#name-text').val(buyer.name);
            $('#address-text').val(buyer.address);
        });
    }
});

$('#name-text').focusout(function () {
    var phone = $('#phone-text').val();
    var name = $('#name-text').val();
    if (name.length > 2) {
        $.post('/buyer/get', {
            '_token': $('#_token').val(),
            'phone': phone,
            'name': name
        }, function (data) {
            var buyer = data;
            $('#phone-text').val(buyer.phone);
            $('#address-text').val(buyer.address);
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

function toggleInputs() {
    var element = $(this).parent().parent().detach();
    if (this.checked) {
        selectedIds.push(parseInt(this.value));
        $('#chosen-product-table').append(element);
    }
    else {
        if (selectedIds.indexOf(parseInt(this.value)) > -1)
            selectedIds.splice(selectedIds.indexOf(parseInt(this.value)), 1);

        filterProduct();
    }

    var quantity_input = $(this).parent().siblings('.quantity-column').children('input');
    var deal_price_input = $(this).parent().siblings('.deal-price-column').children('input');
    $(quantity_input).toggleClass('hidden');
    $(deal_price_input).toggleClass('hidden');
}

$('#name-text-box').keyup(filterProduct);

function filterProduct() {
    var selectedName = $('#name-text-box').val();
    var result = searchProduct(selectedName);

    refreshProducts(result);
}

function searchProduct(query) {
    var result = $.grep(allProducts, function (item, i) {
        return (item.name.toLowerCase().indexOf(query.toLowerCase()) != -1);
    });

    return result;
}
