 <!-- Add Sub check list -->
 <div class="modal fade" id="add_sub_check_list" tabindex="-1" role="dialog" aria-labelledby="checklistModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checklistModalLabel">ایجاد چک لیست</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
            </div>
            <div class="modal-body">

                <form id="add_check_list_item_form" method="POST">
                    @csrf
                    <input type="hidden" name="sub_id" value="" id="sub_id">
                    <div class="form-group modal-input-add-checklist-item">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-plus-circle"></i></span>
                            </div>
                            <input type="text" class="form-control" name="text"
                            data-parsley-trigger="change"
                            required=""
                            data-parsley-errors-container="#chklist_error_box">
                        </div>
                    </div>
                    <div class="mb-3">
                        <span id="chklist_error_box" ></span>
                    </div>




                    <input type="submit" class="btn btn-block btn-success" value="اضافه کن">
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
