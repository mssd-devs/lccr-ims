<!DOCTYPE html>
<html>

<head>
    <title>Receipt Print</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 14px;
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

            .receipt:last-child {
                border-bottom: none;
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
            /* margin: 0 auto; */
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

<body>

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

        <h2>S T U D E N T <span> </span> G R A D E S</h2>
    </div>
    <div class="content">
        <?php
        foreach ($LoadStudentEnrolled->result() as $rows) {
        ?>
            <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">OR/Transaction No. </span><small style="text-decoration: underline; font-weight: 600;"><?= $this->uri->segment(5); ?></small><br><br>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                    <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                    <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                </tr>
                <tr>
                    <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                    <td><strong>Type :</strong> <?= ucfirst(strtolower($rows->ER_STATUS)); ?></td>
                    <td><strong>Status :</strong> <?= ucfirst(strtolower($rows->ER_CLASSIFICATION)); ?></td>
                </tr>
                <tr>
                    <td><strong>Name :</strong> <?= $rows->SP_LASTNAME . ', ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                    <td><strong>Sex :</strong> <?= ucfirst(strtolower($rows->SP_GENDER)); ?></td>
                    <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?><?= !empty($rows->ER_MAJOR) ? ' (' . $rows->ER_MAJOR . ')' : ''; ?></td>
                </tr>
            </table>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th>Course No.</th>
                    <th>Descriptive Title</th>
                    <th>Units</th>
                    <th>Grades</th>
                    <th>Remarks</th>
                </tr>


            </table>
        <?php
        }
        ?>

    </div>


    <div class="separator"></div>


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

        <h2>S T U D E N T <span> </span> G R A D E S</h2>
    </div>
    <div class="content">
        <?php
        foreach ($LoadStudentEnrolled->result() as $rows) {
        ?>
            <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">OR/Transaction No. </span><small style="text-decoration: underline; font-weight: 600;"><?= $this->uri->segment(5); ?></small><br><br>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                    <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                    <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                </tr>
                <tr>
                    <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                    <td><strong>Type :</strong> <?= ucfirst(strtolower($rows->ER_STATUS)); ?></td>
                    <td><strong>Status :</strong> <?= ucfirst(strtolower($rows->ER_CLASSIFICATION)); ?></td>
                </tr>
                <tr>
                    <td><strong>Name :</strong> <?= $rows->SP_LASTNAME . ', ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                    <td><strong>Sex :</strong> <?= ucfirst(strtolower($rows->SP_GENDER)); ?></td>
                    <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?><?= !empty($rows->ER_MAJOR) ? ' (' . $rows->ER_MAJOR . ')' : ''; ?></td>
                </tr>
            </table>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th>Course No.</th>
                    <th>Descriptive Title</th>
                    <th>Units</th>
                    <th>Grades</th>
                    <th>Remarks</th>
                </tr>

            </table>
        <?php
        }
        ?>

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