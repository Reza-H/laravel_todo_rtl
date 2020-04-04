 <!-- Add Comment -->
 <div class="modal fade" id="add_new_comment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comment_modal_head">نظر جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
            </div>
            <div class="modal-body">
                <form id="add_comment_form" method="POST">
                    @csrf
                    <input type="hidden" id="sub_id_2" name="sub_id">
                    {{-- <input type="hidden" name="comment_id" id="edit_comment_id"> --}}
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">نظر شما:</label>
                        <textarea class="form-control" id="comment_modal_txt" name="comment_text"
                        data-parsley-length="[2,250]"
                        data-parsley-trigger="change"
                        required=""
                        data-parsley-errors-container="#comment_error_box"></textarea>
                        <div class="mb-3">
                            <span id="comment_error_box" ></span>
                        </div>
                        <input class="btn btn-primary mt-3" id="comment_modal_btn" type="submit" value="ثبت نظر">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
