/**
 * Created by willi on 08-Aug-16.
 */
function populateTransactionField(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes

// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#item-id').val(id);
}

$('#deleteModal').on('show.bs.modal', populateTransactionField);