/**
 * Created by willi on 20-May-16.
 */

//$.ajaxSetup({
//    headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//    }
//});
//
//$(document).ready(function(){
//});
//
//$('#add-product-btn').click(function () {
//    $form = document.forms['add-product'];
//    $formData = {
//        '_token': $form['_token'].value,
//        'name': $form['name'].value,
//        'price': $form['price'].value,
//        'stock': $form['stock'].value
//    };
//
//
//    $.ajax({
//        type: 'POST',
//        url: '/product/create',
//        data: $formData,
//        success: function (data) {
//            if(data == "true") {
//
//            }
//        }
//    });
//});

function populateProductField(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var name = button.data('name'); // Extract info from data-* attributes
    var price = button.data('price'); // Extract info from data-* attributes
    var stock = button.data('stock'); // Extract info from data-* attributes
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#item-id').val(id);
    modal.find('#item-name').val(name).html(name);
    modal.find('#item-price').val(price).html(price);
    modal.find('#item-stock').val(stock).html(stock);
}

$('#deleteModal').on('show.bs.modal', populateProductField);
$('#updateModal').on('show.bs.modal', populateProductField);