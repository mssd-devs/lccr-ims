<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Certificate of Good Moral</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
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
                ?>
                <!-- Watermark logo -->
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1; opacity: 0.1; pointer-events: none;">
                    <img src="<?= $logo2 ?>" alt="Watermark" style="max-width: 500px; width: 500px;">
                </div>
                <tr>
                    <center>
                        <td><img src="<?= $logo1 ?>" alt="Logo 1" style="max-width: 100px;"></td>
                        <td>
                            <span><b><?= $school_name ?></b></span><br>
                            <span><?= $school_address ?></span><br>
                            <span>Tel. No. 064-200-6466 / Fax No. 064-477-0354</span><br>
                            <span><?= $school_email ?></span>
                        </td>
                        <td><img src="<?= $logo2 ?>" alt="Logo 2" style="max-width: 100px;"></td>
                    </center>
                </tr>
            </table>
            <hr>
            <h2 style="font-weight: bold; margin-bottom: -1.0em;">CERTIFICATE OF GOOD MORAL</h2>
        </div>
        <br>
        <div class="content" style="margin: 0 40px;">
            <?php
            foreach ($LoadStudentEnrolled->result() as $rows) {
            ?>

                <strong style="color: #000; font-family: Arial, Helvetica, sans-serif;">
                    <h3>To Whom It May Concern:</h3>
                </strong>

                <br>
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
                <b>THIS IS TO CERTIFY</b> that <b><?= htmlspecialchars($rows->SP_FIRSTNAME ?? '') . ' ' . htmlspecialchars($rows->SP_MIDDLENAME ?? '') . ' ' . htmlspecialchars($rows->SP_LASTNAME ?? '') ?></b> is a bonafide <b><?= htmlspecialchars($rows->ER_PROGRAM ?? '') ?>
                    <?php if (!empty($rows->ER_MAJOR)) {
                        echo ' major in ' . htmlspecialchars($rows->ER_MAJOR);
                    } ?> <?= htmlspecialchars($rows->ER_YEARLEVEL ?? '') ?></b> graduate of this institution School Year <b><?= htmlspecialchars($rows->ER_ACADEMICYEAR ?? '') . '-' . htmlspecialchars(($rows->ER_ACADEMICYEAR ?? 0) + 1) ?></b>.
            </p>

            <p style="font-size: 15px; color: #000; text-align: justify; line-height: 1.6; text-indent: 40px; position: relative; z-index: 1;">
                According to the records on file of this Office, He/she was never found guilty of
                violating the law or any school rules and regulations or subjected to any
                disciplinary action due to said violations or any form of misbehavior. He/she was
                known as a cooperative and conscientious student who possess good moral
                character.
            </p>
            <p style="font-size: 15px; color: #000; text-align: justify; line-height: 1.6; text-indent: 40px; position: relative; z-index: 1;">
                This certification is issued upon the request of the above-mentioned for
                <b>Employment</b> purposes only.
            </p>

            <p style="font-size: 15px; color: #000; text-align: justify; line-height: 1.6; text-indent: 40px; position: relative; z-index: 1;">
                <?php
                $today = new DateTime();
                $day = $today->format('j');
                // Add ordinal suffix
                function ordinal($number)
                {
                    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
                    if ((($number % 100) >= 11) && (($number % 100) <= 13))
                        return $number . 'th';
                    else
                        return $number . $ends[$number % 10];
                }
                $dayWithSuffix = ordinal($day);
                $month = $today->format('F');
                $year = $today->format('Y');
                ?>
                Given this <?= $dayWithSuffix ?> day of <?= $month ?>, <?= $year ?> at <b>VMC Asian College Foundation, Inc –
                    Kauran Branch,</b> Purok 2, Kauran, Ampatuan, Maguindanao Del Sur.

            </p>
            <br>
            <div class="row">
                <div style="padding: 10px; font-family: Arial, Helvetica, sans-serif; position: relative; z-index: 1;">
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
                                    <span class="signature-line"><strong>CHERYL A. MALACAD, MBA</strong></span>
                                    <div>School Registrar</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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