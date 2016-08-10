/**
 * Created by willi on 25-Jul-16.
 */

var buyerList = [];

getAllBuyers();

function showBuyer(buyers) {
    $('#buyer-table').html(
        '<tr>' +
        '<th>Nama</th>' +
        '<th>Telepon</th>' +
        '<th>Alamat</th>' +
        '<th>Cek</th>' +
        '</tr>'
    );

    for (var i = 0; i < buyers.length; i++) {
        $('#buyer-table').append(
            '<tr>' +
            '<td>' + buyers[i].name + '</td>' +
            '<td>' + buyers[i].phone + '</td>' +
            '<td>' + buyers[i].address + '</td>' +
            '<td><a class="btn btn-primary" role="button" target="_blank" href="/transaction/out/buyer/check/'+ buyers[i].id +'">Cek</a></td>' +
            '</tr>'
        );
    }
}

function getAllBuyers() {
    $.post(
        '/buyer/getAll',
        {
            '_token': $('#_token').val()
        },
        function (data) {
            buyerList = [];
            for (var i = 0; i < data.length; i++) {
                buyerList.push({
                    'id': data[i]['id'],
                    'name': data[i]['name'],
                    'phone': data[i]['phone'],
                    'address': data[i]['address']
                });
            }
            showBuyer(buyerList);
        }
    );
}


$('#name-text-box').keyup(function () {
    var selectedName = $(this).val();
    var result = searchBuyer(selectedName);

    showBuyer(result);
});

$('#phone-text-box').keyup(function () {
    var selectedPhone = $(this).val();
    var result = searchBuyer(selectedPhone);

    showBuyer(result);
});

$('#address-text-box').keyup(function () {
    var selectedAddress = $(this).val();
    var result = searchBuyer(selectedAddress);

    showBuyer(result);
});

function searchBuyer(query) {
    var result = $.grep(buyerList, function (item, i) {
        return (item.name.toLowerCase().indexOf(query.toLowerCase()) != -1) ||
            (item.phone.toLowerCase().indexOf(query.toLowerCase()) != -1) ||
            (item.address.toLowerCase().indexOf(query.toLowerCase()) != -1);
    });

    return result;
}