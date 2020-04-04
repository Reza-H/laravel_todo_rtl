// --------------------- Bootstrap Sec------------------------------------

// ------Plus Icon Sec
$('#exampleModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget) ;// Button that triggered the modal
  let recipient = button.data('whatever') ;// Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  let modal = $(this);
  // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient);
});


// -------------- Persian Data Picker --------------------


// ----------------------------- IzToast ------------------------
function ialert(Response)
{
    if(Response.ERROR){
            iziToast.show({
                theme: 'light', // dark
                color: 'red', // blue, red, green, yellow
                rtl: true,
                position: 'bottomRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                icon: 'fas fa-times',
                // title: 'کاربر عزیز',
                message: Response.ERROR
            });
        }else if(Response.WARN){
            iziToast.show({
                theme: 'light', // dark
                color: 'yellow', // blue, red, green, yellow
                rtl: true,
                position: 'bottomRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                icon: 'fas fa-exclamation-triangle',
                // title: 'کاربر عزیز',
                message: Response.WARN
            });
        }else if (Response.SUCCESS) {
            iziToast.show({
                theme: 'light', // dark
                color: 'green', // blue, red, green, yellow
                rtl: true,
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                icon: 'fas fa-check',
                // title: 'کاربر عزیز',
                message: Response.SUCCESS
            });
        } else if(Response.INFO){
            iziToast.show({
                theme: 'light', // dark
                color: 'blue', // blue, red, green, yellow
                rtl: true,
                position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                icon: 'fas fa-check',
                // title: 'کاربر عزیز',
                message: Response.INFO
            });
        }
}
// ----------------------------- End IzToast ------------------------
