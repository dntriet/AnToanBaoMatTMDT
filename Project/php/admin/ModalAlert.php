<!-- Delete modal alert. Modified 23/10/2023 by Quyen.
    Not have: 
    +Event: button clicking
    +Close modal alert, Message when add or edit successfully -->

<!-- start of warning message when click del-btn -->
<div class="modal fade modal-sm alert-container" id="alert" tabindex="-1" aria-labelledby="#delete-alert" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete-alert">
                        Xác nhận <?php echo $alert_message; ?>
                    </h1>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-outline-secondary border border-secondary">Hủy</button>
                    <button type="button" class="btn btn-danger">
                        <?php echo $alert_action; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- end of warning message when click del-btn -->