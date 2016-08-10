/**
 * Created by willi on 01-Aug-16.
 */

function populateProductField(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var date = button.data('date'); // Extract info from data-* attributes
    var price = button.data('price'); // Extract info from data-* attributes
    var description = button.data('description'); // Extract info from data-* attributes
    //var capital = button.data('capital'); // Extract info from data-* attributes
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#item-id').val(id);
    modal.find('#item-date').val(date).html(date);
    modal.find('#item-price').val(price).html(money(price));
    modal.find('#item-description').val(description).html(description);
    //modal.find('#item-capital-price').val(capital).html(capital);
}

$('#deleteModal').on('show.bs.modal', populateProductField);
$('#updateModal').on('show.bs.modal', populateProductField);

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