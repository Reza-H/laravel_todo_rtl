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
                {{-- @if (session()->has('notFond'))
                    <div class="alert alert-danger">{{ session()->get('notFond') }}</div>
                @endif --}}
                @if (Auth::user()->id === intval($todo_owner) || in_array(Auth::user()->id, $co_admins))
                <form data-route="{{ route('add_participant', $todo_id ) }}" method="POST" id="addFriendForm">
                    @csrf
                    <div class="form-group modal-input-add-checklist-item">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="email" class="form-control " name="email" id="add_friend_input"
                                   data-parsley-required="true"
                            ><br>


                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>

                    </div>
                    <span id="editErrorBox"></span>
                </form>

                @endif

                <div id="friendList">
                    @foreach ($participants as $participant)
                        {{-- @dump(gettype($participant->pivot->is_co_admin)) --}}

                        <form class="Remove_Friend_Form" data-delroute=" {{ route('delete_participant', $todo_id) }} ">
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
                                            <button type="submit"  class="input-group-text" ><i class="fas fa-trash"></i></button>
                                            
                                        <a href="#" data-uid="{{ $participant->id }}" data-todoid="{{ $todo_id }}" data-isco="{{ $participant->pivot->is_co_admin === "1" ? '1' : '0' }}" class="input-group-text add_co_admin" title="افزودن به عنوان همیار مدیر" ><i id="pu_{{ $participant->id }}" class="fas fa-star" style="font-weight: {{ $participant->pivot->is_co_admin === "1" ? '900' : '200' }};"></i></a>
                                        </div>
                                        @endif

                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>

                {{-- <button id="close-add-friend-modal" type="button" class="btn btn-secondary" data-dismiss="modal">بستن
                </button> --}}

            </div>
        </div>
    </div>
</div>
<!---------------------------------- END MODAL --------------------------------->

