@extends('layouts.app')
@section('content')
   {{-- {{ dd($errors->all()) }} --}}
{{-- {{ dd($user_img) }} --}}

    <div class="container secondary-height ">
        <div class="row justify-content-center h-100">
            <div class="col-sm-7 my-auto">
                <div class="card main-shadow">
                    <div class="card-header position-relative">
                        <h4 class="card-title">پروفایل</h4>
                        <div class="friends  position-absolute fixed-top-left">
                            <a href="" class="btn btn-success" data-toggle="modal" data-target="#friendsModal">دوستان</a>
                        </div>
                    </div>

                        <div class="card-body">

                            <div class="row justify-content-center ">
                                <div class="col-sm-12 col-md-12 col-lg-10  text-center">
                                    <div class="row justify-content-center mb-1 mt-1">
                                        <img class="profile-image" src="{{ $user_img }}" alt="" style="height: 150px !important;width: 150px !important; border-radius: 50%">
                                    </div>


                                </div>
                            </div>
                            <div class="row justify-content-center">

                                <div class="col-sm-12 col-md-12 col-lg-10  text-center ">
                                    <ul class="mt-1">
                                        <li style="list-style: none">
                                            <form id="update_profile_name_form" data-uproute="{{ route('update_user_name') }}" action="{{ route('update_user_name') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="name"> نام</span>
                                                </div>
                                                <input type="text" class="form-control " id="user_name" aria-label="Default"
                                                       name="user_name" aria-describedby="name" value="{{ $user->name }}">

                                                <div class="input-group-prepend">
                                                    <button class="input-group-text" id="user_name_edit_trigger"
                                                           type="submit"
                                                           >&#9998;</button>
                                                </div>
                                            </div>
                                        </form>
                                        </li>

                                        <li style="list-style: none">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="email">ایمیل</span>
                                                </div>
                                                <input type="text" class="form-control" aria-label="Default"
                                                       aria-describedby="email" value="{{ $user->email }}" disabled>
                                            </div>
                                        </li>
                                        <li style="list-style: none">
                                            <div class="input-group mb-1">

                                                <a type="button" href="{{ route('change.password') }}" class="form-control btn btn-info" aria-label="Default"
                                                   aria-describedby="pass-change" value="تغییر گذرواژه">تغییر گذرواژه</a>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------- MODAL --------------------------------->
    <div class="modal fade" id="friendsModal" role="dialog" aria-labelledby="friendsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="friendsModalLabel">دوستان</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session()->has('notFond'))
                        <div class="alert alert-danger">{{ session()->get('notFond') }}</div>
                    @endif
                    <form data-route="{{ url('/user/profile') }}" method="POST" id="addFriendForm">
                        @csrf
                        <div class="form-group modal-input-add-checklist-item">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="email" class="form-control " name="email" id="add_friend_input" required


                                {{-- data-parsley-error-message="<span>لطفاپست الکترونیکی خود را وارد کنید!</span>" --}}
                                ><br>



                                <div class="input-group-prepend">
                                    <button type="submit"><i class="fa fa-plus-circle"></i></button>
                                </div>
                            </div>

                        </div>
                        <span id="editErrorBox"></span>
                    </form>
                        <div id="friendList">
                         @foreach( $friends as $friend)
                        <form  class="Remove_Friend_Form" data-delroute="{{ url('/user/profile') }}/{{$friend->id }}">
                             @csrf
                             @method('DELETE')
                             <div class="form-group modal-input-add-checklist-item">

                                 <div class="input-group mb-3">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text">{{$friend->name}}</span>
                                     </div>
                                     <input type="email" class="form-control" disabled name="friend[{{ $friend->id }}]" value="{{$friend->email}}">

                                     <div class="input-group-prepend">
                                         <button type="submit"><i class="fa fa-trash-alt"></i></button>
                                     </div>
                                 </div>
                             </div>
                         </form>
                        @endforeach
                    </div>

                    <button id="close-add-friend-modal" type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>

                </div>
            </div>
        </div>
    </div>
    <!---------------------------------- END MODAL --------------------------------->

<script >
    $(document).ready(function () {



    // --------------------- Add Friends Ajax



    $('#addFriendForm').submit(function (e) {
        e.preventDefault();
        let frm = this;
        let route = $('#addFriendForm').data('route');
        let formData = $(this);
        $.ajax({
            type:'POST',
            url: route,
            data: formData.serialize(),
            success: function (Response) {

                console.log(Response);
                if(Response.FRIEND){
                    let form = document.createElement('div');
                    let newFriend = `
                    <form data-delroute="{{ url('/user/profile') }}/${Response.FRIEND[0].id}" class="Remove_Friend_Form" >
                        @method('DELETE')
                        @csrf
                        <div class="form-group modal-input-add-checklist-item">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">${Response.FRIEND[0].name}</span>
                                </div>
                                <input type="email" class="form-control" disabled name="friend[${Response.FRIEND[0].id}]" value="${Response.FRIEND[0].email}">

                                <div class="input-group-prepend">
                                    <button type="submit"><i class="fa fa-trash-alt"></i></button>
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


            }
        });
    });


    });
    // --------------- End Add Friends Ajax
</script>

<script>
    $('#friendList').on('submit','.Remove_Friend_Form',function(e){
    e.preventDefault();
    let input = $(this);
    // console.log(input);
    let delRoute = $(this).data('delroute');
    // console.log(delRoute)
    let delFormData = $(this);

    $.ajax({
        type : 'DELETE',
        url: delRoute,
        data: delFormData.serialize(),
        success:function(Result){
            console.log(Result);
            input.remove();
            ialert(Result);

        }
    });
});

</script>
<script>
    $(document).ready(function(){
        $('#update_profile_name_form').submit(function(e){
            e.preventDefault();
            let upRoute = $(this).data('uproute');
            let input = $(this);
            let upFormData = $(this);
            console.log(upRoute);
            $.ajax({
                type: 'PATCH',
                url: upRoute,
                data: upFormData.serialize(),
                success:function(Response){
                    console.log(Response);
                    ialert(Response);

                }
            });
        });
    });
</script>

@endsection
@section('custom_js')
    {{-- <script>
        $(document).ready(function(){

            $('#addFriendForm').parsley();
        });

    </script> --}}
@endsection
