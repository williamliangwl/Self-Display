/**
 * Created by willi on 29-May-16.
 */
function populateUserField(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var name = button.data('name'); // Extract info from data-* attributes
    var username = button.data('username'); // Extract info from data-* attributes
    var role = button.data('role'); // Extract info from data-* attributes

    var modal = $(this);
    modal.find('#user-id').val(id);
    modal.find('#user-name').val(name).html(name);
    modal.find('#user-username').val(username).html(username);
    modal.find('#user-role').val(role);
    modal.find('#user-role-label').html(role);
}

$('#deleteModal').on('show.bs.modal', populateUserField);
$('#updateModal').on('show.bs.modal', populateUserField);