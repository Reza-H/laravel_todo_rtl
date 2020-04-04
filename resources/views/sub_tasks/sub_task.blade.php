@extends('layouts.app')
@section('content')
<span id="tow" data-tow="{{ $todo_owner }}" ></span>
<span id="uli" data-uli="{{ Auth::user()->id}}"></span>

<div id="info-box"  class="mt-2">
    <div class="container main-shadow bg-white" >
        <div class="row mt-1 mb-2">
            <div class="col-5 text-center">
                <div class="start">
                    <span>شروع: {{ $task_start_jalali }}</span>
                </div>
            </div>
            <div class="col-2 text-center ">
                <a href="#" class="btn btn-sm " data-placement="bottom"   data-toggle="modal" data-target="#participant_modal">مشارکت کنندگان</a>

            </div>
            <div class="col-5 text-center">
                <div class="start">
                    <span>پایان: {{ $task_end_jalali }}</span>
                    <div style="max-width: 25%; float: left;">
                        <a href="/todo/{{$todo_id}}/tasks" class="btn btn-default"><i class="fas fa-chevron-circle-left"></i></a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="main-container" class="container mt-3 " style="position: relative;">
    <div  class="main-row todo_list row " style="overflow-y: auto !important;">


        <!-- <div class="row"> -->
        <div class="col-md-12">

    <div class="container mt-2">

        <div class="row bg-success text-center mb-1">
            <div class="col-1 text-center  p-2">#</div>
            <div class="col-3 text-center p-2 ">نام</div>
            <div class="col-1 text-center p-2 ">کاربر</div>
            <div class="col-2 text-center p-2 ">شروع</div>
            <div class="col-2 text-center p-2 ">پایان</div>
            <div class="col-1 text-center p-2 ">وضعیت</div>
            <div class="col-1 text-center p-2 ">ویرایش</div>
            <div class="col-1 text-center p-2 ">حذف</div>



        </div>
    </div>
    @foreach ($sub_tasks as $sub_task)

    @php
        $chklists = $sub_task->ckecklists;
        $total = sizeof($chklists);
        $checked = 0;
        foreach($chklists as $chklist){
            if($chklist->is_done == 1){
                $checked +=  1;
            }
        }
        if($checked > 0){
            $percent = intval(ceil((($checked / $total) * 100)));
        }elseif($checked <= 0  ){
            $percent = 0;
        }

    @endphp
    {{-- {{ dump(intval($percent))}} --}}
    <div class="container mt-2" id="sub_{{ $sub_task->id }}" data-uid="{{ $sub_task->users[0]->id }}" >
        {{-- {{ dump($sub_task->is_done) }} --}}
        <div class="row ">
            <div class="col-1 text-center  p-2">
                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree-sub-{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseThree">{{ $loop->iteration }}</a>
            </div>
            <div class="col-3 text-center p-2 ">
                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree-sub-{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapseThree">{{ $sub_task->name }}</a>
            </div>

            <div class="col-1 text-center p-2 "><span data-toggle="tooltip" data-placement="top" title="{{ $sub_task->users->first()['email']  }}">{{ $sub_task->users->first()['name']  }}</span></div>
            <div class="col-2 text-center p-2 ">{{ $sub_task->start_at }}</div>
            <div class="col-2 text-center p-2 ">{{ $sub_task->end_at }}</div>
            <div class="col-1 text-center p-2 "><span id="done_{{ $sub_task->id }}" data-done="{{ $sub_task->is_done }}"><i class="fas fa-{{$percent === 100 ? 'check' : 'clock'}} text-success"></i></span></div>
            @if( Auth::user()->id == $todo_owner or Auth::user()->id ==$sub_task->users->first()['id'] )
                <div class="col-1 text-center p-2 "><a href="#" class="edit_btn" id="{{ $sub_task->id }}" ><i class="fas fa-pen text-warning"></i></a></div>
                <div class="col-1 text-center p-2 "><a href="#" class="removeSubBtn" data-subid="{{ $sub_task->id }}" data-todoid="{{ $todo_id }}"><i class="fas fa-trash text-danger"></i></a></div>
            @else

            <div class="col-1 text-center p-2 "><i class="fas fa-lock "></i></div>
            <div class="col-1 text-center p-2 "><i class="fas fa-lock "></i></div>
            @endif


        </div>
        <div class="row">
            <div class="col-12">
                <div id="accordion-sub-1">

                    <div id="collapseThree-sub-{{ $loop->iteration }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-sub-1" aria-expanded="false">

                        <div id="accordion-sub-sub-1">
                            <!-- Check List -->

                            <div class="card">
                                <div class="card-header" id="headingThree-sub-1">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 ml-auto">
                                            <h5 class="mb-0">
                                            @if( Auth::user()->id == $sub_task->users->first()['id'] || Auth::user()->id == $todo_owner )
                                            <a class="btn btn-link collapsed checklist_list" id="{{ $sub_task->id }}" data-chkid="chk_{{ $sub_task->id }}" aria-expanded="false" aria-controls="chk_{{ $loop->iteration }}"><i class="fas fa-list"></i></a>
                                            @endif
                                            @if( Auth::user()->id == $sub_task->users->first()['id'] )
                                                <a class="btn btn-link collapsed add_item"  data-subtaskid="{{ $sub_task->id }}" ><i class="fas fa-plus"></i></a>
                                            @endif
                                            </h5>
                                        </div>
                                        <div class="col-md-4 col-sm-12 " >
                                            <div class="progress">
                                            <div class="progress-bar" data-total="{{ $total }}" data-checked="{{ $checked }}" id="chk_prog_{{ $sub_task->id }}" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">{{ $percent }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End .card-header -->
                                <div id="chk_{{ $sub_task->id }}" class="collapse" aria-labelledby="headingThree-sub-1" data-parent="#accordion-sub-sub-1" aria-expanded="false">
                                    <div class="card-body " id="checklist_parent_{{ $sub_task->id }}"></div>
                                </div>
                            </div><!-- End .Card -->

                            <!-- Comments -->

                            <div class="card">
                                <div class="card-header" id="headingThree-comment">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link collapsed show_comment" data-subtaskid="{{ $sub_task->id }}"  data-collapseid="#collapse_comment_{{ $sub_task->id }}" ><i class="fas fa-comment"></i></a>
                                        <a class="btn btn-link collapsed add_comment" data-subtaskid="{{ $sub_task->id }}"><i class="fas fa-plus"></i></a>

                                    </h5>
                                </div>
                                <div id="collapse_comment_{{ $sub_task->id }}"  class="collapse" aria-labelledby="headingThree" data-parent="#accordion-sub-sub-1">
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="comment-section wrapper-free-styles wrapper-margin-top " id="comment_parent_{{ $sub_task->id }}"></div>


                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div>

            </div>
        </div>
    </div>
    @endforeach







    <!-- --------------------------------Modals-------------------------------- -->





@include('sub_tasks.partials/add_check_list_modal')

@include('sub_tasks.partials/add_comment_modal')

@include('sub_tasks.partials/add_sub_task_modal')

@include('sub_tasks.partials.participant_modal')

@include('sub_tasks.partials/edit_sub_task_modal')

@include('sub_tasks.partials/edit_comment_modal')







            <!-- End Modal -->



        </div>

        <!-- </div> -->


    </div>




</div>

<script>
    $(document).ready(function () {
        function progress_x(sub_id,just_check = false,progress_bar_id,sub_task_done_element_id = '' ,parent_selector = '',checklist_selector = '' ){
            let prog = document.getElementById(progress_bar_id);
            let sub_task_done_el = document.querySelector(`#${sub_task_done_element_id} i`).classList;
            let total_item_count;
            let checked = 0;
            let unchecked;
            let percent;
            let subId = sub_id;
            let s_status_o = document.querySelector(`#${sub_task_done_element_id}`).dataset.done;
            let s_status_n = document.querySelector(`#${sub_task_done_element_id}`).dataset.done;
            function ajax_s(total, checked, o_state, n_state){
                console.log('function_called');
                total = parseInt(total);
                checked = parseInt(checked);
                o_state = Boolean(parseInt(o_state));
                n_state = Boolean(parseInt(n_state));

                    if((total !== checked && o_state !== n_state) || total === checked && o_state !== n_state ){
                        console.log('function_if_called');
                        let route = ` /usub/${subId}`;
                        dataN = { 'status' : n_state};
                        $.ajax({
                            type:'PUT',
                            url: route,
                            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                            data:dataN,
                            success:function(Response){
                                console.log(Response.state);
                                document.querySelector(`#${sub_task_done_element_id}`).dataset.done = `${Response.state}`;
                            }//--End success--
                        });//--End ajax--
                    }//--End if
            }//--End ajax_x function--
            console.log('s:' + s_status_o);
            if(just_check === true){
                console.log('true')
                total_item_count = parseInt(prog.dataset.total);
                total_item_count = total_item_count + 1;
                prog.dataset.total = `${total_item_count}`;
                checked = parseInt(prog.dataset.checked);
                if(total_item_count == 0 || checked == 0){
                    percent = 0
                }else{
                    percent = ((parseInt(checked)/parseInt(total_item_count)) * 100);
                }
                // console.log('percent: ' + percent );
                percent = Math.ceil(percent);
                // console.log('percent: ' + percent );
                if(percent == NaN){
                    percent = 0;
                }
                prog.setAttribute('aria-valuenow', percent);
                prog.style.width = `${percent}%`;
                prog.textContent = `${percent}%`;

                if(total_item_count == checked && total_item_count != 0  ){
                    if(sub_task_done_el.contains('fa-clock')){
                        sub_task_done_el.remove('fa-clock');
                        sub_task_done_el.add('fa-check');
                        s_status_n = '1';
                        ajax_s(total_item_count, checked, s_status_o, s_status_n);
                    }
                }else if(total_item_count > checked ){
                    if(sub_task_done_el.contains('fa-check')){
                        sub_task_done_el.remove('fa-check')
                        sub_task_done_el.add('fa-clock')
                        s_status_n = '0';
                        ajax_s(total_item_count, checked, s_status_o, s_status_n);
                    }
                }

            }else{
                total_item_count = document.querySelector(parent_selector).childElementCount;
                let checklist_items = document.querySelectorAll(checklist_selector);
                if(checklist_items.length > 0 ){
                    checklist_items = Array.from(checklist_items);
                    checked = 0;
                    unchecked = 0;
                    function count(item){
                        if(item.checked === true){
                            checked = checked + 1;
                        }else if(item.checked === false){
                            unchecked = unchecked + 1;
                        }
                    }// -- End count function--
                    checklist_items.forEach(count);


                    if(total_item_count == 0 || checked == 0){
                        percent = 0
                    }else{
                        percent = ((parseInt(checked)/parseInt(total_item_count)) * 100);
                    }
                    percent = Math.ceil(percent);
                    if(percent == NaN){
                        percent = 0;
                    }

                    prog.dataset.total = `${total_item_count}`;
                    prog.dataset.checked = `${checked}`;
                    prog.setAttribute('aria-valuenow', percent);
                    prog.style.width = `${percent}%`;
                    prog.textContent = `${percent}%`;

                    if(total_item_count == checked && total_item_count != 0  ){
                        if(sub_task_done_el.contains('fa-clock')){
                            sub_task_done_el.remove('fa-clock');
                            sub_task_done_el.add('fa-check');
                            s_status_n = '1';
                            ajax_s(total_item_count, checked, s_status_o, s_status_n);

                        }
                    }else if(total_item_count > checked ){
                        if(sub_task_done_el.contains('fa-check')){
                            sub_task_done_el.remove('fa-check');
                            sub_task_done_el.add('fa-clock');
                            s_status_n = '0';
                            ajax_s(total_item_count, checked, s_status_o, s_status_n);
                        }
                    }
                }//--End if -> if there is any input--

            }

            console.log('per: ' + percent );
            console.log('total: ' + total_item_count);
            console.log('checked: ' + checked);
            console.log('s_o:' + s_status_o);
            console.log('s_n:' + s_status_n);
            console.log('type o_state: ' + parseInt(s_status_o) );
            console.log('type n_state: ' + parseInt(s_status_n) );
            if(Boolean(parseInt(s_status_o)) === Boolean(parseInt(s_status_n))){
                console.log('==' + true);
            }else if(Boolean(parseInt(s_status_o)) !== Boolean(parseInt(s_status_n))){
                console.log('==' + false);

            }
            // console.log('==' + Boolean(parseInt(s_status_o)) == Boolean(parseInt(s_status_n)));
            // console.log('===' + parseInt(s_status_o) === parseInt(s_status_n));

            // console.log('unchecked: ' + unchecked);
        } //--End progress_x function--


        $("#add_subtask_form").parsley();
        $('#edit_subTask_form').parsley();
        $('#add_check_list_item_form').parsley();
        $('#addFriendForm').parsley();
        $('#add_comment_form').parsley();

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
        var start ='{{ $task_start_geo }}';
        var end = '{{ $task_end_geo }}';
        // console.log("todo=> " + x);
        setRangeDate('#sub_task_start','#sub_task_end','#sub_task_start_text','#sub_task_end_text',start,end);



        // Edit sub task AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]'),
            }
        });


//---------------------------------------- Friend------------------------------------
var reload = false;
    @if (Auth::user()->id === intval($todo_owner))
        //-------------- Add Friends Ajax---------
        $('#addFriendForm').submit(function (e) {
            e.preventDefault();
            let frm = this;
            let route = $('#addFriendForm').data('route');
            let formData = $(this);
            $.ajax({
                type: 'POST',
                url: route,
                data: formData.serialize(),
                success: function (Response) {

                    console.log(Response);
                    if (Response.FRIEND) {
                        let form = document.createElement('div');
                        let newFriend = `
                    <form data-delroute="/todo/{{ $todo_id }}/task/{{ $task_id }}/delSubTaskUser" class="Remove_Friend_Form" >
                        @method('DELETE')
                        @csrf
                        <div class="form-group modal-input-add-checklist-item">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">${Response.FRIEND[0].name}</span>
                                </div>
                                <input type="email" class="form-control" disabled name="email" value="${Response.FRIEND[0].email}">

                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text"><i class="fa fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>
                        </form>
                    `;
                        form.innerHTML = newFriend;
                        document.getElementById('friendList').appendChild(form);
                        // console.log(newFriend);
                        frm.reset();

                    }
                    // $('#addFriendForm').reset();
                    ialert(Response);
                    reload = true;

                }
            });
        });//-- End Add Friends Ajax--



        //-------------- Remove Friends Ajax---------
        $('#friendList').on('submit', '.Remove_Friend_Form', function (e) {
            e.preventDefault();
            $(this).find('input[type=email]').prop('disabled', false);
            // console.log($(this).find('input[type=email]').val());
            let input = $(this);
            // console.log(input);
            let delRoute = $(this).data('delroute');
            // console.log(delRoute)
            let delFormData = $(this);
            // console.log(delFormData);

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
                    // console.log(Result);
                    reload = true;

                }
            });
        });//-- End remove Friends Ajax--
    @endif

//------------------------------------End friend-----------------------------------

//---------------------------------------------Subtask----------------------------------------------------
        //------------------ Edit subtask ---------------------------
        $(document).on('click', '.edit_btn', function (e) {
            let todo_id = parseInt('{{ $todo_id}}');
            let task_id = parseInt('{{ $task_id }}');
            let sub_id = $(this).attr('id');
            sub_id = parseInt(sub_id);
            e.preventDefault();

            $.ajax({
                url:`/todo/${todo_id}/task/${task_id}/subs/${sub_id}/edit`,
                dataType: "json",
                data: {
                    id: sub_id,
                },
                type: "GET",
                success: function (html) {
                    console.log(html);
                    ialert(Response);
                    let sub_task_id = html.data.sub_task.id;
                    document.querySelector('#edit_subtask_form #sub_task_id').value = sub_task_id;
                    $('#edit_subtask_form #name').val(html.data.sub_task.name);
                    // let start = html.data.todo_start;
                    // let end = html.data.todo_end;
                    $('#edit_subtask_form  #edit_sub_task_start_text').val(html.data.sub_task.start_at);
                    $('#edit_subtask_form  #edit_sub_task_end_text').val(html.data.sub_task.end_at);

                    @if ( Auth::user()->id  == intval($todo_owner) )
                        let options = document.getElementById('sub_task_edit_user').options;
                        options = Array.from(options);

                        options.map(function(opt){
                            if(html.data.sub_task_user.id ==  opt.value){
                                opt.selected = true;
                            }
                        });
                    @endif


                    setRangeDate('#edit_sub_task_start','#edit_sub_task_end','#edit_sub_task_start_text','#edit_sub_task_end_text',start,end);
                    $('#edit_sub_task_Modal').modal('show');
                }//-- End success
            })// End ajax
            console.log(task_id);

        });//--End Edit subtask --
        //-- Remove Subtask----
        $(document).on('click','.removeSubBtn', function(e){
            e.preventDefault();
            let sub_id = this.dataset.subid;
            let todo_id = this.dataset.todoid;
            let route = `/sub/${sub_id}`;
            console.log('sub_id: '+ sub_id);
            console.log('todo_id: '+ todo_id);
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
                                    let el = document.getElementById('sub_'+sub_id);
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
        })//-- End remove subtask--
//---------------------------------------------End Subtask----------------------------------------------------

//-------------------------------------- Check list------------------------


        //--------------add checklist-----------------
        $(document).on('click','.add_item',function(e){
            let sub_task_id = $(this).data('subtaskid');
            document.getElementById('sub_id').value = sub_task_id;

            $('#add_sub_check_list').modal('show');
        } );

        $('#add_check_list_item_form').submit(function(e){
            e.preventDefault();
            let sub_id = document.getElementById('sub_id').value;
            let frm = this;
            let route = `/subtask/${sub_id}/chklist`;
            let formData = $(this);

            $.ajax({
                type:'POST',
                url: route,
                data: formData.serialize(),
                success: function(Response){
                    let parent_element = document.getElementById('checklist_parent_'+sub_id);
                    if($('#chk_'+sub_id).hasClass('show')){
                    // $('#chk_'+sub_id).collapse("show");
                    let chdiv = document.createElement('div');
                    chdiv.className = 'chk_div';
                    chdiv.id = `chp_${Response.item.id}`;
                    let chklist_item = `
                    <form action="/subtask/${Response.item.sub_task_id}/chklist/${Response.item.id}">
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><a href="/subtask/${Response.item.sub_task_id}/chklist/${Response.item.id}" data-sid="${sub_id}" id="chr_${Response.item.id}" data-id="${Response.item.id}" class="removeTdoBtn" ><i class="fas fa-trash-alt"></i></a></span>
                                <div class="input-group-text">
                                    <input type="checkbox" class="chk_item" aria-label="Checkbox" id="ch_${Response.item.id}" data-id="${Response.item.id}" data-sid="${sub_id}" aria-label="Checkbox for following text input">
                                </div>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox " id="chklist_item_text_${Response.item.id}" value="${Response.item.text}" readonly>
                        </div>
                    </form>
                    `;
                    chdiv.innerHTML = chklist_item;
                    parent_element.appendChild(chdiv);
                    let sub_task_done_el_id = 'done_'+ sub_id;
                    let parent_id = '#checklist_parent_'+sub_id;
                    progress_x(sub_id,false,`chk_prog_${sub_id}`,sub_task_done_el_id,parent_id, `${parent_id} input[type="checkbox"]`);
                    };
                    if(!$('#chk_'+sub_id).hasClass('show')){
                        let sub_task_done_el_id = 'done_'+ sub_id;
                        let parent_id = '#checklist_parent_'+sub_id;
                        progress_x(sub_id,true,`chk_prog_${sub_id}`,sub_task_done_el_id,parent_id, `${parent_id} input[type="checkbox"]`);
                    }

                    // console.log(Response.item.sub_task_id);

                    ialert(Response);
                    frm.reset();

                },//--End success--
            });//--End Ajax--


            // $(this).reset();
        });//--End event- add check list --



//--------------show_checkList
        $(document).on('click', '.checklist_list', function(e){
            e.preventDefault();
            let sub_id = this.id;
            let uid = document.getElementById(`sub_${sub_id}`).dataset.uid;

            // console.log('uid-> ' + uid);
            let  collapse_id =  $(this).data('chkid');
            if($('#'+collapse_id).hasClass('show')){
                $('#'+ collapse_id ).collapse("hide");
            }else{

                let route = `/subtask/${sub_id}/chklist`;
                let uli = document.getElementById('uli').dataset.uli;
                // console.log('uli -> '+ uli);
                // let parent_element = document.getElementById('checklist_parent_'+sub_id);
                // console.log('sub_id: '+ sub_id);
                // console.log('route: '+ route);
                // console.log(parent_element);


                $.ajax({
                    type: 'GET',
                    data : {'id': sub_id},
                    url : route,
                    success: function(Responce){
                        console.log(Responce);
                        let parent_id = '#checklist_parent_' + sub_id;
                        let child_count = $(`#checklist_parent_${sub_id} .chk_div`).length;
                        let c_count = Object.values(Responce.checklists).length;
                        // console.log('c_count: ' + c_count);
                        // console.log('child_count: ' + child_count);
                        let checklists = Object.values(Responce.checklists);
                        let parent_element = document.getElementById('checklist_parent_'+sub_id);
                            if(!parent_element.hasChildNodes() || child_count < c_count){
                                if(child_count < c_count ){
                                    $(parent_id).empty();
                                    // console.log('not empty');
                                }
                                checklists.forEach(indexchecklists);
                                function indexchecklists(item){
                                    // console.log('-------------------');
                                    // console.log(item);
                                let chdiv = document.createElement('div');
                                    chdiv.className = 'chk_div';
                                    chdiv.id = `chp_${item.id}`;
                                    let chcklist_min;
                                    let chklist_last;
                                let chklist_item_first = `
                                <form action="/subtask/${sub_id}/chklist/${item.id}">
                                    <div class="input-group mb-3 ">`;

                                       if(uli === uid)
                                        chcklist_min = `<div class="input-group-prepend">
                                            <span class="input-group-text"><a href="/subtask/${sub_id}/chklist/${item.id}" id="chr_${item.id}" data-id="${item.id}" data-sid="${sub_id}" class="removeTdoBtn" ><i class="fas fa-trash-alt"></i></a></span>
                                            <div class="input-group-text">
                                                <input class="chk_item" type="checkbox" ${ item.is_done == 1 ? 'checked' : ''}  id="ch_${item.id}" data-id="${item.id}" data-sid="${sub_id}" aria-label="Checkbox for following text input">
                                            </div>
                                        </div>`;
                                        else{
                                            chcklist_min = '';
                                        }


                                        chklist_last = `<input type="text" class="form-control ${ item.is_done == 1 ? 'line_t' : ''}" id="chklist_item_text_${item.id}" aria-label="Text input with checkbox " value="${item.text}" readonly>
                                    </div>
                                </form>
                                `;
                                chklist_item = chklist_item_first + chcklist_min +  chklist_last;
                                chdiv.innerHTML = chklist_item;
                                parent_element.appendChild(chdiv);
                                console.log(item.is_done);
                        };

                            };//-- End if for checking parent element

                        // console.log(Responce.checklists);
                        let sub_task_done_el_id = 'done_'+ sub_id;
                        progress_x(sub_id,false,`chk_prog_${sub_id}`,sub_task_done_el_id,parent_id, `${parent_id} input[type="checkbox"]`);
                        $('#'+ collapse_id ).collapse("show");
                    }//--End success--
                });//--End ajax--
                $('#'+ collapse_id ).collapse("show");

            }

            // console.log(collapse_id);


            // $('#'+ collapse_id ).collapse("toggle");


        });

        //-------------- Remove Checklist------------------------
        $(document).on('click','.removeTdoBtn', function(e){
            e.preventDefault();
            let checklist_id = this.dataset.id;
            let sub_id = this.dataset.sid;
            let route = `/checklist/${checklist_id}`;
            $.confirm({
                title: 'مطمينید',
                content: 'پاک شود؟  ',
                buttons: {
                  confirm: {
                      text: 'بله!',
                      action: function () {
                        $.ajax({
                            type: 'DELETE',
                            url: route,
                            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                            success: function(Response){
                                if(Response.ok === true){
                                    let el = document.getElementById("chp_"+checklist_id);
                                    // let el_parent =  el.parentElement.parentElement.parentElement.parentElement.parentElement;
                                    el.remove();
                                }
                                console.log(Response);
                                ialert(Response);
                                let sub_task_done_el_id = 'done_'+ sub_id;
                                let parent_id = '#checklist_parent_'+sub_id;
                                progress_x(sub_id,false,`chk_prog_${sub_id}`,sub_task_done_el_id,parent_id, `${parent_id} input[type="checkbox"]`);
                            }//-- End success--
                        });// End Ajax--
                      }//-- End action--
                  },//-- End confirm--
                  cancel: {
                      text: 'انصراف',
                  },//-- End cancell
                }//-- End buttons
            });//--End confirm---




            console.log();



        });// end remove checklist


        //------------------ toggle done state for checklist's items------------------------
        $(document).on('change','.chk_item',function(e){
            let chk_id = this.dataset.id;
            let sub_id = this.dataset.sid;
            let text_input_id = 'chklist_item_text_' + chk_id;
            let text_input_el = document.querySelector('#' + text_input_id);
            // console.log(text_input_el);
            let is_done;
            let route = `/checklist/${chk_id}`;
            // console.log(this.id);
            if(this.checked == true){
                is_done = true;
                text_input_el.classList.add('line_t');
                // console.log(text_input_el);
            }
            if(this.checked == false){
                text_input_el.classList.remove('line_t');
                is_done = false;
                // console.log(is_done);
            }

            $.ajax({
                type: 'PUT',
                url: route,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success : function(Responce){
                    // console.log(Responce);
                    ialert(Responce);
                    let sub_task_done_el_id = 'done_'+ sub_id;
                    let parent_id = '#checklist_parent_'+sub_id;
                    progress_x(sub_id,false,`chk_prog_${sub_id}`,sub_task_done_el_id,parent_id, `${parent_id} input[type="checkbox"]`);
                }
            });
        });// end toggle done state
        //--------------------------------------  End Check list------------------------

        //------------------------------------------------------ Comment --------------------------------------------
        // -------------- Show Comment----------------

        $(document).on('click','.show_comment', function(e){


            e.preventDefault();
            let collapse_id = this.dataset.collapseid;
            let sub_task_id = this.dataset.subtaskid;
            if($(collapse_id).hasClass('show')){
                $(collapse_id).collapse("hide");
            }else{
                let comment_parent = document.getElementById('comment_parent_'+sub_task_id);
                let parent_id = '#comment_parent_' + sub_task_id;
                let child_count = $(`#comment_parent_${sub_task_id} .comment_div`).length;
                console.log('count: ' + child_count);


                    let route = '/comment';
                    $.ajax({
                        type:'GET',
                        url: route,
                        data:{
                            'id':sub_task_id
                        },
                        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        success: function(Response){
                            let c_count = Object.values(Response.comments).length;
                            if(!comment_parent.hasChildNodes() || child_count < c_count ){
                                if(child_count < c_count ){
                                    $(parent_id).empty();
                                    console.log('not empty');
                                }
                            console.log('res_count: ' +  Object.values(Response.comments).length);
                            // console.log(Response.comment.length);
                            let comments = Array.from(Response.comments);
                            comments.forEach(indexComments);
                            function indexComments(comment){
                                let chdiv = document.createElement('div');
                                chdiv.className = 'comment_div';
                                let tow = document.getElementById('tow').dataset.tow;
                                let uli = document.getElementById('uli').dataset.uli;

                                chdiv.id = 'c_' + comment.id;
                                let full_date = comment.updated_at;
                                let jal_date = new Date(full_date).toLocaleDateString('fa-IR');
                                let full_date_jalali = new Date(full_date).toLocaleString('fa-IR');
                                let comment_item_min_1;
                                let comment_item_min_2;
                                let comment_item_first = `
                                <div class="media media-box">
                                    <div class="media-body user-comment comment-question" id="comment-question_${comment.id}">
                                        <div class="user-comment-title">
                                            <ul class="list-inline">
                                                <li><i class="fas fa-user"></i>${comment.user.name}</li>
                                                <li id="com_date_${comment.id}"><i class="fas fa-clock"></i>${jal_date}</li>`;
                                                if(uli == tow || comment.user_id == uli){
                                                    comment_item_min_1 = `<li class="comment-edit"><a href="#" class="del_comment" id="${comment.id}" data-commentid="${comment.id}"><i class="fas fa-trash text-danger"></i></a></li>`;
                                                }else{
                                                    comment_item_min_1 = '';
                                                }
                                                if(comment.user_id == uli){
                                                    comment_item_min_2 = `<li class="comment-answer"><a href="#" class="edit_comment" data-commentid="${comment.id}"><i class="fas fa-pen text-warning"></i></a></li>`;
                                                }else{
                                                    comment_item_min_2 = '';
                                                }

                                           let comment_item_last = `
                                            </ul>

                                        </div>
                                        <p>${comment.text}</p>
                                    </div>
                                </div>
                                `;
                                let comment_item = comment_item_first + comment_item_min_1 + comment_item_min_2 + comment_item_last;
                                chdiv.innerHTML = comment_item;
                                comment_parent.appendChild(chdiv);
                            }//--End indexComment function

                            }//- End check comment parent for childrens
                        },//--End success
                    });//-end ajax-




                $(collapse_id ).collapse("show");

            }//-end else-

        });//-- End show comment


        //--------------- Add Commnet-----------------
        // -- Add sub_id to #sub_id input
        $(document).on('click', '.add_comment', function(e){
            e.preventDefault();
            // document.getElementById('comment_modal_head').textContent = 'نظر جدید';
            // document.getElementById('comment_modal_btn').value = 'ثبت نظر';
            // document.getElementById('comment_modal_txt').textContent = '';
            // document.querySelector('#add_new_comment_modal form').id = 'add_comment_form';
            // document.getElementById('edit_comment_id').value = '';
            // document.getElementById('edit_comment_id').disabled = true;


            let sub_task_id = this.dataset.subtaskid;
            document.getElementById('sub_id_2').value = sub_task_id;
            $('#add_new_comment_modal').modal('show');

        }); // -- End Add sub_id to #sub_id input

        //-- Add Comment Ajax
        $('#add_comment_form').submit(function(e){
            e.preventDefault();
            let sub_id = document.getElementById('sub_id_2').value;
            let frm = this;
            let collapse_id = '#collapse_comment_'+ sub_id;
            console.log(sub_id);
            let route = '/comment';
            let formData = $(this);
            // console.log(formData.serialize());
            let comment_parent = document.getElementById('comment_parent_'+sub_id);

            $.ajax({
                type:'POST',
                url: route,
                data:formData.serialize(),
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(Responce){
                    if($(collapse_id).hasClass('show')){
                        let chdiv = document.createElement('div');
                        chdiv.id = 'c_' + Responce.item.id;
                        console.log(Responce);
                        let comment_item = `
                            <div class="media media-box">
                                <div class="media-body user-comment comment-question" id="comment-question_${Responce.item.id}">
                                    <div class="user-comment-title">
                                        <ul class="list-inline">
                                            <li><i class="fas fa-user"></i>${Responce.user_name}</li>
                                            <li id="com_date_${Responce.item.id}" ><i class="fas fa-clock"></i>${Responce.added_date_date}</li>
                                            <li class="comment-edit"><a href="#" class="del_comment" id="del_${Responce.item.id}" data-commentid="${Responce.item.id}"><i class="fas fa-trash text-danger"></i></a></li>
                                            <li class="comment-answer"><a href="#" class="edit_comment" id="edit_${Responce.item.id}" data-commentid="${Responce.item.id}"><i class="fas fa-pen text-warning"></i></a></li>
                                     </ul>
                                    </div>
                                    <p>${Responce.text}</p>
                                </div>
                            </div>
                            `;
                        chdiv.innerHTML = comment_item;
                        comment_parent.appendChild(chdiv);
                        document.getElementById('comment_modal_txt').textContent = '';
                    }// -- End if that check whether collapse have show class or not
                    frm.reset();
                },//--End success

            });//--End Ajax

        });// End Add Comment Ajax

        //-- End add Comment-------------

        //------------- Remove Comment-------------------
        $(document).on('click','.del_comment', function(e){
            e.preventDefault();
            let comment_id = this.dataset.commentid;
            let route = `/comment/${comment_id}`;

            $.confirm({
            title: 'مطمينید',
            content: 'پاک شود؟  ',
            buttons: {
              confirm: {
                  text: 'بله!',
                  action: function () {
                    $.ajax({
                        type: 'DELETE',
                        url: route,
                        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        success: function(Response){
                            if(!Response.ok === false){
                                let el = document.getElementById('c_' + comment_id);
                                el.remove();
                            }
                            console.log(Response);
                            ialert(Response);
                        }//-- End success--
                    });// End Ajax--
                  }//-- End action--
              },//-- End confirm--
              cancel: {
                  text: 'انصراف',
              },//-- End cancell
            }//-- End buttons
            });//--End confirm---


        })//--End Remove Comment---

        //----------- Edit Comment--------
        $(document).on('click','.edit_comment', function(e){
            e.preventDefault();
            let comment_id = this.dataset.commentid;
            let parent_id = '#c_' + comment_id;
            let comment_text = document.querySelector(parent_id+' p').textContent;
            document.getElementById('edit_comment_modal_txt').textContent = comment_text;
            // document.getElementById('comment_modal_head').textContent = 'ویرایش نظر';
            // document.getElementById('comment_modal_btn').value = 'ویرایش';
            // document.querySelector('#add_new_comment_modal form').id = 'edit_comment_form';
            // document.getElementById('edit_comment_id').disabled = false;
            document.getElementById('edit_comment_id').value = comment_id;
            $('#edit_new_comment_modal').modal('show');
            console.log(comment_text);

        })//--End edit comment---------
        $('#edit_comment_form').submit(function(e){
            e.preventDefault();
            // console.log('mkkk');
            let comment_id = document.getElementById('edit_comment_id').value;
            let route = `/comment/${comment_id}`;
            let frmData = $(this);
            // console.log(.serialize());
            $.ajax({
                type: 'PUT',
                url: route,
                data: frmData.serialize(),
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(Response){
                    ialert(Response);
                    if(Response.ok === true){
                        let parent_id = '#c_' + comment_id;
                        let newDate = Response.comment.updated_at;
                        document.querySelector(parent_id+' p').textContent = Response.comment.text;
                        document.getElementById('com_date_' + comment_id ).textContent = new Date(Response.comment.updated_at).toLocaleDateString('fa-IR');
                        // parent.remove();
                    }
                    console.log(Response);
                }
            });//--End ajax--
        })//-- End edit comment ajax


        $('#participant_modal').on('hide.bs.modal', function (e) {
        if(reload === true){
            location.reload();
        }
        })//-- End reload page if number of users change----


        // --------------- Progress and is_done ---------------------


    });//-------------------------------- End document.ready() function--------------------------------




</script>


@endsection
@section('plusbtn')

    @include('partials.plusbtn')
@endsection
