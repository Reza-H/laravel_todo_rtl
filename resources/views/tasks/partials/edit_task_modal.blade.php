<!--        Modal Edit Task    -->
<span id='todo_type_x' data-todotype=""></span>

<div class="modal fade" id="editTaskModal"  role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
 <div class="modal-header">
   <h5 class="modal-title" id="editTaskModalLabel">ویرایش تسک</h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
 </div>
 <div class="modal-body">
   <div id="editErrorBox">
     <ul>

     </ul>
   </div>
   <form id="edit_task_form" action="" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" id="task_id" name="id" value="">
     <div class="form-group">
       <label for="edit_name" class="col-form-label" >عنوان</label>
       <input type="text" class="form-control" id="edit_name" name="task[name]"
              value="title"
              required data-parsley-trigger-after-failure="keyup"
              data-parsley-errors-container="#editErrorBox"
              data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>">
     </div>
     <div class="form-row">


       <div class="form-group col-md-6">
         <div class="input-group">
           <div class="input-group-prepend">
             <span class="input-group-text cursor-pointer" id="edit_modal_start">شروع</span>
           </div>
           <input type="text" id="edit_start" class="form-control" placeholder="Persian Calendar Text"
                  aria-label="date1" aria-describedby="date1" name="task[start]" value="start time" required
                  data-parsley-trigger="focusout"
                  data-parsley-trigger-after-failure="focusout"
                  data-parsley-errors-container="#editErrorBox"
                  data-parsley-error-message="<span style='line-height: 1.5;'> لطفا تاریخ شروع را وارد کنید!<span>">

         </div>
       </div>
       <div class="form-group col-md-6">
         <div class="input-group">
           <div class="input-group-prepend">
             <span class="input-group-text cursor-pointer" id="edit_modal_end">پایان</span>
           </div>
           <input type="text" id="edit_end" class="form-control" placeholder="Persian Calendar Text"
                  aria-label="date2" aria-describedby="date2" name="task[end]" value="end time" required
                  data-parsley-trigger="focusout"
                  data-parsley-trigger-after-failure="focusout"
                  data-parsley-errors-container="#editErrorBox"
                  data-parsley-error-message="<span style='line-height: 1.5;'>لطفا تاریخ پایان را وارد کنید!</span>" >

         </div>
       </div>
     </div>

     <!-- ------------------------------------------------------------------ -->


     <div class="form-row" id="colab">

       <div class="form-group form-check  col-md-6">
         <div class="custom-control custom-radio">
           <input type="radio"   name="choice" id="choice_1_edit"  class="edit_radio_type radio_task"  required>
           <label for="choice_1_edit">گروهی</label>

           <div class="reveal-if-active">

             <div class="dropdown">
               <button id="select_user_btn_edit" class="btn btn-info" type="button">

                 مشارکت کنندگان
               </button>
               <div>
                 <ul id="select_user_menu_edit" class=" dropdown-menu checkbox-menu allow-focus overflow-auto" aria-labelledby="dropdownMenu1"
                     style="max-height: 200px;">

                     @foreach ($participants as $participant)
                   <li class="dropdown-item">
                     <label>
                       <input class="chkB form-check-input" type="checkbox" id='user-{{ $participant->id }}' name="task[type][collaborative][{{ $participant->id }}]" value="{{ $participant->id }}"> {{ $participant->name }}
                     </label>
                   </li>
                   @endforeach
                 </ul>
               </div>
             </div>
             <div class="overlay"></div>

           </div>
         </div>
       </div>


       <div class="form-group form-check   col-md-6">
         <div class="custom-control custom-radio">
           <input type="radio"  id="choice_2_edit"  class="edit_radio_type radio_task"  name="choice">
           <label for="choice_2">شخصی</label>
           <div class="reveal-if-active">

            <div>
                <label class="my-1 mr-2" for="task_edit_indi"></label>
                <select class="custom-select my-1 mr-sm-2 indivisual-select" id="task_edit_indi" name="task[type][individual][id]">
                    <option  selected>...</option>
                    @foreach ($participants as $participant)
                    <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                    @endforeach

                </select>
            </div>
             <div class="overlay"></div>

           </div>
         </div>
       </div>

     </div><!-- End .form-row #collab -->

     <div class="form-row" id="indi">
        <div class="form-group col-md-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="task_user_name_todo_indi"></span>
                  </div>
                <input type="text" class="form-control" placeholder="Your Email" id="task_user_email_todo_indi" value="" readonly >
                <input type="hidden" name="task[type][individual][id]" id="task_user_id_todo_indi" value="">

              </div>
          </div>
     </div><!-- End #indi -->


     <!-- ------------------------------------------------------------------ -->
     <input type="submit" value="ویرایش"  class="btn btn-primary">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
   </form>
 </div>
 <!-- <div class="modal-footer"></div> -->
</div>
</div>
</div>

<script>
    $('#edit_task_form').on('submit', function(e){
        e.preventDefault();
        let todo_type = document.getElementById('todo_type_x').dataset.todotype;
        let form = document.getElementById('edit_task_form');
        let task_id =  document.querySelector('#edit_task_form #task_id').value;
        form.setAttribute('action',`/todo/{{ $todo_id }}/tasks/${task_id}`);

        if(todo_type === 'collaborative'){
            if(document.getElementById('choice_1_edit').checked){
                document.getElementById('task_edit_indi').disabled = true;
            }else if(document.getElementById('choice_2_edit').checked){
                document.getElementById('choice_1_edit').disabled = true;
            }
        }
        form.submit();
        // console.log(form);
    })

</script>

<!--    End Modal Edit Task    -->
