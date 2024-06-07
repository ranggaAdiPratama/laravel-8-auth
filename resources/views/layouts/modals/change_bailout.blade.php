<!-- Change Delivery Modal -->
<div class="modal fade" id="changeBailoutModal" tabindex="-1" aria-labelledby="changeBailoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeBailoutModalLabel">Dana Talangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">payments</i>
                            </div>
                            <h4 class="card-title">Pilih Dana Talangan</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group col-md-12 text-center">
                                <select class="customers form-control dropdown bootstrap-select show-tick" id="id_bailout" data-style="select-with-transition" title="Dana Talangan" required="true" >
                                    <option value="" disabled selected>Pilih Jenis Talangan</option>
                                    <option value="1">Dengan Talangan</option>
                                    <option value="2">Tanpa Talangan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_changes">Save changes</button>
            </div>
        </div>
    </div>
</div>