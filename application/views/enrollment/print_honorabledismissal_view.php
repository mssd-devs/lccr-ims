<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Certificate of Honorable Dismissal</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
        }

        .separator {
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 2px dashed #000;
            padding: 10px 0;
            width: 100%;
            box-sizing: border-box;
            page-break-inside: avoid;
            margin-bottom: 30px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            /* margin: 0 auto; */
            margin-top: 0;
            position: relative;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 0px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            font-size: smaller;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid black;
        }

        p {
            font-size: 11px;
        }

        .content th,
        .content td {
            padding: 3px;
            text-align: left;
            font-size: 12px;
            font-weight: 100;
        }
    </style>
</head>
<script>
    document.documentElement.setAttribute("data-date", new Date().toLocaleDateString());
    document.documentElement.setAttribute("data-time", new Date().toLocaleTimeString());
</script>

<body>

    <div class="container">
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
                $sig_row = $this->db->get("tbl_signatories")->row();
                $sig_reg = ($sig_row && !empty($sig_row->SIG_REG)) ? $sig_row->SIG_REG : 'School Registrar';
                ?>
                <!-- Watermark logo -->
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1; opacity: 0.1; pointer-events: none;">
                    <img src="<?= $logo2 ?>" alt="Watermark" style="max-width: 500px; width: 500px;">
                </div>
                <tr>
                    <center>
                        <td><img src="<?= $logo1 ?>" alt="Logo 1" style="max-width: 100px;"></td>
                        <td>
                            <span><b>Republic of the Philippines</b></span><br>
                            <span>Bangsamoro Autonomous Region in Muslim Mindanao</span><br>
                            <span>Ministry of Basic, Higher and Technical Education</span><br>
                            <span><b><?= $school_name ?></b></span><br>
                            <small><?= $school_address ?></small><br>
                            <span>Reg. Sec No. CN 200431360 / TIN No. 630-176-362-00000</span>
                        </td>
                        <td><img src="<?= $logo2 ?>" alt="Logo 2" style="max-width: 100px;"></td>
                    </center>
                </tr>
            </table>
            <hr>
            <h2 style="font-weight: bold; margin-bottom: -1.0em;">Office of the Registrar</h2>
            <br>
            <br>
            <h2 style="font-weight: bold; margin-bottom: -1.0em;">CERTIFICATE OF HONORABLE DISMISSAL</h2>
        </div>
        <br>
        <div class="row">
            <div style="padding: 10px; font-family: 'Times New Roman', Times, serif; position: relative; z-index: 1;">
                <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                    <div style="width: 75%;">
                        <div class="col-md-6 text-left">

                        </div>
                    </div>
                    <div style="width: 25%;">
                        <div class="col-md-6 text-left">
                            <!-- <strong>Prepared by:</strong> -->
                            <div class="text-center mt-3" style="text-align: center;">
                                <span class="signature-line"><strong>___________________</strong></span>
                                <div>Date</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content" style="margin: 0 40px;">
            <?php
            foreach ($LoadStudentEnrolled->result() as $rows) {
            ?>
                <p style="font-size: 15px;">To Whom It May Concern:</p>

            <?php
            }
            ?>
        </div>
        <div class="footer" style="margin: 0 40px; position: relative;">
            <?php
            // Determine prefix based on gender
            $prefix = '';
            if (isset($rows->SP_GENDER)) {
                if ($rows->SP_GENDER === 'MALE') {
                    $prefix = 'MR.';
                } elseif ($rows->SP_GENDER === 'FEMALE') {
                    $prefix = 'MS.';
                }
            }
            ?>
            <p style="font-size: 15px; color: #000; text-align: justify; line-height: 1.6; text-indent: 40px; position: relative; z-index: 1;">
                This is to certify that <b><?= htmlspecialchars($rows->SP_LASTNAME ?? '') . ', ' . htmlspecialchars($rows->SP_FIRSTNAME ?? '') . ' ' . htmlspecialchars($rows->SP_MIDDLENAME ?? '') ?></b> has been enrolled in this school under the Department of _____________________ in the year <b><?= htmlspecialchars($rows->ER_ACADEMICYEAR ?? '') ?></b>.
            </p>

            <p style="font-size: 15px; color: #000; text-align: justify; line-height: 1.6; text-indent: 40px; position: relative; z-index: 1;">
                He/She is hereby granted TRANSFER CREDENTIAL effective today and that his/her Official Transcript of Records and other scholastic credentials may be released only upon receipt of the other half of this certificate of dismissal.
            </p>
            <br>
            <div class="row">
                <div style="padding: 10px; font-family: 'Times New Roman', Times, serif; position: relative; z-index: 1;">
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div style="width: 50%;">
                            <div class="col-md-6 text-left">
                                <!-- <strong>Prepared by:</strong>
                <div class="text-center mt-3">
                    <span class="signature-line"><strong>HANIA M. SULTAN</strong></span>
                    <div>School Registrar</div>
                </div> -->
                            </div>
                        </div>
                        <div style="width: 50%;">
                            <div class="col-md-6 text-left">
                                <!-- <strong>Prepared by:</strong> -->
                                <div class="text-center mt-3">
                                    <span class="signature-line"><strong><?= htmlspecialchars($sig_reg ?? '') ?></strong></span>
                                    <div>School Registrar</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="separator"></div>
            <p style="font-weight: bold; text-align: left; font-size: 10px; position: relative; z-index: 1;">
                REQUEST SLIP
            </p>
            <div class="row">
                <div style="padding: 10px; font-family: 'Times New Roman', Times, serif; position: relative; z-index: 1;">
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div style="width: 75%;">
                            <div class="col-md-6 text-left">

                            </div>
                        </div>
                        <div style="width: 25%;">
                            <div class="col-md-6 text-left">
                                <!-- <strong>Prepared by:</strong> -->
                                <div class="text-center mt-3" style="text-align: center;">
                                    <span class="signature-line"><strong>___________________</strong></span>
                                    <div>Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; width: 100%">
                <p>______________________________________________________________
                    <br>(Name of School)
                </p>
                <p>______________________________________________________________
                    <br>(Address)
                </p>
            </div>
            <div style="text-align: left;">
                <p>THE REGISTRAR <br>
                    Lanao College of Criminology, Inc. <br>
                    Masiu Lanao Del Sur
                </p>
                <p>Sir/Madam:</p>
                <p>On the basis of the TRANSFER CREDENTIAL issued to <b><?= htmlspecialchars($rows->SP_LASTNAME ?? '') . ', ' . htmlspecialchars($rows->SP_FIRSTNAME ?? '') . ' ' . htmlspecialchars($rows->SP_MIDDLENAME ?? '') ?></b>
                    Kindly furnish us his/her Official Transcript of Record and other scholastic credentials. </p>
            </div>
            <br>
            <br>
            <br>
            <p style="font-style: italic; font-weight: bold; text-align: left; font-size: 10px; position: relative; z-index: 1;">
                Not valid without dry seal
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            document.body.style.margin = "0";
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>


</body>

</html>