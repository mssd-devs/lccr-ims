<?php
// Define the 29 evaluation questions
$question_labels = [
    1 => "Possesses deep knowledge of the subject matter",
    2 => "Organizes and structures lectures logically",
    3 => "Explains complex concepts clearly with practical examples",
    4 => "Encourages student participation and questions",
    5 => "Uses modern teaching aids and technology effectively",
    6 => "Starts and ends classes on schedule",
    7 => "Displays enthusiasm and passion for teaching",
    8 => "Maintains professional classroom decorum",
    9 => "Provides clear course syllabus and grading criteria",
    10 => "Evaluates student performance fairly and objectively",
    11 => "Gives timely feedback on exams and assignments",
    12 => "Is accessible to students during consult hours",
    13 => "Shows respect for diverse student backgrounds",
    14 => "Communicates course objectives and expectations clearly",
    15 => "Aligns assignments and exams with course material",
    16 => "Inspires students to think critically and independently",
    17 => "Fosters a supportive and inclusive learning environment",
    18 => "Exhibits leadership and mentoring qualities",
    19 => "Listens actively to student concerns and feedback",
    20 => "Adapts teaching pace to student understanding",
    21 => "Demonstrates patience and approachability",
    22 => "Promotes collaborative learning and teamwork",
    23 => "Encourages ethical conduct and personal integrity",
    24 => "Shows interest in students' academic progress",
    25 => "Helps students connect topics to real-world applications",
    26 => "Displays commitment to students' holistic development",
    27 => "Handles classroom conflicts constructively",
    28 => "Exhibits overall professionalism and character",
    29 => "Leaves a positive and lasting impact on students"
];
?>

<style>
    /* Print Layout Overrides */
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
            color: black !important;
            padding: 0;
            margin: 0;
        }

        /* Prevent page breaks inside tables and cards */
        tr,
        .card-section {
            page-break-inside: avoid !important;
        }
    }

    /* Screen Styles */
    .print-area {
        background: white;
        color: #333;
        font-family: 'Arial', sans-serif;
        padding: 30px;
        max-width: 900px;
        margin: 20px auto;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .report-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 3px double #333;
        padding-bottom: 10px;
    }

    .report-header h2 {
        margin: 0 0 5px 0;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .report-header h4 {
        margin: 0 0 5px 0;
        color: #555;
        font-weight: normal;
    }

    .report-header h3 {
        margin: 15px 0 0 0;
        font-weight: bold;
        text-decoration: underline;
        font-size: 1.3rem;
    }

    .meta-table,
    .summary-table,
    .breakdown-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .meta-table td {
        padding: 6px 12px;
        vertical-align: top;
        font-size: 14px;
    }

    .meta-label {
        font-weight: bold;
        width: 20%;
    }

    .meta-value {
        border-bottom: 1px solid #ddd;
    }

    .section-title {
        font-size: 15px;
        font-weight: bold;
        background-color: #f2f2f2;
        padding: 6px 10px;
        margin-top: 25px;
        margin-bottom: 12px;
        border-left: 4px solid #333;
        text-transform: uppercase;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .summary-table th,
    .summary-table td,
    .breakdown-table th,
    .breakdown-table td {
        border: 1px solid #333;
        padding: 8px;
        font-size: 13px;
    }

    .summary-table th,
    .breakdown-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .text-center {
        text-align: center !important;
    }

    .text-bold {
        font-weight: bold;
    }

    .score-badge {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }

    .feedback-box {
        border: 1px solid #ccc;
        padding: 12px;
        margin-bottom: 15px;
        background-color: #fafafa;
        border-radius: 4px;
    }

    .feedback-box h6 {
        margin: 0 0 6px 0;
        font-weight: bold;
        font-size: 13px;
        color: #444;
    }

    .feedback-box p {
        margin: 0;
        font-size: 13px;
        line-height: 1.4;
    }

    .signature-row {
        margin-top: 60px;
        display: flex;
        justify-content: space-between;
    }

    .signature-col {
        width: 28%;
        text-align: center;
        font-size: 13px;
    }

    .signature-line {
        border-top: 1px solid #333;
        margin-top: 45px;
        padding-top: 5px;
        font-weight: bold;
    }

    .no-print-btn-container {
        max-width: 900px;
        margin: 20px auto 0 auto;
        text-align: right;
    }
</style>

<!-- Manual Print Button for Screen View -->
<div class="no-print-btn-container class-no-print">
    <button onclick="window.print();" class="btn btn-primary"><i class="ri-printer-line me-1"></i> Print Report</button>
</div>

<div class="print-area">
    <!-- Header -->
    <div class="report-header">
        <h2>LANAO CENTRAL COLLEGE</h2>
        <h4>Office of Academic Affairs & Quality Assurance</h4>
        <h4>Marawi City, Lanao del Sur</h4>
        <h3>FACULTY EVALUATION SUMMARY REPORT</h3>
    </div>

    <!-- Metadata Grid -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Faculty Member:</td>
            <td class="meta-value text-bold"><?= htmlspecialchars($evaluation->instructor_name) ?></td>
            <td class="meta-label">Academic Period:</td>
            <td class="meta-value"><?= htmlspecialchars($evaluation->academic_period) ?></td>
        </tr>
        <tr>
            <td class="meta-label">Course / Title:</td>
            <td class="meta-value"><?= htmlspecialchars($evaluation->course_title) ?></td>
            <td class="meta-label">Class Schedule:</td>
            <td class="meta-value"><?= htmlspecialchars($evaluation->class_schedule) ?></td>
        </tr>
        <tr>
            <td class="meta-label">Date Generated:</td>
            <td class="meta-value"><?= date('F d, Y') ?></td>
            <td class="meta-label">Status:</td>
            <td class="meta-value text-bold text-success"><?= !empty($evaluation->STATUS) ? htmlspecialchars($evaluation->STATUS) : 'EVALUATED' ?></td>
        </tr>
    </table>

    <!-- Ratings Summary -->
    <div class="section-title">Ratings Summary</div>
    <table class="summary-table">
        <thead>
            <tr>
                <th style="width: 40%;">Evaluation Category</th>
                <th style="width: 30%;" class="text-center">Average Score (1.00 - 5.00)</th>
                <th style="width: 30%;" class="text-center">Qualitative Adjective</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Explicit Criteria</strong> (Instructional Competence)</td>
                <td class="text-center text-bold"><?= number_format($explicit_avg, 2) ?> / 5.00</td>
                <td class="text-center"><?= $explicit_qualitative['label'] ?></td>
            </tr>
            <tr>
                <td><strong>Implicit Criteria</strong> (Interpersonal & Values)</td>
                <td class="text-center text-bold"><?= number_format($implicit_avg, 2) ?> / 5.00</td>
                <td class="text-center"><?= $implicit_qualitative['label'] ?></td>
            </tr>
            <tr style="border-top: 2px solid #333; background-color: #f9f9f9; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;">
                <td><strong>OVERALL RATING</strong></td>
                <td class="text-center text-bold" style="font-size: 15px;"><?= number_format($overall_avg, 2) ?> / 5.00</td>
                <td class="text-center text-bold" style="font-size: 14px;"><?= $overall_qualitative['label'] ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Detailed Question Breakdown -->
    <div class="section-title">Detailed Question-by-Question Rating</div>
    <div style="display: flex; justify-content: space-between; gap: 15px;">
        <!-- Left Side: Explicit Q1 - Q15 -->
        <table class="breakdown-table" style="width: 49%; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 15%;" class="text-center">Q#</th>
                    <th style="width: 70%;">Explicit Criteria (Q1-15)</th>
                    <th style="width: 15%;" class="text-center">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 15; $i++) {
                    $field = 'explicit_' . $i;
                    $score = $evaluation->$field ?? 0;
                ?>
                    <tr>
                        <td class="text-center text-bold">Q<?= $i ?></td>
                        <td style="font-size: 11px; line-height: 1.2; word-wrap: break-word;" class="text-wrap"><?= $question_labels[$i] ?></td>
                        <td class="text-center text-bold"><?= $score ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Right Side: Implicit Q16 - Q29 -->
        <table class="breakdown-table" style="width: 49%; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 15%;" class="text-center">Q#</th>
                    <th style="width: 70%;">Implicit Criteria (Q16-29)</th>
                    <th style="width: 15%;" class="text-center">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 16; $i <= 29; $i++) {
                    $field = 'implicit_' . $i;
                    $score = $evaluation->$field ?? 0;
                ?>
                    <tr>
                        <td class="text-center text-bold">Q<?= $i ?></td>
                        <td style="font-size: 11px; line-height: 1.2; word-wrap: break-word;" class="text-wrap"><?= $question_labels[$i] ?></td>
                        <td class="text-center text-bold"><?= $score ?></td>
                    </tr>
                <?php } ?>
                <!-- Empty row to balance table heights -->
                <tr>
                    <td class="text-center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Qualitative Feedback -->
    <div class="section-title">Qualitative Feedback & Remarks</div>

    <div class="feedback-box">
        <h6>Primary Strengths:</h6>
        <p><?= !empty($evaluation->teacher_strength) ? nl2br(htmlspecialchars($evaluation->teacher_strength)) : 'No strengths feedback specified.' ?></p>
    </div>

    <div class="feedback-box">
        <h6>Areas Recommended for Improvement:</h6>
        <p><?= !empty($evaluation->teacher_improvement) ? nl2br(htmlspecialchars($evaluation->teacher_improvement)) : 'No improvements feedback specified.' ?></p>
    </div>

    <div class="feedback-box">
        <h6>Specific Remarks on Explicit Criteria:</h6>
        <p><?= !empty($evaluation->explicit_reason) ? nl2br(htmlspecialchars($evaluation->explicit_reason)) : 'No additional justifications provided.' ?></p>
    </div>

    <div class="feedback-box">
        <h6>Specific Remarks on Implicit Criteria:</h6>
        <p><?= !empty($evaluation->implicit_reason) ? nl2br(htmlspecialchars($evaluation->implicit_reason)) : 'No additional justifications provided.' ?></p>
    </div>

    <!-- Signatures -->
    <div class="signature-row">
        <div class="signature-col">
            <div class="signature-line">Evaluated By (Student/Observer)</div>
        </div>
        <div class="signature-col">
            <div class="signature-line">Noted By: Dean of Academic Affairs</div>
        </div>
        <div class="signature-col">
            <div class="signature-line">Received By: Faculty Member</div>
        </div>
    </div>
</div>

<!-- Auto-print script -->
<script>
    $(window).on('load', function() {
        // Delay print slightly to ensure DOM & assets are fully ready
        setTimeout(function() {
            window.print();
        }, 300);
    });
</script>