<!--        add todoModal     -->
<div class="modal fade" id="mainAddModal"  role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ایجاد انجام جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="errorBox">
                    <ul>

                    </ul>
                </div>
                <form id="add_todo_form" action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">عنوان</label>
                        <input type="text" class="form-control" id="recipient-name" name="todo[title]" required
                               data-parsley-trigger-after-failure="keyup"
                               data-parsley-errors-container="#errorBox"
                               data-parsley-error-message="<span style='line-height: 1.5;'>لطفا عنوان را وارد کنید!</span>">
                    </div>
                    <div class="form-row">


                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text cursor-pointer" id="date1">شروع</span>
                                </div>
                                <input type="text" id="inputDate1-text" class="form-control" placeholder="Persian Calendar Text"
                                       aria-label="date1" aria-describedby="date1" required name="todo[start]"
                                       data-parsley-trigger="focusout"
                                       data-parsley-trigger-after-failure="focusout"
                                       data-parsley-errors-container="#errorBox"
                                       data-parsley-error-message="<span style='line-height: 1.5;'> لطفا تاریخ شروع را وارد کنید!<span>">

                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text cursor-pointer" id="date2">پایان</span>
                                </div>
                                <input type="text" id="inputDate2-text" class="form-control" placeholder="Persian Calendar Text"
                                       aria-label="date2" aria-describedby="date2" name="todo[end]" required
                                       data-parsley-trigger="focusout"
                                       data-parsley-trigger-after-failure="focusout"
                                       data-parsley-errors-container="#errorBox"
                                       data-parsley-error-message="<span style='line-height: 1.5;'>لطفا تاریخ پایان را وارد کنید!</span>">

                            </div>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------ -->


                    <div class="form-row">

                        <div class="form-group form-check    col-md-6">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="choice" id="radio_1" class="chk-test" required>
                                <label for="radio_1">گروهی</label>

                                <div class="reveal-if-active">

                                    <div class="dropdown">
                                        <button id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="select_user_btn" class="btn btn-info" type="button">
                                            مشارکت کنندگان
                                        </button>
                                        @if(count($friends) > 0)
                                        <div>
                                            <ul id="select_user_menu" class=" dropdown-menu checkbox-menu allow-focus overflow-auto" aria-labelledby="dropdownMenu1"
                                                style="max-height: 200px;">
                                                @foreach ($friends as $item)
                                                    <li class="dropdown-item friendList">
                                                        <label>
                                                            <input class="chkB form-check-input" type="checkbox" name="todo[type][collaborative][{{ $item->id }}]" value="{{ $item->id }}"> {{ $item->name}}
                                                        </label>
                                                    </li>
                                                @endforeach


                                            </ul>
                                        </div>
                                        @endif

                                    </div>

                                    <div id="overlay"></div>


                                </div>
                            </div>
                        </div>


                        <div class="form-group form-check   col-md-6">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="choice_2" class="chk-test"  name="choice">

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


<!--       End add todoModal     -->

<script >

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
    });

</script>
