<style>
    @media print {
        @page {
            margin: 0.25in;
            /* Small margins on all sides */
        }

        body * {
            visibility: hidden !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .card,
        .card-body {
            box-shadow: none !important;
            background: none !important;
        }

        table {
            page-break-inside: auto;
            border-collapse: collapse;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        .print-area,
        .print-area * {
            visibility: visible !important;
        }

        .print-area {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            padding: 0 10px;
            /* small padding to simulate side margin */
            width: 100%;
            background: white !important;
        }

        .background-logo {
            display: block !important;
        }

        body {
            margin: 0 !important;
            background: none !important;
        }
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        color: #000;
    }

    .background-logo {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.05;
        width: 85%;
    }

    .content,
    .card-body {
        color: #000;
    }

    .header table,
    .header td {
        text-align: center;
        vertical-align: middle;
        color: #000;
    }

    .header td {
        padding: 10px;
        color: #000;
    }

    .header img {
        max-width: 90px;
        height: auto;
    }

    .table-custom {
        display: flex;
        flex-direction: column;
        border: 2px solid #000;
        /* Outer border for the full table */
    }

    .table-custom-header,
    .table-custom-row {
        display: flex;
        border-bottom: 1px solid #000;
        /* Horizontal borders */
    }

    .table-custom-header {
        background-color: #f8f9fa;
        font-weight: bold;
        border-bottom: 1px solid #000;
    }

    .table-custom-body {
        display: flex;
        border-bottom: 1px solid #000;
        /* Horizontal borders */
    }

    .table-custom-body {
        background-color: #f8f9fa;
        border-bottom: 1px solid #000;
    }

    .table-custom-footer {
        display: flex;
        border-bottom: 1px solid #000;
        /* Horizontal borders */
    }

    .table-custom-footer {
        background-color: #f8f9fa;
        font-weight: bold;
        border-bottom: 1px solid #000;
    }


    .table-cell {
        flex: 1;
        padding: 6px 8px;
        border-right: 1px solid #000;
        /* Column separator */
        word-break: break-word;
        font-size: 12px;
    }

    .table-cell:last-child {
        border-right: none;
    }

    .text-center {
        text-align: center;
    }

    .remarks,
    .grading {
        font-size: 12px;
        margin-top: 15px;
    }

    .transcript-closed {
        font-weight: bold;
        text-align: center;
        margin: 15px 0;
    }
</style>


<!-- <script>
    window.onload = function() {
        document.body.style.margin = "0";
        window.print();
    };
    window.onafterprint = function() {
        window.close();
    };
</script> -->

<div class="print-area">
    <div class="row">
        <div class="card" id="torprint">
            <div class="card-header">
                <div class="header">
                    <table class="table" style="width: 100%;">
                        <?php
                        $query = $this->db->get("tbl_websettings");
                        foreach ($query->result() as $row) {
                            $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
                            $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
                            $school_acro = $row->IMS_WEB_ACRO;
                            $school_name = $row->IMS_WEB_NOS;
                            $school_address = $row->IMS_WEB_ADDRESS;
                            $school_email = $row->IMS_WEB_EMAIL;
                        }
                        ?>
                        <tr>
                            <center>
                                <td><img src="<?= $logo2 ?>" alt="Logo 1" style="max-width: 100px;"></td>
                                <td>
                                    <span><b>(<?= $school_acro ?>)<?= $school_name ?></b></span><br>
                                    <small><?= $school_address ?></small> <br><small>
                                        <strong>
                                            <h6 style="font-weight: bold;">
                                                OFFICE OF THE REGISTRAR
                                                <span>
                                                    <h5>OFFICIAL TRANSCRIPT OF RECORDS</h5>
                                                </span>
                                            </h6>
                                        </strong>
                                </td>
                                <?php
                                $query1 = $this->db->get("tbl_studprof");
                                foreach ($query1->result() as $rows) {
                                    $picture = ($rows->SP_IMAGE == "") ? base_url("assets/img/avatars/1.png") : base_url("uploads/" . $rows->SP_IMAGE);
                                }
                                ?>
                                <td><img src="<?= $picture ?>" alt="2x2 Picture" style="max-width: 100px;"></td>
                            </center>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="content">
                <!-- Background logo -->
                <img src="<?= $logo2 ?>" alt="Background Logo" class="background-logo">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="card-body">

                    <div class="table-responsive pt-0">
                        <h6 style="text-align: right;">TOR No: <strong><!-- TOR number here --></strong></h6>

                        <div class="table-custom">
                            <!-- Row 1 -->
                            <div class="table-custom-row">
                                <div class="table-cell">Name:</div>
                                <div class="table-cell"><!-- Full Name --></div>
                                <div class="table-cell">Student Number:</div>
                                <div class="table-cell"><!-- Student ID --></div>
                            </div>

                            <!-- Row 2 -->
                            <div class="table-custom-row">
                                <div class="table-cell" style="flex: 1;">Address:</div>
                                <div class="table-cell" style="flex: 4;"><!-- Address --></div>
                                <div class="table-cell" style="flex: 4; font-weight: bold;">ENTRANCE DATA:</div>
                            </div>


                            <!-- Row 3 -->
                            <div class="table-custom-row">
                                <div class="table-cell">Degree/Course:</div>
                                <div class="table-cell"><!-- Degree Program --></div>
                                <div class="table-cell">Date of Admission:</div>
                                <div class="table-cell"><!-- Admission Date --></div>
                            </div>

                            <!-- Row 4 -->
                            <div class="table-custom-row">
                                <div class="table-cell">Senior High School:</div>
                                <div class="table-cell"><!-- SHS School --></div>
                                <div class="table-cell">College:</div>
                                <div class="table-cell"><!-- College Name --></div>
                            </div>

                            <!-- Row 5 -->
                            <div class="table-custom-row">
                                <div class="table-cell">Date of Birth:</div>
                                <div class="table-cell"><!-- Birth Date --></div>
                                <div class="table-cell">Date Graduated:</div>
                                <div class="table-cell"><!-- Graduation Date --></div>
                            </div>

                            <!-- Row 6 -->
                            <div class="table-custom-row">
                                <div class="table-cell">Place of Birth:</div>
                                <div class="table-cell"><!-- Birthplace --></div>
                                <div class="table-cell">Admission Credential:</div>
                                <div class="table-cell"><!-- Credentials --></div>
                            </div>
                        </div>
                    </div>


                    <br>

                    <div class="table-responsive pt-0">
                        <div class="table-custom">
                            <div class="table-custom-body">
                                <div class="table-cell" style="flex: 11;">Entrance Data: Form 137 from President Quirino National High School - President Quirino, Sultan kudarat</div>
                            </div>
                            <div class="table-custom-header">
                                <div class="table-cell font-weight-bold text-center" style="flex: 2;">COURSE NO</div>
                                <div class="table-cell font-weight-bold text-center" style="flex: 6;">DESCRIPTIVE TITLE</div>
                                <div class="table-cell font-weight-bold text-center" style="flex: 1;">GRADE</div>
                                <div class="table-cell font-weight-bold text-center" style="flex: 1;">COMP GRADE</div>
                                <div class="table-cell font-weight-bold text-center" style="flex: 1;">UNITS</div>
                            </div>
                            <div class="table-custom-body">
                                <div class="table-cell" style="flex: 2;">CP 1</div>
                                <div class="table-cell" style="flex: 6;">COMPUTER PROGRAMMING</div>
                                <div class="table-cell text-center" style="flex: 1;">2.50</div>
                                <div class="table-cell text-center" style="flex: 1;">2.00</div>
                                <div class="table-cell text-center" style="flex: 1;">3</div>
                            </div>
                            <div class="table-custom-footer">
                                <div class="table-cell font-weight-bold text-center" style="flex: 11;">General Weighted Average: </div>
                            </div>
                        </div>
                    </div>



                    <br>
                    <div class="row">
                        <p class="text-center">= = = = = = = = = = = = TRANSCRIPT CLOSED = = = = = = = = = = = = </p>
                    </div>
                    <div class="separator"></div>
                    <div class="row">
                        <div style="padding: 10px; font-family: Times New Roman, Times, serif;">
                            <strong>Grading System:</strong><br>
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; border: 1px solid black; padding: 10px; margin-top: 10px;">
                                <div style="width: 30%;">
                                    1.0–1.25 – Excellent<br>
                                    1.5–1.75 – Very Good<br>
                                    2.0–2.25 – Good<br><br>OW – Officially Withdrawn
                                </div>
                                <div style="width: 30%;">
                                    2.5–2.75 – Satisfactory<br>
                                    3.0 – Passing<br>
                                    5.0 – Failed<br><br>UW – Unofficially Withdrawn
                                </div>
                                <div style="width: 30%;">
                                    INC – Incomplete<br><br><br><br>NGA – No Grade Due to Absences
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="fw-bold">REMARKS: Granted Transfer Credentials, Copy <br>
                            Date Issued: <strong><?= date('F d, Y') ?></strong></p>
                        <p style="text-align: justify;">Credit: One unit is one-hour lecture or three hours laboratory work each week for a period of one trimester. <br>
                            Note: This copy is not valid without the dry seal of the institution and original signature in ink of the registrar. Any erasure or alteration made on these entries in this form renders the whole transcript invalid.
                        </p>
                    </div>
                    <div class="row">
                        <div style="padding: 10px; font-family: Times New Roman, Times, serif;">
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                                <div style="width: 50%;">
                                    <div class="col-md-6 text-left">
                                        <strong>Evaluated by:</strong>
                                        <div class="text-center mt-3">
                                            <span class="signature-line">_________________</span>
                                            <div>Assistant Registrar</div>
                                        </div>
                                    </div>
                                </div>
                                <div style="width: 50%;">
                                    <div class="col-md-6 text-left">
                                        <strong>Certified by:</strong>
                                        <div class="text-center mt-3">
                                            <span class="signature-line" style="text-decoration: underline;">Nashmia B. Abdullah</span>
                                            <div>Registrar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <p style="font-style: italic; font-weight: bold;">
                        NOT VALID WITHOUT SEAL
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>