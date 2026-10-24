<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);"> Billing</a>
            </li>
            <li class="breadcrumb-item active">Payment</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">


            <div class="row">
                <?php
                $id = "";
                foreach ($LoadStudentEnrolled->result() as $r) {
                    $id = $r->ID;
                ?>
                    <input type="hidden" name="ID" id="ID" value="<?= $r->ID; ?>">
                    <input type="hidden" name="ER_TRANSNO" id="ER_TRANSNO" value="<?= $r->ER_TRANSNO; ?>">
                    <input type="hidden" name="ER_STUDENTID" id="ER_STUDENTID" value="<?= $r->ER_STUDENTID; ?>">
                    <div class="col-12 col-md-5 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h5>Student Record</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%;">
                                                <tr>
                                                    <th>Student ID:</th>
                                                    <td><b><?= $r->ER_STUDENTID; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><b><?= $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME; ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Gender:</th>
                                                    <td><b><?= $r->SP_GENDER; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <th>Semester/School Year:</th>
                                                    <td><b><?= $r->ER_SEMESTER . ' / ' . $r->ER_ACADEMICYEAR; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <th>Enrollment Status:</th>
                                                    <td>
                                                        <?php if ($r->ER_ENSTATUS == 'PENDING') : ?>
                                                            <span
                                                                class="badge rounded-pill bg-warning"><?= $r->ER_ENSTATUS; ?></span>
                                                        <?php elseif ($r->ER_ENSTATUS == 'ACTIVE') : ?>
                                                            <span
                                                                class="badge rounded-pill bg-success"><?= $r->ER_ENSTATUS; ?></span>
                                                        <?php else : ?>
                                                            <span
                                                                class="badge rounded-pill bg-primary"><?= $r->ER_ENSTATUS; ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Program and Year:</th>
                                                    <td><b><?= $r->ER_PROGRAM . ' ' . $r->ER_MAJOR . ' / ' . $r->ER_YEARLEVEL;  ?></b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <table class="table table-borderless table-sm" style="width: 100%;">
                                            <tbody id="tbl_mode_payment"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


                <div class="col-12 col-md-7">
                    <form id="submitFormPayment" novalidate>
                        <input type="hidden" name="uid" value="<?= $id; ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Payment</h4>
                                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                                <input type="hidden" class="txt_csrfname"
                                    name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-borderless">
                                            <tbody id="tbl_body_tuition"></tbody>
                                        </table>
                                    </div>

                                    <!-- discount -->
                                    <div class="col-md-12">
                                        <table class="table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <button type="button" class="btn btn-xs btn-secondary mb-2"
                                                            data-bs-target="#discountModal" data-bs-toggle="modal"><i
                                                                class="ri ri-pencil-line"></i> Manage
                                                            Voucher</button><br>
                                                        Type of Voucher
                                                    </th>
                                                    <th>Voucher Amount</th>
                                                    <th>
                                                        <button type="button"
                                                            class="btn btn-xs btn-primary btn-add-more-discount"><i
                                                                class="ri ri-add-line"></i> Add Voucher</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_body_discount"></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        <label class="fw-bold">Net Assessment</small>
                                                    </td>
                                                    <td>
                                                        <h4 class="text-danger fw-bold sub_total_output"></h4>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" name="P_DESC[]" id="P_DESC" multiple="multiple" required
                                                aria-label="Default select example">
                                            </select>
                                            <label for="basic-default-fullname">Payment Description <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" class="form-control" name="P_AMOUNT" id="P_AMOUNT"
                                                disabled required />
                                            <label for="basic-default-fullname">Enter Amount<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="submitPayment" disabled class="btn btn-success btn-lg">
                                    <i class="ri-check-line"></i> Process Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h5>Payment Summary</h5>
                                <table id="myTable" class="table " style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Encoder</th>
                                            <th>Date</th>
                                            <th>Descriptions</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_payments = 0;
                                        $query = $this->db->where("ER_TRANSNO", $this->uri->segment(5))->get("tbl_payment");
                                        foreach ($query->result() as $r) {
                                            $total_payments += str_replace(',', '', $r->P_AMOUNT);
                                        ?>
                                            <tr>
                                                <td><?= $r->P_ENCODER; ?></td>
                                                <td><?= $r->P_DATESUBMITTED; ?></td>
                                                <td><?= $r->P_DESC; ?>
                                                    <?= ($r->P_AMOUNT == 0) ? "<small>(Promissory Note)</small>" : "" ?>
                                                </td>
                                                <td>₱<?= $r->P_AMOUNT; ?> </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-line"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item btn_print_receipt"
                                                                data-ornum="<?= $r->OR_NUM ?>"><i
                                                                    class="ri-printer-line me-1"></i> Print Receipt</button>
                                                            <button class="dropdown-item btn_delete_payment"
                                                                data-vcno="<?= $r->P_VOUCHERNO ?>" data-id="<?= $r->ID ?>"
                                                                data-trno="<?= $r->ER_TRANSNO ?>"><i
                                                                    class="ri-delete-bin-6-line me-1"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end fw-bold" colspan="3">Sub-Total</td>
                                            <td colspan="2" class="fw-bold">₱<?= number_format($total_payments, 2); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $total_discounts = 0;
                                        $query = $this->db->where("ER_TRANSNO", $this->uri->segment(5))->get("tbl_payment_discount");
                                        foreach ($query->result() as $r) {
                                            $total_discounts += str_replace(',', '', $r->D_AMOUNT);
                                        ?>
                                            <tr>
                                                <td colspan="3" class="text-end"><small><?= $r->D_DESC ?></small></td>
                                                <td>(₱<?= $r->D_AMOUNT ?>)</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-line"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item btn_delete_voucher"
                                                                data-id="<?= $r->ID; ?>"><i
                                                                    class="ri-delete-bin-6-line me-1"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        $total_paid = $total_payments + $total_discounts;
                                        ?>
                                        <tr>

                                            <td colspan="3" class="text-end fw-bold">Total Paid Amount</td>
                                            <td colspan="2">
                                                <span
                                                    class="fs-24 fw-bold text-success">₱<?= number_format($total_paid, 2); ?></span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="discountModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="paymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Manage Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="TOD_ID">
                <div class="mb-3">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="TOD_NAME" id="TOD_NAME" required />
                        <label for="basic-default-fullname">Type of Voucher <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="TOD_PERCENT" id="TOD_PERCENT" required />
                        <label for="basic-default-fullname">Amount Value <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end gap-2">
                    <button type="button" id="newPaymentForm" class="btn btn-primary"><i class="ri-save-line"></i> Save
                        Voucher</button>
                    <button type="button" class="btn btn-warning btn-cancel"><i class="ri-close-line"></i>
                        Clear</button>

                </div>

                <div class="mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Type of Voucher</th>
                                <th>Amount Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_tod"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function() {


        $(document).on('click', '.btn_print_receipt', function() {
            var id = "<?= $this->uri->segment(4); ?>";
            var ornum = $(this).data("ornum");
            window.open("<?= base_url('ims/cashierbilling/print/') ?>" + id + '/' + ornum, '_blank');
        });


        $(".btn_delete_voucher").click(function() {
            var id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this voucher!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('CashierBillingController/delete_summary_voucher'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            ID: id,
                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname')
                                .val() // CSRF token
                        },
                        success: function(response) {
                            // Update CSRF token
                            $('.txt_csrfname').val(response.token);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Voucher has been deleted.",
                                icon: "success",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the voucher.",
                                icon: "error",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                            });
                        }
                    });
                }
            });
        });

        $(".btn_delete_payment").click(function() {
            var id = $(this).data("id");
            var vcno = $(this).data("vcno");
            var trno = $(this).data("trno");
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this payment!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('CashierBillingController/delete_summary_payment'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            ID: id,
                            P_VOUCHERNO: vcno,
                            ER_TRANSNO: trno,
                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname')
                                .val() // CSRF token
                        },
                        success: function(response) {
                            // Update CSRF token
                            $('.txt_csrfname').val(response.token);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Payment has been deleted.",
                                icon: "success",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the payment.",
                                icon: "error",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                            });
                        }
                    });
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        const form = $("#submitFormPayment");
        form.append('<input type="hidden" name="ER_TRANSNO" value="' + $('#ER_TRANSNO').val() + '">');
        form.append('<input type="hidden" name="ER_STUDENTID" value="' + $('#ER_STUDENTID').val() + '">');

        $("#submitPayment").on("click", function(e) {
            e.preventDefault(); // Prevent default form submission
            if (form[0].checkValidity() === false) {
                form[0].reportValidity(); // Show native validation messages if any
                return;
            }
            showConfirmationDialog();
        });

        function showConfirmationDialog() {
            Swal.fire({
                title: "Are you sure?",
                text: "Once submitted, The payment will be saved!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        }

        function submitForm() {
            $.ajax({
                url: "<?= base_url('CashierBillingController/savePayment'); ?>",
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait while we save the payment.",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    Swal.fire({
                        title: "Success!",
                        text: "Payment has been saved.",
                        icon: "success",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred while processing your request.",
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    });
                }
            });
        }
    });
</script>



<script>
    $(document).ready(function() {
        // add type of discount
        $("#newPaymentForm").click(function() {
            if ($("#TOD_NAME").val() != "" && $("#TOD_PERCENT").val() != "") {
                $.ajax({
                    url: '<?= base_url("CashierBillingController/saveTypeofDiscount") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        TOD_NAME: $("#TOD_NAME").val(),
                        TOD_PERCENT: $("#TOD_PERCENT").val(),
                        ID: $("#TOD_ID").val(),
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                    },
                    success: function(response) {
                        // Update CSRF token
                        $('.txt_csrfname').val(response.token);
                        $("#TOD_NAME").val("")
                        $("#TOD_PERCENT").val("")
                        $("#TOD_ID").val("")
                        load_type_of_discount();
                        load_discount_select();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        alert('Failed to save discount');
                    }
                });
            }
        });




        $(document).on("click", ".btn-add-more-discount", function() {
            $.ajax({
                url: '<?= base_url("CashierBillingController/addDiscountFields") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    $('#tbl_body_discount').append(response.output);
                    initializeSelect2($("select[name='P_DISCOUNT_NAME[]']"));
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Failed to save discount');
                }
            });
        });

        // display discount input and select
        $(document).on("click", ".btn-delete-manage-discount", function() {
            $.ajax({
                url: '<?= base_url("CashierBillingController/deleteTypeofDiscount") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    ID: $(this).data("id"),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    load_type_of_discount();
                    load_discount_select();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Failed to save discount');
                }
            });
        });



        $(document).on("click", ".btn-edit-discount", function() {
            $("#TOD_NAME").val($(this).data("name"));
            $("#TOD_PERCENT").val($(this).data("percent"));
            $("#TOD_ID").val($(this).data("id"));
        });
        $(document).on("click", ".btn-cancel", function() {
            $("#TOD_NAME").val("");
            $("#TOD_PERCENT").val("");
            $("#TOD_ID").val("");
        });


        load_type_of_discount();

        function load_type_of_discount() {
            $.ajax({
                url: '<?= base_url("CashierBillingController/load_type_of_discount") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    // Update subjects table
                    $('#tbl_tod').html(response.output);
                    //   load_discount_select();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Failed to discount');
                }
            });
        }



        // Function to format BP_AMOUNT inputs
        // function formatAmount(element) {
        //     element.keyup(function(event) {
        //         if (event.which >= 37 && event.which <= 40) {
        //             event.preventDefault();
        //         }
        //         $(this).val(function(index, value) {
        //             return value.replace(/\D/g, "")
        //                 .replace(/([0-9])([0-9]{2})$/, '$1.$2')
        //                 .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
        //         });
        //         updateTotalAmount();
        //     });
        // }

        function initializeSelect2(element) {
            if (typeof select2Focus === 'function') {
                select2Focus(element);
            }
            if (!element.parent().hasClass('position-relative')) {
                element.wrap('<div class="position-relative"></div>');
            }
            element.select2({
                placeholder: "Select an option",
                dropdownParent: element.parent(),
                allowClear: true,
                closeOnSelect: true // Added this to forcefully close dropdown after selection
            });
        }
        window.initializeSelect2 = initializeSelect2;

        function load_discount_select() {
            $.ajax({
                url: '<?= base_url("CashierBillingController/load_discount_select") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    // Update subjects table
                    $("select[name='P_DISCOUNT_NAME[]']").html(response.output);
                    $("input[name='P_DISCOUNT_AMOUNT[]']").val("");
                    initializeSelect2($("select[name='P_DISCOUNT_NAME[]']"));
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Failed to discount');
                }
            });
        }

        var lastSelectedValues = [];

        $(document).on("change", "#P_DESC", function() {
            var selectedVal = $(this).val();
            console.log("#P_DESC changed to:", selectedVal);

            var milestoneMethods = ["Full Payment", "Downpayment", "Prelim", "Midterm", "Pre-Final", "Final"];
            var selectedArray = Array.isArray(selectedVal) ? selectedVal : (selectedVal ? [selectedVal] : []);
            
            // Find newly selected option
            var newlySelected = null;
            for (var i = 0; i < selectedArray.length; i++) {
                if (lastSelectedValues.indexOf(selectedArray[i]) === -1) {
                    newlySelected = selectedArray[i];
                    break;
                }
            }
            
            if (newlySelected) {
                if (milestoneMethods.indexOf(newlySelected) !== -1) {
                    if (selectedArray.length > 1) {
                        selectedArray = [newlySelected];
                        $(this).val(selectedArray).trigger("change.select2");
                        lastSelectedValues = selectedArray;
                        return;
                    }
                } else {
                    var filteredVal = selectedArray.filter(function(val) {
                        return milestoneMethods.indexOf(val) === -1;
                    });
                    if (filteredVal.length !== selectedArray.length) {
                        selectedArray = filteredVal;
                        $(this).val(selectedArray).trigger("change.select2");
                        lastSelectedValues = selectedArray;
                        return;
                    }
                }
            }
            lastSelectedValues = selectedArray;

            if (selectedArray.length > 0) {
                try {
                    var isMilestoneSelected = selectedArray.some(function(method) {
                        return milestoneMethods.indexOf(method) !== -1;
                    });

                    // Force enable the amount field using Vanilla JS to bypass any jQuery state issues
                    var amountInput = document.getElementById("P_AMOUNT");
                    if (amountInput) {
                        amountInput.disabled = false;
                        amountInput.removeAttribute("disabled");
                        if (isMilestoneSelected) {
                            amountInput.readOnly = false;
                            amountInput.removeAttribute("readonly");
                        } else {
                            amountInput.readOnly = true;
                            amountInput.setAttribute("readonly", "readonly");
                        }
                    }
                    
                    $("#P_AMOUNT").prop("disabled", false);
                    if (isMilestoneSelected) {
                        $("#P_AMOUNT").prop("readonly", false);
                    } else {
                        $("#P_AMOUNT").prop("readonly", true);
                    }

                    // Robustly get data-amount from selected option (standard and Select2 fallbacks)
                    var selectedOption = $(this).find("option:selected");
                    var totalAmount = 0;
                    var hasAmountData = false;

                    selectedOption.each(function() {
                        var amt = $(this).attr("data-amount");
                        if (amt === undefined && $("#P_DESC").data('select2')) {
                            var select2Data = $("#P_DESC").select2('data');
                            if (select2Data && select2Data.length > 0) {
                                var val = $(this).val();
                                for (var i = 0; i < select2Data.length; i++) {
                                    if (select2Data[i].id === val && select2Data[i].element) {
                                        amt = $(select2Data[i].element).attr('data-amount');
                                        break;
                                    }
                                }
                            }
                        }
                        if (amt !== undefined && amt !== null && amt !== "") {
                            totalAmount += parseFloat(String(amt).replace(/[^0-9.]/g, '')) || 0;
                            hasAmountData = true;
                        }
                    });

                    console.log("Retrieved raw total amount:", totalAmount);

                    if (hasAmountData) {
                        var formattedValue = totalAmount.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $("#P_AMOUNT").val(formattedValue);
                        validatePaymentMethod(totalAmount);
                    } else {
                        $("#P_AMOUNT").val("");
                        validatePaymentMethod(0);
                    }
                } catch (e) {
                    console.error("Error in change handler:", e);
                }

                // Validation is now completely managed by validatePaymentMethod
            } else {
                $("#P_AMOUNT").prop("disabled", true);
                $("#P_AMOUNT").prop("readonly", false);
                $("#P_AMOUNT").val("");
                validatePaymentMethod(0);
            }
        });
    });
</script>


<script>
    $(document).ready(function() {

        load_tuition_and_fees();

        function load_tuition_and_fees() {
            $.ajax({
                url: '<?= base_url("CashierBillingController/load_tuition_and_fees") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    ID: "<?= $this->uri->segment(4); ?>",
                    ER_TRANSNO: "<?= $this->uri->segment(5); ?>",
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    // Update subjects table
                    $('#tbl_body_tuition').html(response.output.result_tuition);
                    $('#tbl_mode_payment').html(response.output.result_paymentmode);
                    
                    // Safely destroy Select2 if already initialized to prevent selection bugs
                    if ($('#P_DESC').data('select2')) {
                        $('#P_DESC').select2('destroy');
                    }
                    $('#P_DESC').html(response.output.result_select_desc);
                    initializeSelect2($('#P_DESC'));
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('Failed to discount');
                }
            });
        }

        // Remove rows
        $("#tbl_body_discount").on("click", ".btn-delete-discount", function() {
            if ($("#tbl_body_discount tr").length > 0) {
                $(this).closest("tr").remove();
                update_sub_total();
            }
        });




        // $(document).on("change", ".select_discount", function() {

        //     var balance = $("#PRE_BALANCE").val().replace(/[^0-9]/g, '');
        //     var discount = parseFloat(data.TOD_PERCENT.replace('%', '')) / 100;
        //     var sub_total = balance * discount;
        //     $(".P_DISCOUNT_AMOUNT").val(sub_total);
        // });

        $(document).on("change", ".select_discount", function() {
            const data = JSON.parse($(this).val());
            if (data && typeof data === 'object' && data.TOD_AMOUNT) {
                var amount = parseFloat(data.TOD_AMOUNT.replace(/[^0-9.]/g, '')) || 0;
                var formatted_amount = amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $(this).closest('tr').find("input[name='P_DISCOUNT_AMOUNT[]']").val(formatted_amount);
                update_sub_total();
            }
        });

        $(document).on("keyup", "input[name='P_DISCOUNT_AMOUNT[]']", function() {
            update_sub_total();
        });

        function update_sub_total() {
            var balance = parseFloat($("#PRE_BALANCE").text().replace(/[^0-9.]/g, '')) || 0;
            var totalDiscount = 0;

            $("input[name='P_DISCOUNT_AMOUNT[]']").each(function() {
                var discountAmount = parseFloat($(this).val().replace(/[^0-9.]/g, '')) || 0;
                totalDiscount += discountAmount;
            });

            var subTotal = balance - totalDiscount;
            var formattedSubTotal = subTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            $(".sub_total_output").text("₱" + formattedSubTotal);
        }

        $(document).on("change", ".select_discount, input[name='P_DISCOUNT_AMOUNT[]']", function() {
            update_sub_total();
        });


        // Improved function to format P_AMOUNT inputs with balance validation using $(document).on('keyup')
        $(document).on("keyup", "#P_AMOUNT", function(event) {
            if (event.which >= 37 && event.which <= 40) return; // Skip arrow keys

            var element = $(this);
            var balance = parseFloat($('#PRE_BALANCE').text().replace(/[^0-9.]/g, '')) || 0;

            // Format the input value to currency format
            var formattedValue = element.val().replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            element.val(formattedValue);

            var amount = parseFloat(formattedValue.replace(/[^0-9.]/g, '')) || 0;

            // Add delay before validating payment method rules
            clearTimeout(window.paymentMethodTimeout);
            window.paymentMethodTimeout = setTimeout(function() {
                validatePaymentMethod(amount);
            }, 200); // 200ms delay
        });

        $(document).on("keyup", "#TOD_PERCENT", function(event) {
            if (event.which >= 37 && event.which <= 40) return; // Skip arrow keys

            var element = $(this);
            // Format the input value to currency format
            var formattedValue = element.val().replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            element.val(formattedValue);
        });


        function validatePaymentMethod(amount) {
            try {
                var selectedMethod = $("#P_DESC").val();
                console.log("validatePaymentMethod called:", { selectedMethod: selectedMethod, amount: amount });
                if (!selectedMethod || (Array.isArray(selectedMethod) && selectedMethod.length === 0)) {
                    var btn = document.getElementById("submitPayment");
                    if (btn) {
                        btn.disabled = true;
                        btn.setAttribute("disabled", "disabled");
                    }
                    $("#submitPayment").prop("disabled", true);
                    return;
                }

                // Cleanly get the balance
                var balanceText = $(".sub_total_output").text().trim();
                if (balanceText === "") {
                    balanceText = $('#PRE_BALANCE').text().trim();
                }
                var balance = parseFloat(balanceText.replace(/[^0-9.]/g, '')) || 0;
                var enrollment_fee = parseFloat($(".enrollment_fee").text().replace(/[^0-9.]/g, '')) || 0;
                amount = parseFloat(amount) || 0;

                // Get cumulative specific fee limit if defined in option data-amount
                var feeLimit = 0;
                var hasLimit = false;
                var selectedOption = $("#P_DESC").find("option:selected");
                
                selectedOption.each(function() {
                    var rawLimit = $(this).attr("data-amount");
                    if (rawLimit === undefined && $("#P_DESC").data('select2')) {
                        var select2Data = $("#P_DESC").select2('data');
                        if (select2Data && select2Data.length > 0) {
                            var val = $(this).val();
                            for (var i = 0; i < select2Data.length; i++) {
                                if (select2Data[i].id === val && select2Data[i].element) {
                                    rawLimit = $(select2Data[i].element).attr('data-amount');
                                    break;
                                }
                            }
                        }
                    }
                    if (rawLimit !== undefined && rawLimit !== null && rawLimit !== "") {
                        feeLimit += parseFloat(String(rawLimit).replace(/[^0-9.]/g, '')) || 0;
                        hasLimit = true;
                    }
                });

                console.log("Parsed metrics:", { balance: balance, enrollment_fee: enrollment_fee, amount: amount, feeLimit: feeLimit, hasLimit: hasLimit });

                // Remove existing invalid-feedback
                $("#P_AMOUNT").removeClass("is-invalid");
                $("#P_AMOUNT").closest(".form-floating").find(".invalid-feedback").remove();

                var milestoneMethods = ["Full Payment", "Downpayment", "Prelim", "Midterm", "Pre-Final", "Final"];
                var selectedArray = Array.isArray(selectedMethod) ? selectedMethod : [selectedMethod];
                var isFullPayment = selectedArray.indexOf("Full Payment") !== -1;
                var isDownpayment = selectedArray.indexOf("Downpayment") !== -1;
                var isMilestone = selectedArray.some(function(method) {
                    return milestoneMethods.indexOf(method) !== -1;
                });

                if (isFullPayment) {
                    if (Math.abs(amount - balance) > 0.01) {
                        $("#P_AMOUNT").addClass("is-invalid");
                        $("#P_AMOUNT").closest(".form-floating").append(
                            '<div class="invalid-feedback" style="display: block;">Entered amount does not match the full balance.</div>'
                        );
                        disableSubmitButton();
                    } else {
                        enableSubmitButton();
                    }
                } else if (isDownpayment) {
                    if (amount < enrollment_fee) {
                        $("#P_AMOUNT").addClass("is-invalid");
                        $("#P_AMOUNT").closest(".form-floating").append(
                            '<div class="invalid-feedback" style="display: block;">Downpayment must be at least equal to the enrollment fee.</div>'
                        );
                        disableSubmitButton();
                    } else if (amount > balance) {
                        $("#P_AMOUNT").addClass("is-invalid");
                        $("#P_AMOUNT").closest(".form-floating").append(
                            '<div class="invalid-feedback" style="display: block;">Entered amount exceeds the available balance.</div>'
                        );
                        disableSubmitButton();
                    } else {
                        enableSubmitButton();
                    }
                } else if (isMilestone) {
                    // For other milestones like Prelim, Midterm, etc.
                    if (amount > balance) {
                        $("#P_AMOUNT").addClass("is-invalid");
                        $("#P_AMOUNT").closest(".form-floating").append(
                            '<div class="invalid-feedback" style="display: block;">Entered amount exceeds the available balance.</div>'
                        );
                        disableSubmitButton();
                    } else if (amount <= 0) {
                        disableSubmitButton();
                    } else {
                        enableSubmitButton();
                    }
                } else {
                    // For specific miscellaneous fees and other fees (e.g. LABORATORY, INTERNET, etc.)
                    if (hasLimit && feeLimit > 0) {
                        if (amount > feeLimit) {
                            $("#P_AMOUNT").addClass("is-invalid");
                            $("#P_AMOUNT").closest(".form-floating").append(
                                '<div class="invalid-feedback" style="display: block;">Entered amount exceeds the specific fee limit (₱' + feeLimit.toLocaleString('en-US', {minimumFractionDigits: 2}) + ').</div>'
                            );
                            disableSubmitButton();
                        } else if (amount <= 0) {
                            disableSubmitButton();
                        } else {
                            enableSubmitButton();
                        }
                    } else {
                        // If no specific fee limit is defined in the database, allow any positive amount
                        if (amount <= 0) {
                            disableSubmitButton();
                        } else {
                            enableSubmitButton();
                        }
                    }
                }
            } catch (e) {
                console.error("Error in validatePaymentMethod:", e);
                // Safety fallback to enable button if a specific fee is selected
                var selectedMethod = $("#P_DESC").val();
                var milestoneMethods = ["Full Payment", "Downpayment", "Prelim", "Midterm", "Pre-Final", "Final"];
                var selectedArray = Array.isArray(selectedMethod) ? selectedMethod : [selectedMethod];
                var isMilestone = selectedArray.some(function(method) {
                    return milestoneMethods.indexOf(method) !== -1;
                });
                if (selectedMethod && !isMilestone) {
                    enableSubmitButton();
                }
            }
        }

        function disableSubmitButton() {
            var btn = document.getElementById("submitPayment");
            if (btn) {
                btn.disabled = true;
                btn.setAttribute("disabled", "disabled");
                btn.classList.add("disabled");
            }
            $("#submitPayment").prop("disabled", true).addClass("disabled");
        }

        function enableSubmitButton() {
            var btn = document.getElementById("submitPayment");
            if (btn) {
                btn.disabled = false;
                btn.removeAttribute("disabled");
                btn.classList.remove("disabled");
            }
            $("#submitPayment").prop("disabled", false).removeClass("disabled");
        }

        window.validatePaymentMethod = validatePaymentMethod;
        window.disableSubmitButton = disableSubmitButton;
        window.enableSubmitButton = enableSubmitButton;
    });
</script>




<!-- FOR UPPERCASE -->
<script>
    $(document).on('input', '[type="text"], textarea', function() {
        var inputText = $(this).val();
        var uppercaseText = inputText.toUpperCase();
        var textWithoutDoubleSpaces = uppercaseText.replace(/  +/g, ' ');
        $(this).val(textWithoutDoubleSpaces);
    });
</script>
<script>
    function printContainerBox() {
        var containerBox = document.getElementById("paymentreceipt");
        var originalContents = document.body.innerHTML;
        var printContents = containerBox.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>