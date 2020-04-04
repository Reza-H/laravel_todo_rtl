@extends('layouts.app')
@section('content')

{{-- {{dd(Auth::user()->id )}} --}}
    <div id="main-container" class="container mt-3 " style="position: relative;">
        <div  class="main-row todo_list row " style="overflow-y: auto !important;">

            <!-- <div class="row"> -->
            <div class="col-md-12">

                <div class="table-responsive bg-white w-100 p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col" style="width: 3%;">#</th>
                            <th class="text-center" scope="col" style="width: 50%;">نام</th>
                            <th class="text-center" scope="col" style="width: 16%;">شروع</th>
                            <th class="text-center" scope="col" style="width: 16%;">پایان</th>
                            <th class="text-center" scope="col" style="width: 16%;">نوع</th>
                            <th class="text-center" scope="col" style="width: 5%;">وضعیت</th>

                            <th class="text-center" scope="col" style="width: 5%;">ویرایش</th>
                            <th class="text-center" scope="col" style="width: 5%;">حذف</th>



                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($todos as $todo)

                            <tr id="todo_{{ $todo->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><a href="{{ route('tasks.index',['id' => $todo->id]) }}">{{ $todo->name }}</a></td>
                                <td class="text-center">{{ $todo->start_at  }}</td>
                                <td class="text-center">{{ $todo->end_at  }}</td>
                                <td class="text-center">{{$todo->type == 'individual' ? 'شخصی': 'گروهی'}}</td>
                                <td class="text-center"><a href="#"><i class="fas fa-{{ $todo->is_done == true ? 'check' : 'clock' }} text-success"></i></a></td>
                                @if (Auth::user()->id === intval($todo->owner_id) )
                                <td class="text-center"><a href="#"  class="edit_btn" id="{{ $todo->id }}" ><i class="fas fa-pen text-warning"></i></a></td>
                                <td class="text-center"><a href="#" class="removeTodoBtn" data-todoid="{{ $todo->id }}" ><i class="fas fa-trash text-danger"></i></a></td>
                                @endif
                                @if (Auth::user()->id !== intval($todo->owner_id))
                                <td class="text-center"><i class="fa fa-lock " aria-hidden="true"></i>
                                </td>
                                <td class="text-center"><i class="fa fa-lock" aria-hidden="true"></i>
                                </td>
                                @endif

                            </tr>
                            @endforeach



                        </tbody>
                    </table>

                </div>


                <!-- Modal -->

                <!--        add todoModal     -->
              @include('todos.partials.add_todo_modal')

                <!--       End add todoModal     -->

                <!--        Modal Edit todoModal    -->
                @include('todos.partials.edit_todo_modal')
                <!--    End Modal Edit Task    -->

                <!-- End Modal -->

            </div>

            <!-- </div> -->


        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#add_todo_form').parsley();
            $('#edit_todo_form').parsley();

            // Add hidden input after solo radio with user id value -> send to back
            $('input:radio[name="choice"]').change(function (e) {
                if($('#choice_2').is(':checked')){
                    let user_id_hidden_input =  '<input type="hidden" id="solo_user_id" name="todo[type][individual][]" value="id-x">';
                    $(this).after(user_id_hidden_input);
                } else if($('#radio_1').is(':checked')) { // check if group radio checked
                    let hiddenElement = $('#solo_user_id');
                    if ( hiddenElement.length > 0) {
                        // if hidden input exist -> remove it
                        hiddenElement.remove();
                    }
                }
            });



            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]'),
            }
        });//--End ajaxSetup--
        //--------Todo edit-------------------
        $(document).on('click', '.edit_btn', function (e) {
            e.preventDefault();
            // console.log(this);
            let id = $(this).attr('id');
            let todo_id = parseInt('{{ isset($todo) ? $todo->id : 0  }}');
            console.log(id);

            // var task_id;
            $.ajax({
                url: "/todos/" + todo_id + "/edit",
                dataType: "json",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},

                data: {
                    id: id,
                },
                type: "GET",
                success: function (html) {
                    console.log(html);
                    let todo_id = html.data.todo.id;
                    document.querySelector('#edit_todo_form #todo_id').value = todo_id;
                    $('#edit_todo_form #edit_name').val(html.data.todo.name);

                    $('#edit_start').val(html.data.todo.start_at_j);
                    $('#edit_end').val(html.data.todo.end_at_j);
                    console.log(html.data.todo.end_at_j);
                    // check boxes
                    let users = html.data.todo_users;
                    if(html.data.todo.type === 'individual'){
                        document.getElementById('choice_2_edit').checked = true;
                        let inputs = document.querySelectorAll('.chkB');
                        inputs = Array.from(inputs);
                        inputs.map(function(input){
                            input.checked = false;
                        });
                        let active = document.querySelectorAll('.active');
                        active = Array.from(active);
                        active.map(function(act){ act.classList.remove("active") })

                    } else if(html.data.todo.type === 'collaborative'){
                        document.getElementById('choice_1_edit').checked = true;
                        let checkboxes = document.querySelectorAll('#edit_todo_form .chkB');
                        checkboxes = Array.from(checkboxes);
                        let users = html.data.todo_users; // Array of users

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


                    // setRangeDate('#edit_modal_start', '#edit_modal_end','#edit_start','#edit_end', start_y, start_m, start_d,  end_y, end_m, end_d, end_h, end_mi, end_s);
                    $('#editTodoModal').modal('show');
                }
            })
            // console.log(todo_id);

        });//--End todo edit--


         //-- Remove todo----
         $(document).on('click','.removeTodoBtn', function(e){
            e.preventDefault();
            let todo_id = this.dataset.todoid;
            let route = `/todos/${todo_id}`;
            console.log('task_id: '+ todo_id);
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
                                        let el = document.getElementById('todo_'+todo_id);
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


        });//--End document.redy()--
    </script>

@endsection
@section('plusbtn')
@include('partials.plusbtn')
@endsection
