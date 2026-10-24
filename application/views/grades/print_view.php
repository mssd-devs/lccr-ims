<style>
    @media print {
        @media print {
            body * {
                visibility: hidden !important;
            }

            .print-area,
            .print-area * {
                visibility: visible !important;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
            }

            /* Optional: remove margins for cleaner layout */
            body {
                margin: 0;
                padding: 0;
                background: none !important;
            }

            /* Hide pseudo-element background watermark */
            :root::after {
                display: none !important;
            }
        }
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
    }

    .receipt {
        width: 100%;
        height: 50vh;
        border-bottom: 1px dashed #000;
        padding: 20px;
        box-sizing: border-box;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
    }

    .line {
        margin: 5px 0;
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin-top: 0;
    }

    .header,
    .footer {
        text-align: center;
        margin-bottom: 5px;
    }

    .content {
        margin-bottom: 10px;
    }

    .content table {
        width: 100%;
        border-collapse: collapse !important;
        font-size: smaller;
        border: 1px solid black !important;
        table-layout: fixed;
    }

    .content th,
    .content td {
        border: 1px solid black !important;
        padding: 4px;
        text-align: left;
        font-size: 12px;
        font-weight: 100;
        background: none !important;
        /* removes gray lines from invisible backgrounds */
        color: black !important;
    }

    .content thead tr {
        background-color: #f9f9f9 !important;
        -webkit-print-color-adjust: exact !important;
        /* makes sure background prints */
        print-color-adjust: exact !important;
    }

    .content tbody tr {
        background-color: #ffffff !important;
    }



    /* Comment this out or remove to stop background in print */
    /* :root::after {
        content: "This is a system generated copy - Date: " attr(data-date) " Time: " attr(data-time);
        bottom: 0px;
        font-size: 8px;
        transform: rotate(0deg);
        position: fixed;
        color: gray;
        background-repeat: repeat;
        z-index: -1;
    } */

    .signature-table,
    .signature-table table,
    .signature-table td,
    .signature-table tr {
        border: none !important;
        background: none !important;
    }
</style>

<div class="print-area">
    <div class="header">
        <table class="table" style="width: 100%;">
            <?php
            $query = $this->db->get("tbl_websettings");
            foreach ($query->result() as $row) {
                $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
                $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
                $school_name = $row->IMS_WEB_NOS;
                $school_address = $row->IMS_WEB_ADDRESS;
                $school_email = $row->IMS_WEB_EMAIL;
            }
            ?>
            <tr>
                <center>
                    <td><img src="<?= $logo1 ?>" alt="Logo 1" style="max-width: 100px;"></td>
                    <td>
                        <span><b><?= $school_name ?></b></span><br>

                        <small><?= $school_address ?></small> <br><small>Email: <?= strtolower($school_email) ?></small> |
                        <small> Contact No. <?= $row->IMS_WEB_CONTACT ?> </small><br>
                    </td>
                    <td><img src="<?= $logo2 ?>" alt="Logo 2" style="max-width: 100px;"></td>
                </center>
            </tr>
        </table>
        <h2>GRADES</h2>
    </div>
    <div class="content">
        <?php
        $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
        foreach ($query->result() as $rows) {
            if ($rows->ID == $this->uri->segment(4)) {
        ?>
                <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">Date Issued <?= date('Y-m-d') ?></span><br>
                <table class="table table-bordered table-sm w-100">
                    <tr>
                        <td colspan="3"><strong>Subject :</strong> <?= $rows->SC_SDESC; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Program :</strong> <?= $rows->SC_PROG; ?></td>
                        <td><strong>Major :</strong> <?= $rows->SC_MAJOR; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Academic Year :</strong> <?= $rows->SC_ACADEMICYEAR; ?></td>
                        <td><strong>Semester :</strong> <?= $rows->SC_SEMESTER; ?></td>
                        <td><strong>Year Level :</strong> <?= $rows->SC_YEARLEVEL; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Section :</strong> <?= $rows->SC_SECTION; ?></td>
                        <td><strong>Room :</strong> <?= $rows->SC_ROOM; ?></td>
                        <td><strong>Department :</strong> <?= $rows->SC_DEPT; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Time :</strong> <?= $rows->SC_STARTTIME . ' - ' . $rows->SC_ENDTIME; ?></td>
                        <td><strong>Day :</strong> <?= $rows->SC_DAY; ?></td>
                        <td><strong>Teaching Method :</strong> <?= $rows->SC_TEACHMODELS; ?></td>
                    </tr>
                </table>
                <div style="display:flex; gap:20px">
                    <div style="width: 100%;">
                        <table class="table table-bordered table-sm w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name of Students</th>
                                    <th>Gender</th>
                                    <th>Grades</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                // Filter enrollment by semester and section
                                $enrollments = $this->db
                                    ->where("ER_SEMESTER", $rows->SC_SEMESTER)
                                    ->where("ER_SECTION", $rows->SC_SECTION)
                                    ->get("tbl_enrollment")
                                    ->result();

                                foreach ($enrollments as $enroll) {
                                    $student = $this->db
                                        ->where("SP_STUDID", $enroll->ER_STUDENTID)
                                        ->get("tbl_studprof")
                                        ->row();

                                    if ($student) {
                                        // Fetch student grades specific to the subject
                                        $grades = $this->db
                                            ->where("G_STUDENTID", $enroll->ER_STUDENTID)
                                            ->where("G_SUBJECT", $rows->SC_SDESC) // <-- match specific subject
                                            ->get("tbl_studentgrades")
                                            ->result();

                                        foreach ($grades as $grade) {
                                ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $grade->G_FULLNAME; ?></td>
                                                <td><?= $student->SP_GENDER; ?></td>
                                                <td><?= $grade->G_GRADE; ?></td>
                                                <td><?= $grade->G_REMARKS; ?></td>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>

                            <tr>
                                <td colspan="5"><strong>Total Students:</strong> <?= $i - 1; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table style="width: 100%; margin-top: 10px; border: none;" class="signature-table">
                    <tr>
                        <td style="width: 65%;">
                            <strong>Prepared by:</strong>
                            <br><br><br>
                            <strong><?= $rows->SC_FACULTY; ?></strong>
                            <br>
                            ___________________________<br>
                        </td>
                        <td>
                            <strong>Approved by:</strong>
                            <br><br><br>
                            ___________________________<br>
                            <!-- <span style="font-size: 11px;">Signature</span> -->
                        </td>
                    </tr>
                </table>
        <?php
            }
        }
        ?>

    </div>
</div>




<script>
    window.addEventListener("load", function() {
        window.print();
    });

    window.addEventListener("afterprint", function() {
        window.close();
    });
</script>