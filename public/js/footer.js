$(document).ready(function(){
$('#date1').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate1-text',
    targetDateSelector: '#inputDate1-date',
    disableBeforeToday: true,
    enableTimePicker: true,
});
$('#date2').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate2-text',
    targetDateSelector: '#inputDate2-date',
    disableBeforeToday: true,
    enableTimePicker: true,
});
$('#edit_modal_start').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate1-text_edit',
    targetDateSelector: '#inputDate1-date_edit',
    disableBeforeToday: true,
    enableTimePicker: true,
});
$('#edit_modal_end').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate2-text_edit',
    targetDateSelector: '#inputDate2-date_edit',
    disableBeforeToday: true,
    enableTimePicker: true,
});
// ---------------- check box in model

$('#select_user_btn, .overlay').on('click', function () {
    $('#select_user_menu, .overlay').toggleClass('show');
  });
  $('#select_radio_user_btn, .overlay').on('click', function () {
    $('#select_user_radio, .overlay').toggleClass('show');
  });

//  -------------------------- Edit Task Modal
$('#select_user_btn_edit, .overlay').on('click', function () {
    $('#select_user_menu_edit, .overlay').toggleClass('show');
});
$('#select_radio_user_btn_edit, .overlay').on('click', function () {
    $('#select_user_radio, .overlay').toggleClass('show');
});
//  -------------------------- End Edit Task Modal

  //  Deselect if all checkbox items in #choice_1 if #Choise_2 be selected
  $('.chk-test').change(function () {
    if ($('#choice_2').is(':checked')) {

        $('input.chkB[type=checkbox]').each(function () {

            if ($(this).prop('checked', true)) {
                $('input.chkB[type=checkbox]').prop('checked', false);
                $(".checkbox-menu li").removeClass("active", this.checked);
                $('#select_user_menu, #overlay').removeClass('show');
            }
        });
    } else {
        if ($('#choice_1').is(':checked')) {

            $('select.indivisual-select option[value=0]').prop('selected','selected');
        }
    }
  });
  // ___________ Edit Modal ________________________
  $('.edit_radio_type').change(function () {
    if ($('#choice_2_edit').is(':checked')) {

        $('input.chkB[type=checkbox]').each(function () {

            if ($(this).prop('checked', true)) {
                $('input.chkB[type=checkbox]').prop('checked', false);
                $(".checkbox-menu li").removeClass("active", this.checked);
                $('#select_user_menu, .overlay').removeClass('show');
            }
        });
    } else {
        if ($('#choice_1_edit').is(':checked')) {

            $('select.indivisual-select_edit option[value=0]').prop('selected','selected');
        }
    }
  });
// ___________ End Edit Modal ________________________
  // var FormStuff = {
  //
  //   init: function () {
  //       this.applyConditionalRequired();
  //       this.bindUIActions();
  //   },
  //
  //   bindUIActions: function () {
  //       $("input[type='radio'], input[type='checkbox']").on("change", this.applyConditionalRequired);
  //   },
  //
  //   applyConditionalRequired: function () {
  //
  //       $(".require-if-active").each(function () {
  //           let el = $(this);
  //           if ($(el.data("require-pair")).is(":checked")) {
  //               el.prop("required", true);
  //           } else {
  //               el.prop("required", false);
  //           }
  //       });
  //
  //   }
  //
  // };
  //
  // FormStuff.init();

  // we'll manually keep an .active class flag on each list item to correspond to whether or not the item is checked so we can style it appropriately.
  $(".checkbox-menu").on("change", "input[type='checkbox']", function () {
    $(this).closest("li").toggleClass("active", this.checked);
  });
  // ----------- End model's check box

//   ---------------------------------_Single Task Page---------------------

    // fire
//     $('.collapse').collapse();
    $('#add-sub-check-lis').modal();
    $('#add_new_comment_btn').on('click', function() {
        $('#add_new_comment_modal').modal();
    });



    $("#close-add-check-list-modal").click(function() {
        if ($('#add-check-list').modal('hide')) {
            // console.log("test: ", $('#modal-check-list-items').children('.modal-input-add-checklist-item').length);
            let items = $('#modal-check-list-items').children('.modal-input-add-checklist-item').length;
            if (items > 1) {
                for (let a = 0; a <= items - 1; a++) {
                    $(".modal-input-add-checklist-item").remove();
                    // console.log("loop:", a);
                }
            }
        }
    });
    //  Add check list Item
    var num = 1;

    $("#add-check-list-item").click(function() {
        // if ($('#add-check-list').modal('show')){
        //     console.log('show');
        // }

        num = num + 1;
        // console.log("num:", num);
        $('#close-add-check-list-modal').before("<div class=\"form-group modal-input-add-checklist-item\">\n" +
            "\n" +
            "              <div class=\"input-group mb-3\">\n" +
            "                  <div class=\"input-group-prepend\">\n" +
            "                      <span class=\"input-group-text\"><i class=\"fas fa-plus-circle\"></i></span>\n" +
            "                  </div>\n" +
            "                  <input  type=\"text\" class=\"form-control\" name='checklist[" + num + "]'>\n" +
            "              </div>\n" +
            "          </div> ");

        // console.log("test: ", $('#modal-check-list-items').children('.modal-input-add-checklist-item').length);
    });



//  ------------ Add friends ----------
 num = 1;

// $("#add-friend-item").click(function() {
//     num = num + 1;
//     // console.log("num:", num);
//     $('#close-add-friend-modal').before("<div class=\"form-group modal-input-add-checklist-item\">\n" +
//         "\n" +
//         "              <div class=\"input-group mb-3\">\n" +
//         "                  <div class=\"input-group-prepend\">\n" +
//         "                      <span class=\"input-group-text\"><i class=\"fas fa-person-booth\"></i></span>\n" +
//         "                  </div>\n" +
//         "                  <input  type=\"text\" class=\"form-control\" name='checklist[" + num + "]'>\n" +
//         "<div class=\"input-group-prepend\">\n" +
//         "                                <button type=\"submit\"><i class=\"fa fa-trash-alt\"></i></button>\n" +
//         "                            </div>"+
//                 "              </div>\n" +
//         "          </div> ");
//     console.log("test: ", $('#modal-check-list-items').children('.modal-input-add-checklist-item').length);
//     let fieldPair = '';
//     $(":input").each(function(){
//         fieldPair += $(this).attr("name") + ':' + $(this).val() + ';';
//     });
//     console.log(fieldPair);

// });


$(function() {
    $('form:not(#addFriendForm,#add_check_list_item_form,#add_comment_form)').submit(function() {
        let $empty_fields = $(this).find(':input').filter(function() {
            return $(this).val() === '';
        });
        $empty_fields.prop('disabled', true);
        return true;
    });
});

 // ----------- Remove btn confirm with sweet alert -------------------------
 $('.removeTdoBtn').on('click', function(e){
    e.preventDefault();
    let delHref = $(this).attr('href');
    Swal.fire({
      title:'آیا مطمئنید؟',
      text:'مطمئنید که میخواهید پاک کنید؟',
      type:'warning',
      showCancelButton: true,
        cancelButtonText:'انصراف',
      confirmButtonText: 'پاک کن!'
    }).then((result) => {
      if (result.value) {
        document.location.href = delHref;
      }
    })
  });
  // ----------- Remove btn confirm with sweet alert -------------------------
// _____________________ PARSLEY ADD VALIDATION __________________________
//has uppercase
window.Parsley.addValidator('uppercase', {
    requirementType: 'number',
    validateString: function(value, requirement) {
        let upperCases = value.match(/[A-Z]/g) || [];
        return upperCases.length >= requirement;
    },
    messages: {
        en: 'پسورد شما باید حداقل (%s) حرف یزرگ داشته باشد.'
    }
});

//has lowercase
window.Parsley.addValidator('lowercase', {
    requirementType: 'number',
    validateString: function(value, requirement) {
        let lowerCases = value.match(/[a-z]/g) || [];
        return lowerCases.length >= requirement;
    },
    messages: {
        en: 'پسورد شما باید حداقل (%s) حرف کوچک داشته باشد.'
    }
});

//has number
window.Parsley.addValidator('number', {
    requirementType: 'number',
    validateString: function(value, requirement) {
        let numbers = value.match(/[0-9]/g) || [];
        return numbers.length >= requirement;
    },
    messages: {
        en: 'پسورد شما باید حداقل (%s) عدد داشته باشد.'
    }
});

//has special char
window.Parsley.addValidator('special', {
    requirementType: 'number',
    validateString: function(value, requirement) {
        var specials = value.match(/[^a-zA-Z0-9]/g) || [];
        return specials.length >= requirement;
    },
    messages: {
        en: 'پسورد شما باید حداقل (%s) کاراکتر خاص داشته باشد.'
    }
});
// _____________________ END PARSLEY ADD VALIDATION __________________________
});

// Set range date for tasks
function setRangeDate(start_id, end_id, start_data_text_id, end_data_text_id, start,end){
    // let start_y = {{ $todo_start_geo[0] }};
    // start_m = start_m -1;
    // end_m = end_m -1;
    // console.log(typeof(start_d));
    $(start_id).MdPersianDateTimePicker({
    // console.log(typeof(start_d));

    targetTextSelector: start_data_text_id,
    targetDateSelector: '#inputDate1-1',
    dateFormat: 'yyyy-MM-dd',
    isGregorian: false,
    enableTimePicker: true,
    disableBeforeToday: false,
    disableBeforeDate: new Date(start),
    disableAfterDate: new Date(end),
});
$(end_id).MdPersianDateTimePicker({
    targetTextSelector: end_data_text_id,
    targetDateSelector: '#inputDate1-1',
    dateFormat: 'yyyy-MM-dd',
    isGregorian: false,
    enableTimePicker: true,
    disableBeforeToday: false,
    disableBeforeDate: new Date(start),
    disableAfterDate: new Date(end),
});

}
