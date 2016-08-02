/**
 * Created by willi on 28-Jul-16.
 */

$('#cek-button').click(function(){
    window.href = '/transaction/out/buyer/' + $('#phone-text').val();
});