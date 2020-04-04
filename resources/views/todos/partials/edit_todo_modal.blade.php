<!--        Modal Edit todoModal    -->
<div class="modal fade" id="editTodoModal"  role="dialog" aria-labelledby="editTodoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTodoModalLabel">ویرایش انجام</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editErrorBox">
                    <ul>

                    </ul>
                </div>
                <form id="edit_todo_form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="" id="todo_id">
                    <div class="form-group">
                        <label for="edit_name" class="col-form-label">عنوان</label>
                        <input type="text" class="form-control" id="edit_name" name="todo[name]" required
                               data-parsley-trigger-after-failure="keyup"
                               data-parsley-errors-container="#editErrorBox"
                               data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>"

                        >
                    </div>
                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text cursor-pointer" id="edit_modal_start">شروع</span>
                                </div>
                                <input type="text" name="todo[start]" id="edit_start" class="form-control" placeholder="Persian Calendar Text"
                                       aria-label="date1" aria-describedby="date1" required
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
                                <input type="text" id='edit_end' name="todo[end]" class="form-control" placeholder="Persian Calendar Text"
                                       aria-label="date2" aria-describedby="date2" required
                                       data-parsley-trigger="focusout"
                                       data-parsley-trigger-after-failure="focusout"
                                       data-parsley-errors-container="#editErrorBox"
                                       data-parsley-error-message="<span style='line-height: 1.5;'>لطفا تاریخ پایان را وارد کنید!</span>">

                            </div>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------ -->


                    <div class="form-row">

                        <div class="form-group form-check  col-md-6">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="todo[type]"  id="choice_1_edit"  class="edit_radio_type" required>
                                <label for="radio_1">گروهی</label>

                                <div class="reveal-if-active">

                                    <div class="dropdown">
                                        <button id="select_user_btn_edit" class="btn btn-info" type="button">

                                            مشارکت کنندگان
                                        </button>
                                        <div>
                                            <ul id="select_user_menu_edit" class=" dropdown-menu checkbox-menu allow-focus overflow-auto" aria-labelledby="dropdownMenu1"
                                                style="max-height: 200px;">
                                                @foreach ($friends as $item)
                                                <li class="dropdown-item friendList">
                                                    <label>
                                                        <input class="chkB form-check-input chkB" type="checkbox" name="todo[type][collaborative][{{ $item->id }}]" value="{{ $item->id }}"> {{ $item->name}}
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
                                <input type="radio" name="todo[type]" id="choice_2_edit"  class="edit_radio_type">
                                <input type="hidden" id="indi" name="todo[type][individual]">
                                <label for="choice_2">شخصی</label>

                            </div>
                        </div>

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
<!--    End Modal Edit Task    -->
<script>
$(document).ready(function(){
    $('#edit_todo_form').on('submit', function(e){
    e.preventDefault();
    let form = document.getElementById('edit_todo_form');
    let todo_id =  document.querySelector('#edit_todo_form #todo_id').value;
    form.setAttribute('action',`/todos/${todo_id}`);
    if(document.getElementById('choice_1_edit').checked){
        document.getElementById('indi').disabled = true;
    }else if(document.getElementById('choice_2_edit').checked){
        document.getElementById('choice_1_edit').disabled = true;
    }
    form.submit();
    // console.log(form);
})

});

</script>

