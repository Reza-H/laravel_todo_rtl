@extends('layouts.app')
@section('content')
<script>
    function toolster(number) {
        $('#tool_'+ number).tooltipster({
            animation: 'fade',
            delay: 200,
            theme: 'tooltipster-borderless',
            trigger: 'hover'
        });
    }
</script>
{{-- {{dd($tasks[0]->users)}} --}}
    <style>
        #plus {
            z-index: 99999;
        }

    </style>
    {{-- {{ dd(in_array(Auth::user()->id, $co_admins)) }} --}}
<span id="todoid" data-tid="{{ $todo_id }}"></span>
    <div id="info-box" class="mt-2">
        <div class="container main-shadow bg-white">
            <div class="row mt-1 mb-2">
                <div class="col-5 text-center">
                    <div class="start">
                        <span>شروع: {{ $todo_start_jalali }}</span>
                    </div>
                </div>
                <div class="col-2 text-center ">
                    <a href="#" class="btn btn-sm " data-placement="bottom" data-toggle="modal"
                       data-target="#participant_modal">مشارکت کنندگان</a>

                </div>
                <div class="col-5 text-center">
                    <div class="start">
                        <span>پایان: {{ $todo_end_jalali }}</span>
                        <div style="max-width: 25%; float: left;">
                            <a href="/todos" class="btn btn-default"><i class="fas fa-chevron-circle-left"></i></a>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <div id="main-container" class="container mt-3 " style="position: relative;">

        <div class="main-row todo_list row " style="overflow-y: auto !important;">


            <!-- <div class="row"> -->
            <div class="col-md-12" id="todo_id" data-todoid="{{ $todo_id }}">

                <div class="table-responsive bg-white w-100 p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col" style="width: 3%;">#</th>
                            <th class="text-center" scope="col" style="width: 40%;"> نام تسک</th>
                            <th class="text-center" scope="col" style="width: 16%;">شروع</th>
                            <th class="text-center" scope="col" style="width: 16%;">پایان</th>
                            <th class="text-center" scope="col" style="width: 10%;">نوع</th>
                            <th class="text-center" scope="col" style="width: 5%;">وضعیت</th>
                            <th class="text-center" scope="col" style="width: 5%;">ویرایش</th>
                            <th class="text-center" scope="col" style="width: 5%;">حذف</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($tasks as $task)
                            <tr id="task_{{ $task->id }}">
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><a href="/todo/{{ $todo_id }}/task/{{ $task->id }}/subs" class="name">{{$task->name}}</a></td>
                                <td class="text-center" class="start">{{$task->start_at}}</td>
                                <td class="text-center" class="end"> {{$task->end_at}}</td>
                                <td id="tool_{{ $task->id }}" onmouseover="toolster({{ $task->id }})"
                                    data-tooltip-content="#tooltip_content_{{ $task->id }}"
                                    class="text-center"
                                    class="type">{{$task->type == 'individual' ? 'شخصی': 'گروهی'}}</td>
                                    <div class="tooltip_templates">
                                        <div id="tooltip_content_{{ $task->id }}">
                                            <ul style="list-style-type: none;">
                                              @foreach ($task->users as $user)
                                            <li>{{ $user->name }}</li>
                                              @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                <td class="text-center"><a><i class="fas fa-{{ $task->is_done == true ? 'check' : 'clock' }} text-success"></i></a></td>
                                @if (Auth::user()->id === intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
                                <td class="text-center">
                                    <a href="#" id="{{ $task->id }}" class="edit_btn">
                                        <i class="fas fa-pen text-warning"></i>
                                    </a>
                                </td>
                                @endif
                                @if (Auth::user()->id === intval($todo_owner))
                                <td class="text-center">
                                    <a href="#" class="removeTaskBtn" data-taskid="{{ $task->id }}">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>
                                @endif
                                @if (Auth::user()->id !== intval($todo_owner))
                                <td class="text-center"><i class="fa fa-lock " aria-hidden="true"></i>
                                </td>
                                @endif
                                @if (Auth::user()->id !== intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
                                <td class="text-center"><i class="fa fa-lock" aria-hidden="true"></i>
                                </td>
                                @endif

                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                </div>

                @if (Auth::user()->id === intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
                @include('tasks.partials.add_task_modal')
                @include('tasks.partials.edit_task_modal')
                @endif



            </div>

            <!-- </div> -->


        </div>


    </div>


    @include('tasks.partials.participant_modal')



@endsection
@section('custom_js')
    <script>
$(document).ready(function () {
        // console.log(parseInt({{ $todo_start_geo[0] }}));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]'),
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

        });
        $(function () {
            let info_box = $('#info-box');
            if (info_box.scrollHeight > info_box.clientHeight) {
                alert("overflow");
            }
        });

            $('#add_task_form').parsley();
            $('#edit_task_form').parsley();

            let start ='{{$todo_start_geo}}';
            let end = '{{$todo_end_geo}}';
            // console.log("todo=> " + x);
            setRangeDate('#task_start','#task_end','#inputDate1-text','#inputDate2-text',start,end);


        @if (Auth::user()->id === intval($todo_owner) || in_array(Auth::user()->id, $co_admins))

        var reload = false;

        //------------ Add Friends Ajax ------------
        $('#addFriendForm').submit(function (e) {
            e.preventDefault();
            let frm = this;
            let todo_id = document.getElementById('todoid').dataset.tid;
            let route = $('#addFriendForm').data('route');
            let formData = $(this);
            $.ajax({
                type: 'POST',
                url: route,
                data: formData.serialize(),
                success: function (Response) {
                    if (Response.FRIEND) {
                        let form = document.createElement('div');
                        let newFriend = `
                    <form data-delroute="{{ route('delete_participant', $todo_id) }}" class="Remove_Friend_Form" >
                        @method('DELETE')
                        @csrf
                        <div class="form-group modal-input-add-checklist-item">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">${Response.FRIEND[0].name}</span>
                                </div>
                                <input type="email" class="form-control" disabled name="email" value="${Response.FRIEND[0].email}">
                                @if (Auth::user()->id === intval($todo_owner))
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text" ><i class="fa fa-trash"></i></button>
                                    <a href="#" data-uid="${Response.FRIEND[0].id}" data-todoid="${todo_id}" data-isco="0" class="input-group-text add_co_admin" title="افزودن به عنوان همیار مدیر" ><i id="pu_${Response.FRIEND[0].id}" class="fas fa-star" style="font-weight: 400;"></i></a>
                                </div>
                                @endif
                            </div>
                        </div>
                        </form>
                    `;
                        form.innerHTML = newFriend;
                        document.getElementById('friendList').appendChild(form);
                        frm.reset();
                    }
                    ialert(Response);
                    reload = true;
                }//--End success--
            });//--End ajax--
        });//--End Add Friends Ajax--

        //--------------- Remove friend------------------
        $('#friendList').on('submit', '.Remove_Friend_Form', function (e) {
            e.preventDefault();
            $(this).find('input[type=email]').prop('disabled', false);
            let input = $(this);
            let delRoute = $(this).data('delroute');
            let delFormData = $(this);
            $.ajax({
                type: 'DELETE',
                url: delRoute,
                data: delFormData.serialize(),
                success: function (Result) {
                    if(Result.WARN){
                        $(this).find('input[type=email]').prop('disabled', true);
                        ialert(Result);
                    }else{
                    input.remove();
                    ialert(Result);
                    }
                    reload = true;
                }//--End success--
            });//--End ajax--
        });//--End Remove friend--

        $(document).on('click', '.edit_btn', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let todo_id = parseInt( {{ $todo_id }} );
            $.ajax({
                url: "/todo/" + todo_id + "/tasks/" + id + "/edit",
                dataType: "json",
                data: {
                    id: id,
                },
                type: "GET",
                success: function (html) {
                    console.log(html);
                    let task_id = html.data.task.id;
                    document.querySelector('#edit_task_form #task_id').value = task_id;
                    $('#edit_task_form #edit_name').val(html.data.task.name);
                    let start = html.data.todo_start;
                    let end = html.data.todo_end;
                    $('#edit_start').val(html.data.task.start_at);
                    $('#edit_end').val(html.data.task.end_at);
                    // check boxes
                    let users = html.data.task_users;
                    if(html.data.todo_type === 'collaborative'){
                        if($('#indi').length > 0){
                            document.getElementById('indi').remove();
                        }


                        document.getElementById('todo_type_x').dataset.todotype = 'collaborative';
                        if(html.data.task.type === 'individual'){
                        document.getElementById('choice_2_edit').checked = true;
                        let options = document.getElementById('task_edit_indi').options;
                        options = Array.from(options);

                        options.map(function(opt){
                            if(html.data.task_users === opt.value){
                                opt.selected = true;
                            }
                        });
                        } else if(html.data.task.type === 'collaborative'){
                            document.getElementById('choice_1_edit').checked = true;
                            document.getElementById('task_edit_indi').options[0].selected = true
                            let checkboxes = document.querySelectorAll('#edit_task_form .chkB');
                            checkboxes = Array.from(checkboxes);
                            let users = html.data.task_users; // Array of users

                            // Check every single of users with every single of checkboxe's valus
                            checkboxes.map(function(checkbox){
                                users.map(function(user){
                                    if(checkbox.value == user){
                                        checkbox.checked = true;
                                        checkbox.parentElement.parentElement.className +=' active';
                                    }
                                });
                            });
                        }

                    }else if(html.data.todo_type === 'individual'){
                        document.getElementById('todo_type_x').dataset.todotype = 'individual';
                        if($('#colab').length > 0){
                            document.getElementById('colab').remove();
                        }

                        document.getElementById('task_user_name_todo_indi').textContent = html.data.task_user_name;
                        document.getElementById('task_user_email_todo_indi').value = html.data.task_user_email;
                        document.getElementById('task_user_id_todo_indi').value = html.data.task_users;


                    }



                    setRangeDate('#edit_modal_start', '#edit_modal_end','#edit_start','#edit_end',start,end);
                    $('#editTaskModal').modal('show');
                }//--End success
            })//--End ajax
        });//--End edit--

         //-- Remove task----
         $(document).on('click','.removeTaskBtn', function(e){
            e.preventDefault();
            let task_id = this.dataset.taskid;
            let route = `/task/${task_id}`;
            console.log('task_id: '+ task_id);
            $.confirm({
                title: 'مطمينید',
                content: 'پاک شود؟',
                buttons: {
                    confirm:{
                        text: 'پاک شود',
                        btnClass:'btn-danger',
                        action:function(){
                            $.ajax({
                                type:'DELETE',
                                url:route,
                                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                                success:function(Response){
                                    if(Response.ok == true){
                                        console.log(Response);
                                    let el = document.getElementById('task_'+task_id);
                                    console.log(el);
                                    el.remove();
                                    }
                                    ialert(Response);
                                }//--End success
                            });//-- End ajax--
                        }
                    },//--End confirm btn
                    cancel:{
                        text: 'لغو',
                    },//--End cancel btn
                }//--End btns
            });//-- End confirm--
        })//-- End remove task--

        document.getElementById('main_plus_btn').dataset.target='';
        $(document).on('click', '#main_plus_btn', function(e){
            e.preventDefault()
            let todo_id = document.getElementById('todo_id').dataset.todoid;
            let route = `/todo/type/${todo_id}`;
            $.ajax({
                type:'POST',
                url: route,
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(Response){
                    if(Response.type === 'individual'){
                        console.log('individual');
                    }
                    if(Response.type === 'collaborative'){
                        console.log('collaborative');
                    }
                    console.log(Response);
                }//--End success--
            });//--End ajax--
            $('#add_task_modal').modal('show');
        })// End plus event
        $('#participant_modal').on('hide.bs.modal', function (e) {
            if(reload === true){
                location.reload();
            }
        })

        @endif

        $(document).on('click', '.add_co_admin', function(e){
            e.preventDefault();
            let todo_id = this.dataset.todoid;
            let user_id = this.dataset.uid;
            let is_co = this.dataset.isco;
            let itag = document.getElementById(`pu_${user_id}`);
            let new_s;

            if(is_co === '0'){
                new_s = '1';
            }else if(is_co === '1'){
                new_s = '0';
            }
            let datas = {'todo_id':todo_id, 'user_id':user_id, 'state':new_s};
            $.ajax({
                type:'PUT',
                url:`/todo/${todo_id}/addCo`,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:datas,
                success:function(Response){
                    if(Response.ok == '1'){
                        if(Response.state === true){
                            itag.style.fontWeight = '900';
                        }else if(Response.state === false){
                            itag.style.fontWeight = '200';
                        }
                    }
                    ialert(Response);

                }
            });//--End ajax--
       

        })//-- End Add co-admin--
});//--End document.ready()--
</script>
@endsection
@if (Auth::user()->id === intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
@section('plusbtn')

    @include('partials.plusbtn')
@endsection
@endif

