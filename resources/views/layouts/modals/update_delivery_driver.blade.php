<!-- Change Delivery Modal -->
<div class="modal fade" id="changeDeliveryModal" tabindex="-1" aria-labelledby="changeDeliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeDeliveryModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">two_wheeler</i>
                            </div>
                            <h4 class="card-title">Pilih Driver</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group col-md-12 text-center">
                                <select class="customers form-control dropdown bootstrap-select show-tick list_driver_available" id="id_delivery_driver" data-style="select-with-transition" title="Single Drover" required="true" >
                                    <option value="" disabled selected>Pilih Driver</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_delivery_driver">Save changes</button>
                <button type="button" class="btn btn-primary" id="save_delivery_assign" style="display:none">Save Delivery Assign</button>
            </div>
        </div>
    </div>
</div>