<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Student Accounts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 22px;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .instructions {
            margin-top: 30px;
            font-size: 13px;
            color: #666;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }
        @media print {
            body { margin: 0; }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <?php if(isset($query) && $query->num_rows() > 0): 
            $web = $query->row();
        ?>
            <h2><?= $web->WEB_SCHOOLNAME ?? 'Institution Management System' ?></h2>
            <p><?= $web->WEB_ADDRESS ?? '' ?></p>
        <?php else: ?>
            <h2>Institution Management System</h2>
        <?php endif; ?>
        <br>
        <h3>Generated Student Portal Accounts</h3>
        <p>Date Generated: <?= date('F d, Y h:i A') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Student ID</th>
                <th style="width: 35%;">Full Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 20%;">Portal Password</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($accounts) && !empty($accounts)): ?>
                <?php $count = 1; foreach($accounts as $acc): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= htmlspecialchars($acc['SP_STUDID']) ?></td>
                        <td><?= htmlspecialchars($acc['FULL_NAME']) ?></td>
                        <td><?= htmlspecialchars($acc['SP_EMAIL']) ?></td>
                        <td style="font-family: monospace; font-size: 16px;"><strong><?= htmlspecialchars($acc['RAW_PASSWORD']) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">No new accounts were generated. (All enrolled students already have a password)</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="instructions">
        <strong>Note:</strong> These passwords have been automatically generated for enrolled students who previously did not have portal access. Passwords are case-sensitive. Please distribute these credentials to the respective students securely.
    </div>
</body>
</html>
