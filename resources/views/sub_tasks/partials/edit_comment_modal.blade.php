 <!-- Add Comment -->
 <div class="modal fade" id="edit_new_comment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_comment_modal_head">ویرایش نظر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
            </div>
            <div class="modal-body">
                <form id="edit_comment_form" method="POST">
                    @csrf
                    <input type="hidden" id="sub_id_2" name="sub_id">
                    <input type="hidden" name="comment_id" id="edit_comment_id">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">نظر شما:</label>
                        <textarea class="form-control" id="edit_comment_modal_txt" name="comment_text"></textarea>
                        <input class="btn btn-primary mt-3" id="edit_comment_modal_btn" type="submit" value="ویرایش">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
