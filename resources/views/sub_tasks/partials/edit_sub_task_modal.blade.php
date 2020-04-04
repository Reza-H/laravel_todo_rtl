
            <!--        Modal Edit Task    -->


            <div class="modal fade" id="edit_sub_task_Modal"  role="dialog" aria-labelledby="editTaskModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskModalLabel">ویرایش</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="editErrorBox">
                                <ul>

                                </ul>
                            </div>
                            <form id="edit_subtask_form" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="sub_task_id" name="id" value="">

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">عنوان</label>
                                    <input type="text" class="form-control" id="name" name="subtask[name]" required
                                           data-parsley-trigger-after-failure="keyup"
                                           data-parsley-errors-container="#editErrorBox"
                                           data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>"
                                    >
                                </div>
                                <div class="form-row">


                                    <div class="form-group col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text cursor-pointer" id="edit_sub_task_start">شروع</span>
                                            </div>
                                            <input type="text" name="subtask[start]" id="edit_sub_task_start_text" class="form-control" placeholder="Persian Calendar Text"
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
                                                <span class="input-group-text cursor-pointer" id="edit_sub_task_end">پایان</span>
                                            </div>
                                            <input type="text" id="edit_sub_task_end_text" name="subtask[end]" class="form-control" placeholder="Persian Calendar Text"
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

                                    @if ( Auth::user()->id  == intval($todo_owner) )
                                    <div class="form-group form-check  col-12">

                                        <select class="form-control" name="user" id="sub_task_edit_user">
                                            @foreach ($participants as $participant)
                                                <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                                            @endforeach>
                                          </select>

                                  </div>
                                    @else


                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2">{{ Auth::user()->name  }}</span>
                                          </div>
                                    <input type="text" class="form-control" value="{{ Auth::user()->email  }}" readonly>
                                    <input type="hidden" name="user" value="{{ Auth::user()->id  }}">

                                      </div>



                                    @endif

                                </div>


                                <!-- ------------------------------------------------------------------ -->
                                <input type="submit" value="ویرایش"  class="btn btn-primary">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </form>
                        </div>
                        <!-- <div class="modal-footer"></div> -->
                    </div>
                </div>
            </div>



            <!--    End Modal Edit Task    -->
            <script>
                $('#edit_subtask_form').on('submit', function(e){
                    e.preventDefault();
                    let form = document.getElementById('edit_subtask_form');
                    let sub_task_id =  document.querySelector('#edit_subtask_form #sub_task_id').value;
                    form.setAttribute('action',`/todo/{{ $todo_id }}/task/{{ $task_id }}/subs/${sub_task_id}`);
                    form.submit();
                    // console.log(form);
                })
            
            </script>