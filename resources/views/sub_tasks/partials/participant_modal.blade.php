<!---------------------------------- MODAL --------------------------------->

<div class="modal fade" id="participant_modal" role="dialog" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="friendsModalLabel">مشارکت کنندگان</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (session()->has('notFond'))
                    <div class="alert alert-danger">{{ session()->get('notFond') }}</div>
                @endif
                @if (Auth::user()->id === intval($todo_owner))
                <form data-route="/todo/{{ $todo_id }}/task/{{ $task_id }}/addSubTaskUser" method="POST" id="addFriendForm">
                    @csrf
                    <div class="form-group modal-input-add-checklist-item">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="email" class="form-control " name="email" id="add_friend_input"
                            data-parsley-trigger="change"
                            required=""
                            data-parsley-errors-container="#sub_friend_error_box"><br>


                            <div class="input-group-append">
                                <button type="submit" class="input-group-text"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <span id="sub_friend_error_box" ></span>
                        </div>
                    </div>
                    <span id="editErrorBox"></span>
                </form>

                @endif

                <div id="friendList">
                    @foreach ($participants as $participant)


                        <form class="Remove_Friend_Form" data-delroute="/todo/{{ $todo_id }}/task/{{ $task_id }}/delSubTaskUser">
                            @csrf
                            @method('DELETE')

                            <div class="form-group modal-input-add-checklist-item">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $participant->name }}</span>
                                    </div>
                                    <input type="email" class="form-control" disabled name="email" id="email_field"
                                           value="{{ $participant->email }}">
                                        @if (Auth::user()->id === intval($todo_owner))
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text"><i class="fa fa-trash-alt"></i></button>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>



            </div>
        </div>
    </div>
</div>
<!---------------------------------- END MODAL --------------------------------->



