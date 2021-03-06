/**
 * Created by willi on 20-May-16.
 */

function populateProductField(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var name = button.data('name'); // Extract info from data-* attributes
    var price = button.data('price'); // Extract info from data-* attributes
    var stock = button.data('stock'); // Extract info from data-* attributes
    var capital = button.data('capital'); // Extract info from data-* attributes
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#item-id').val(id);
    modal.find('#item-name').val(name).html(name);
    modal.find('#item-price').val(price).html(price);
    modal.find('#item-stock').val(stock).html(stock);
    modal.find('#item-capital-price').val(capital).html(capital);
}

$('#deleteModal').on('show.bs.modal', populateProductField);
$('#updateModal').on('show.bs.modal', populateProductField);