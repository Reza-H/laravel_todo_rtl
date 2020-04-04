 <!-- Modal Add New Task-->
 <div class="modal fade" id="add_task_modal"  role="dialog" aria-labelledby="add_new_task_Modal_Label"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="add_new_task_Modal_Label">ایجاد تسک جدید</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <div id="errorBox">
         <ul>

         </ul>
       </div>
      <form id="add_task_form" action="{{ route('tasks.store', $todo_id) }}" method="POST">
        @csrf
         <div class="form-group">
           <label for="recipient-name" class="col-form-label">عنوان</label>
           <input type="text" class="form-control" id="recipient-name" name="task[name]" required
                  data-parsley-trigger-after-failure="keyup"
                  data-parsley-errors-container="#errorBox"
                  data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>">
         </div>
         <div class="form-row">


           <div class="form-group col-md-6">
             <div class="input-group">
               <div class="input-group-prepend">
                 <span class="input-group-text cursor-pointer" id="task_start">شروع</span>
               </div>
               <input type="text" id="inputDate1-text" class="form-control" placeholder="Persian Calendar Text"
                 aria-label="date1" aria-describedby="date1" required name="task[start]"
                      data-parsley-trigger="focusout"
                      data-parsley-trigger-after-failure="focusout"
                      data-parsley-errors-container="#errorBox"
                      data-parsley-error-message="<span style='line-height: 1.5;'> لطفا تاریخ شروع را وارد کنید!<span>">

             </div>
           </div>
           <div class="form-group col-md-6">
             <div class="input-group">
               <div class="input-group-prepend">
                 <span class="input-group-text cursor-pointer" id="task_end">پایان</span>
               </div>
               <input type="text" id="inputDate2-text" class="form-control" placeholder="Persian Calendar Text"
                 aria-label="date2" aria-describedby="date2" name="task[end]" required
                      data-parsley-trigger="focusout"
                      data-parsley-trigger-after-failure="focusout"
                      data-parsley-errors-container="#errorBox"
                      data-parsley-error-message="<span style='line-height: 1.5;'>لطفا تاریخ پایان را وارد کنید!</span>">

             </div>
           </div>
         </div>

         <!-- ------------------------------------------------------------------ -->


         <div class="form-row">
            @if ($todo_type === 'collaborative')

            <div class="form-group form-check  col-md-6">
                <div class="custom-control custom-radio">
                  <input type="radio" name="choice"  id="choice_1" class="chk-test radio_task" required >
                  <label for="radio_1">گروهی</label>

                  <div class="reveal-if-active">

                    <div class="dropdown">
                      <button id="select_user_btn" class="btn btn-info" type="button">

                        مشارکت کنندگان
                      </button>
                      <div>

                        <ul id="select_user_menu" class=" dropdown-menu checkbox-menu allow-focus overflow-auto" aria-labelledby="dropdownMenu1"
                            style="max-height: 200px;">
                            @foreach ($participants as $participant)
                            <li class="dropdown-item">
                               <label>
                                 <input class="chkB form-check-input" type="checkbox" name="task[type][collaborative][{{ $participant->id }}]" value=" {{ $participant->id }} "> {{ $participant->name }}
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
                  <input type="radio" name="choice" id="choice_2" class="chk-test radio_task" >
                  <label for="choice_2">شخصی</label>
                  <div class="reveal-if-active">

                      <div>
                          <label class="my-1 mr-2" for="inlineFormCustomSelectPref"></label>
                          <select class="custom-select my-1 mr-sm-2 indivisual-select" id="inlineFormCustomSelectPref" name="task[type][individual][id]" required="">
                          <option  value="{{ Auth::user()->id }}" selected>...</option>
                              @foreach ($participants as $participant)
                              <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                              @endforeach

                          </select>
                      </div>
                      <div class="overlay"></div>

                    </div>
                </div>
              </div>

            @elseif($todo_type === 'individual')

          <div class="form-group col-md-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" >{{ Auth::user()->name }}</span>
                  </div>
                <input type="text" class="form-control" placeholder="Your Email"   value="{{ Auth::user()->email }}" readonly >
                <input type="hidden" name="task[type][individual][id]"  value="{{ Auth::user()->id }}">

              </div>
          </div>
            @endif


         </div>


         <!-- ------------------------------------------------------------------ -->
         <input type="submit" value="ایجاد"  class="btn btn-primary">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
       </form>
     </div>
     <!-- <div class="modal-footer"></div> -->
   </div>
 </div>
</div>

<!-- End Modal -->
<script>

    let el = document.querySelectorAll('.radio_task');
    let radio_1 = document.getElementById('choice_1');
    let radio_2 = document.getElementById('choice_2');
    let individual = document.getElementById('inlineFormCustomSelectPref');

    for(var i=0; i < el.length; i++){
        el[i].addEventListener('change', function () {
            if(radio_1.checked === true){
                individual.disabled = true
            }else if(radio_2.checked === true){

                individual.disabled = false
            }
        }, false);
    }
</script>
