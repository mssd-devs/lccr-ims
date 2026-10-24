 <!-- Footer -->
 <footer class="content-footer footer bg-footer-theme">
     <div class="container-xxl">
         <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
             <div class="text-body mb-2 mb-md-0">
                 ©
                 <script>
                     document.write(new Date().getFullYear());
                 </script>
                 Developed by <a href="https://morobyte.com/" target="_blank" class="footer-link fw-medium">MOROBYTE IT Solutions</a>
             </div>
             <div class="d-none d-lg-inline-block">
                 <?php
                    $footer = $this->db->get("tbl_websettings");
                    if ($footer->num_rows() > 0) {
                        foreach ($footer->result() as $row) {
                    ?>

                         <a class="footer-link me-3"><?= htmlspecialchars($row->IMS_WEB_NOS); ?></a>
                 <?php
                        }
                    }
                    ?>

                 <a class="footer-link me-3">|</a>
                 <a class="footer-link me-3">Institutional Management System v1.0</a>
             </div>

         </div>
     </div>
 </footer>
 <!-- / Footer -->

 <div class="content-backdrop fade"></div>
 </div>
 <!-- Content wrapper -->
 </div>
 <!-- / Layout page -->
 </div>

 <!-- Overlay -->
 <div class="layout-overlay layout-menu-toggle"></div>

 <!-- Drag Target Area To SlideIn Menu On Small Screens -->
 <div class="drag-target"></div>

 </div>



 <script>
     $(document).ready(function() {
         $('.select2').select2({
             allowClear: true
         });
     });
 </script>

 <script>
     $(document).ready(function() {

         $('#fixedColumnDataTable').DataTable({
             dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip', // Custom layout
             buttons: [{
                 extend: 'collection',
                 text: '<i class="ri-download-2-line"></i> Export Data',
                 buttons: [{
                         extend: 'copy',
                         text: 'Copy to Clipboard'
                     },
                     {
                         extend: 'csv',
                         text: 'Export as CSV'
                     },
                     {
                         extend: 'excel',
                         text: 'Export as Excel'
                     },
                     {
                         extend: 'pdf',
                         text: 'Export as PDF'
                     },
                     {
                         extend: 'print',
                         text: 'Print Table'
                     }
                 ]
             }],
             responsive: false,
             autoWidth: true,
             fixedColumns: {
                 left: 1, // Freezes first column
                 right: 1 // Freezes last column
             },
             pageLength: 5,
             lengthMenu: [5, 10, 25, 50, 75, 100],
             language: {
                 search: "Search:",
                 lengthMenu: "Display _MENU_ records per page",
                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
                 paginate: {
                     first: "First",
                     last: "Last",
                     next: "Next",
                     previous: "Previous"
                 }
             }
         });


         $('#dataTable').DataTable({
             dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip', // Custom layout
             buttons: [{
                 extend: 'collection',
                 text: '<i class="ri-download-2-line"></i> Export Data',
                 buttons: [{
                         extend: 'copy',
                         text: 'Copy to Clipboard'
                     },
                     {
                         extend: 'csv',
                         text: 'Export as CSV'
                     },
                     {
                         extend: 'excel',
                         text: 'Export as Excel'
                     },
                     {
                         extend: 'pdf',
                         text: 'Export as PDF'
                     },
                     {
                         extend: 'print',
                         text: 'Print Table'
                     }
                 ]
             }],
             responsive: true,
             autoWidth: true,
             pageLength: 10,
             order: [
                 [0, 'desc']
             ], // Default sorting by the first column
             lengthMenu: [5, 10, 25, 50, 75, 100],
             language: {
                 search: "Search:",
                 lengthMenu: "Display _MENU_ records per page",
                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
                 paginate: {
                     first: "First",
                     last: "Last",
                     next: "Next",
                     previous: "Previous"
                 }
             }
         });



         $(".btn-logout").on("click", function() {
             Swal.fire({
                 title: "Are you sure?",
                 text: "You will be logged out of your account.",
                 icon: "warning",
                 showCancelButton: false,
                 customClass: {
                     confirmButton: 'btn btn-primary',
                     cancelButton: 'btn btn-secondary'
                 },
                 buttonsStyling: false,
                 confirmButtonText: "Yes, log me out!",
                 cancelButtonText: "No, cancel",
             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: "<?= base_url('UsersController/logout'); ?>", // Replace with your logout URL
                         type: "POST",
                         dataType: "json",
                         data: {
                             [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                         },

                         success: function(response) {
                             Swal.fire({
                                 title: 'Logged out!!',
                                 text: 'You have been successfully logged out.',
                                 icon: 'success',
                                 customClass: {
                                     confirmButton: 'btn btn-primary'
                                 },
                                 buttonsStyling: false,
                                 confirmButtonText: 'OK'
                             }).then(() => {
                                 // Redirect to the login page or homepage
                                 window.location.href =
                                     "<?= base_url('login'); ?>";
                             });
                         },
                         error: function(xhr, status, error) {
                             Swal.fire({
                                 title: 'Error!',
                                 text: error,
                                 icon: 'error',
                                 customClass: {
                                     confirmButton: 'btn btn-primary'
                                 },
                                 buttonsStyling: false,
                                 confirmButtonText: 'OK'
                             });
                         },
                     });
                 }
             });
         });



     });



     $(document).ready(function() {
         $('form').on('keyup change', 'input, select, textarea', function() {
             var val = $(this).val();
             var isEmpty = !val || (Array.isArray(val) ? val.length === 0 : $.trim(val) === '');
             $(this).removeClass('is-invalid was-validated')
                 .toggleClass('is-invalid', isEmpty)
                 .toggleClass('was-validated', !isEmpty);
         });

         <?php
            if ($this->session->flashdata("success") != "") {
            ?>
             Swal.fire({
                 title: 'Success!',
                 html: <?= json_encode($this->session->flashdata("success")); ?>,
                 icon: 'success',
                 customClass: {
                     confirmButton: 'btn btn-primary'
                 },
                 buttonsStyling: false,
                 confirmButtonText: 'OK'
             });
         <?php
            }
            ?>
         <?php
            if ($this->session->flashdata("error") != "") {
                $error_msg = $this->session->flashdata("error");
                $title = 'Error!';
                $icon = 'error';
                if (stripos($error_msg, 'conflict') !== false || stripos($error_msg, 'duplicate') !== false) {
                    $title = 'Conflict Schedule';
                    $icon = 'warning';
                }
            ?>
             Swal.fire({
                 title: <?= json_encode($title); ?>,
                 html: <?= json_encode($error_msg); ?>,
                 icon: <?= json_encode($icon); ?>,
                 customClass: {
                     confirmButton: 'btn btn-primary'
                 },
                 buttonsStyling: false,
                 confirmButtonText: 'OK'
             });
         <?php
            }
            ?>
         <?php
            if ($this->session->flashdata("warning") != "") {
            ?>
             Swal.fire({
                 title: 'Conflict Schedule',
                 html: <?= json_encode($this->session->flashdata("warning")); ?>,
                 icon: 'warning',
                 customClass: {
                     confirmButton: 'btn btn-primary'
                 },
                 buttonsStyling: false,
                 confirmButtonText: 'OK'
             });
         <?php
            }
            ?>
     });
 </script>




 <script src="<?= base_url() ?>assets/js/cropper.min.js"></script>
 <!-- Vendors JS -->
 <script src="<?= base_url() ?>assets/vendor/libs/quill/quill.js"></script>
 <!-- Page JS -->
 <script src="<?= base_url() ?>assets/js/forms-editors.js"></script>

 <!-- Core JS -->
 <!-- build:js assets/vendor/js/core.js -->
 <!-- Summernote JS -->
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/popper/popper.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/js/bootstrap.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/node-waves/node-waves.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/hammer/hammer.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/i18n/i18n.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/typeahead-js/typeahead.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/js/menu.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/webcamjs/webcam.min.js"></script>
 <!-- endbuild -->

 <!-- Vendors JS -->
 <script src="<?= base_url(); ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
 <!-- Page JS -->

 <script src="<?= base_url(); ?>assets/vendor/libs/cleavejs/cleave.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/cleavejs/cleave-phone.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

 <!-- Vendors JS -->
 <script src="<?= base_url(); ?>assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/select2/select2.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

 <!-- Flat Picker -->
 <script src="<?= base_url(); ?>assets/vendor/libs/moment/moment.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
 <!-- Form Validation -->
 <script src="<?= base_url(); ?>assets/vendor/libs/@form-validation/popular.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/@form-validation/bootstrap5.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/libs/@form-validation/auto-focus.js"></script>
 <!-- Main JS -->
 <script src="<?= base_url(); ?>assets/js/main.js"></script>

 <!-- Page JS -->
 <script src="<?= base_url(); ?>assets/js/ui-popover.js"></script>

 <!-- Page JS -->
 <script src="<?= base_url(); ?>assets/js/charts-apex.js"></script>
 <script src="<?= base_url(); ?>assets/js/form-wizard-numbered.js"></script>
 <script src="<?= base_url(); ?>assets/js/form-wizard-validation.js"></script>
 <script src="<?= base_url(); ?>assets/js/form-wizard-icons.js"></script>
 <!-- Page JS -->
 <script src="<?= base_url(); ?>assets/js/dashboards-crm.js"></script>
 <script src="<?= base_url(); ?>assets/js/app-user-view-security.js"></script>
 <!-- Page JS -->
 <script src="<?= base_url(); ?>assets/js/tables-datatables-basic.js"></script>

 <div id="pwa-install-banner" style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: #ffffff; padding: 15px 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; align-items: center; justify-content: space-between; gap: 20px; border: 1px solid #e2e8f0; width: 90%; max-width: 400px; font-family: 'Outfit', sans-serif;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #4F46E5;">
            <i class="ri-smartphone-line" style="font-size: 24px;"></i>
        </div>
        <div>
            <h6 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; text-align: left;">Install App</h6>
            <p style="margin: 0; font-size: 13px; color: #64748b; text-align: left;">Add to home screen</p>
        </div>
    </div>
    <div style="display: flex; gap: 8px; align-items: center;">
        <button id="pwa-close-btn" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">&times;</button>
        <button id="pwa-install-btn" style="background: #4F46E5; color: white; border: none; border-radius: 8px; padding: 0 16px; height: 32px; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); transition: all 0.2s;">Install</button>
    </div>
 </div>

 <script>
    // PWA Service Worker Registration
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('<?= base_url(); ?>sw.js')
                .then(registration => {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                })
                .catch(err => {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }

    // PWA Install Prompt Logic
    let deferredPrompt;
    const pwaInstallBanner = document.getElementById('pwa-install-banner');
    const pwaInstallBtn = document.getElementById('pwa-install-btn');
    const pwaCloseBtn = document.getElementById('pwa-close-btn');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI notify the user they can install the PWA
        pwaInstallBanner.style.display = 'flex';
    });

    if(pwaInstallBtn) {
        pwaInstallBtn.addEventListener('click', async () => {
            // Hide the app provided install promotion
            pwaInstallBanner.style.display = 'none';
            // Show the install prompt
            if (deferredPrompt) {
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                const { outcome } = await deferredPrompt.userChoice;
                console.log(`User response to the install prompt: ${outcome}`);
                // We've used the prompt, and can't use it again, throw it away
                deferredPrompt = null;
            }
        });
    }

    if(pwaCloseBtn) {
        pwaCloseBtn.addEventListener('click', () => {
            pwaInstallBanner.style.display = 'none';
        });
    }
 </script>

 </body>

 </html>