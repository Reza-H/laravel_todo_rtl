
   <!-- Modal Add New Task-->

   <div class="modal fade" id="mainAddModal"  role="dialog" aria-labelledby="addNewSubTaskModalLabel"
   aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addNewSubTaskModalLabel">ایجاد تسک جدید</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div id="errorBox">
                  <ul>

                  </ul>
              </div>
              <form id="add_subtask_form" action="/todo/{{ $todo_id }}/task/{{ $task_id }}/subs" method="POST">
                @csrf
                  <div class="form-group">
                      <label for="recipient-name" class="col-form-label">عنوان</label>
                      <input type="text" class="form-control" id="recipient-name" name="subtask[name]" required
                             data-parsley-trigger-after-failure="keyup"
                             data-parsley-errors-container="#errorBox"
                             data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>">
                  </div>
                  <div class="form-row">


                      <div class="form-group col-md-6">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text cursor-pointer" id="sub_task_start">شروع</span>
                              </div>
                              <input type="text" id="sub_task_start_text" class="form-control" placeholder="Persian Calendar Text"
                                     aria-label="date1" aria-describedby="date1" name="subtask[start]" required
                                     data-parsley-trigger="focusout"
                                     data-parsley-trigger-after-failure="focusout"
                                     data-parsley-errors-container="#errorBox"
                                     data-parsley-error-message="<span style='line-height: 1.5;'> لطفا تاریخ شروع را وارد کنید!<span>">

                          </div>
                      </div>
                      <div class="form-group col-md-6">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text cursor-pointer" id="sub_task_end">پایان</span>
                              </div>
                              <input type="text" id="sub_task_end_text" class="form-control" placeholder="Persian Calendar Text"
                                     aria-label="date2" aria-describedby="date2" name="subtask[end]" required
                                     data-parsley-trigger="focusout"
                                     data-parsley-trigger-after-failure="focusout"
                                     data-parsley-errors-container="#errorBox"
                                     data-parsley-error-message="<span style='line-height: 1.5;'>لطفا تاریخ پایان را وارد کنید!</span>">

                          </div>
                      </div>
                  </div>

                  <!-- ------------------------------------------------------------------ -->


                  <div class="form-row">
                    @if ( Auth::user()->id  == intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
                    <div class="form-group form-check  col-12">

                        <select class="form-control" name="user">
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
                  <input type="submit" value="ایجاد"  class="btn btn-primary">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
              </form>
          </div>
          <!-- <div class="modal-footer"></div> -->
      </div>
  </div>
</div>
<!-- End Modal Add New Task-->
