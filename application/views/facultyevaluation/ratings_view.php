<?php
// Define realistic labels for the 29 evaluation questions
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

// Helper to get initials for avatar
$words = explode(" ", $evaluation->instructor_name);
$initials = "";
foreach ($words as $w) {
    $initials .= strtoupper(substr($w, 0, 1));
}
$initials = substr($initials, 0, 2);
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('facultyevaluation') ?>">Faculty Evaluation</a>
                </li>
                <li class="breadcrumb-item active">Ratings Summary</li>
            </ol>
        </nav>
        <a href="<?= base_url('facultyevaluation') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="ri-arrow-left-line me-1"></i> Back to List
        </a>
    </div>

    <!-- Faculty Profile Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center gy-3">
                <div class="col-auto">
                    <div class="avatar avatar-xl d-flex align-items-center justify-content-center rounded-circle bg-label-primary" style="width: 80px; height: 80px;">
                        <span class="fs-2 fw-semibold text-primary"><?= $initials ?></span>
                    </div>
                </div>
                <div class="col">
                    <h3 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($evaluation->instructor_name) ?></h3>
                    <div class="d-flex flex-wrap gap-3 text-muted align-items-center">
                        <span><i class="ri-book-open-line me-1"></i> <?= htmlspecialchars($evaluation->course_title) ?></span>
                        <span><i class="ri-time-line me-1"></i> <?= htmlspecialchars($evaluation->class_schedule) ?></span>
                        <span><i class="ri-calendar-event-line me-1"></i> <?= htmlspecialchars($evaluation->academic_period) ?></span>
                        <span class="badge bg-label-success rounded-pill px-2.5 py-1">
                            <i class="ri-checkbox-circle-line me-1"></i> <?= !empty($evaluation->STATUS) ? htmlspecialchars($evaluation->STATUS) : 'EVALUATED' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ratings Dashboard Grid -->
    <div class="row g-4 mb-4">
        <!-- Overall Score (Radial Chart) -->
        <div class="col-lg-4 col-md-12">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Overall Rating</h5>
                    <span class="badge <?= $overall_qualitative['class'] ?>"><?= $overall_qualitative['label'] ?></span>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center position-relative">
                    <div id="overallRadialChart" style="min-height: 200px;"></div>
                    <div class="mt-2">
                        <h2 class="mb-0 fw-bold <?= $overall_qualitative['text_class'] ?>"><?= number_format($overall_avg, 2) ?> <span class="text-muted fs-6">/ 5.00</span></h2>
                        <p class="text-muted mb-0 small mt-1">Weighted average score of all 29 criteria questions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Explicit Criteria -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 fw-semibold text-dark">Explicit Criteria</h5>
                            <span class="badge <?= $explicit_qualitative['class'] ?>"><?= $explicit_qualitative['label'] ?></span>
                        </div>
                        <h3 class="fw-bold mb-1 <?= $explicit_qualitative['text_class'] ?>"><?= number_format($explicit_avg, 2) ?> <span class="text-muted fs-6">/ 5.00</span></h3>
                        <p class="text-muted small mb-4">Focuses on course organization, delivery, exams, syllabus compliance, and subject competence (Questions 1 - 15).</p>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progress score</span>
                            <span class="fw-semibold text-dark"><?= number_format(($explicit_avg / 5) * 100, 1) ?>%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= ($explicit_avg / 5) * 100 ?>%" aria-valuenow="<?= ($explicit_avg / 5) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Implicit Criteria -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 fw-semibold text-dark">Implicit Criteria</h5>
                            <span class="badge <?= $implicit_qualitative['class'] ?>"><?= $implicit_qualitative['label'] ?></span>
                        </div>
                        <h3 class="fw-bold mb-1 <?= $implicit_qualitative['text_class'] ?>"><?= number_format($implicit_avg, 2) ?> <span class="text-muted fs-6">/ 5.00</span></h3>
                        <p class="text-muted small mb-4">Focuses on interpersonal support, patient communication, mentorship, approachability, and character values (Questions 16 - 29).</p>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progress score</span>
                            <span class="fw-semibold text-dark"><?= number_format(($implicit_avg / 5) * 100, 1) ?>%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= ($implicit_avg / 5) * 100 ?>%" aria-valuenow="<?= ($implicit_avg / 5) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution Chart -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header pb-0">
            <h5 class="card-title fw-semibold mb-1 text-dark">Ratings Profile by Question</h5>
            <p class="text-muted mb-0 small">Visual mapping of scores across all 29 individual criteria questions (Explicit 1-15 & Implicit 16-29)</p>
        </div>
        <div class="card-body">
            <div id="ratingsProfileChart" style="height: 350px;"></div>
        </div>
    </div>

    <!-- Tabs for Details Breakdown and Written Feedback -->
    <div class="card border-0 shadow-sm">
        <div class="card-header p-0">
            <div class="nav-align-top">
                <ul class="nav nav-tabs border-bottom" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active py-3 px-4 fw-semibold" role="tab" data-bs-toggle="tab" data-bs-target="#nav-breakdown" aria-controls="nav-breakdown" aria-selected="true">
                            <i class="ri-list-check-2 me-1"></i> Detailed Breakdown
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link py-3 px-4 fw-semibold" role="tab" data-bs-toggle="tab" data-bs-target="#nav-feedback" aria-controls="nav-feedback" aria-selected="false">
                            <i class="ri-chat-quote-line me-1"></i> Written Comments & Feedback
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body pt-4">
            <div class="tab-content p-0 m-0 border-0 shadow-none">
                <!-- Tab 1: Detailed Breakdown Table -->
                <div class="tab-pane fade show active" id="nav-breakdown" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">No</th>
                                    <th>Criteria Description</th>
                                    <th style="width: 150px;">Category</th>
                                    <th style="width: 100px; text-align: center;">Score</th>
                                    <th style="width: 250px;">Visual Meter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $badge_scale = function ($val) {
                                    if ($val >= 4.5) return 'bg-success';
                                    if ($val >= 3.5) return 'bg-primary';
                                    if ($val >= 2.5) return 'bg-info';
                                    if ($val >= 1.5) return 'bg-warning';
                                    return 'bg-danger';
                                };

                                for ($i = 1; $i <= 29; $i++) {
                                    $field = ($i <= 15) ? 'explicit_' . $i : 'implicit_' . $i;
                                    $score = $evaluation->$field ?? 0;
                                    $category = ($i <= 15) ? 'Explicit' : 'Implicit';
                                    $category_badge = ($i <= 15) ? 'bg-label-primary' : 'bg-label-info';
                                    $pct = ($score / 5) * 100;
                                    $color_class = $badge_scale($score);
                                ?>
                                    <tr>
                                        <td><strong>Q<?= $i ?></strong></td>
                                        <td class="text-wrap text-dark"><?= $question_labels[$i] ?></td>
                                        <td><span class="badge <?= $category_badge ?>"><?= $category ?></span></td>
                                        <td align="center"><span class="badge <?= $color_class ?> px-2.5 py-1.5 fs-6"><?= $score ?></span></td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar <?= $color_class ?>" role="progressbar" style="width: <?= $pct ?>%" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 2: Written Feedback & Comments -->
                <div class="tab-pane fade" id="nav-feedback" role="tabpanel">
                    <div class="row g-4">
                        <!-- Left column: Strengths & Improvements -->
                        <div class="col-md-6">
                            <div class="card border border-success h-100 shadow-none">
                                <div class="card-header bg-label-success d-flex align-items-center">
                                    <h6 class="mb-0 text-success fw-bold"><i class="ri-medal-line me-1"></i> Teacher's Primary Strengths</h6>
                                </div>
                                <div class="card-body pt-3">
                                    <blockquote class="blockquote mb-0 fs-6 text-dark" style="border-left: 3px solid #71dd37; padding-left: 15px;">
                                        <p><?= !empty($evaluation->teacher_strength) ? nl2br(htmlspecialchars($evaluation->teacher_strength)) : '<em class="text-muted">No primary strength feedback provided.</em>' ?></p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border border-warning h-100 shadow-none">
                                <div class="card-header bg-label-warning d-flex align-items-center">
                                    <h6 class="mb-0 text-warning fw-bold"><i class="ri-lightbulb-line me-1"></i> Areas Recommended for Improvement</h6>
                                </div>
                                <div class="card-body pt-3">
                                    <blockquote class="blockquote mb-0 fs-6 text-dark" style="border-left: 3px solid #ffab00; padding-left: 15px;">
                                        <p><?= !empty($evaluation->teacher_improvement) ? nl2br(htmlspecialchars($evaluation->teacher_improvement)) : '<em class="text-muted">No improvement feedback provided.</em>' ?></p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>

                        <!-- Full-width rows: Justifications -->
                        <div class="col-12 mt-4">
                            <div class="card border shadow-none bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3 text-dark"><i class="ri-discuss-line me-1"></i> Justifications & Specific Comments</h6>

                                    <div class="mb-3 border-bottom pb-3">
                                        <label class="form-label fw-semibold text-muted text-uppercase mb-1" style="font-size: 11px;">On Explicit Criteria Ratings (Instructional Delivery)</label>
                                        <p class="text-dark mb-0 fs-6"><?= !empty($evaluation->explicit_reason) ? nl2br(htmlspecialchars($evaluation->explicit_reason)) : '<em class="text-muted">No additional comments provided for explicit ratings.</em>' ?></p>
                                    </div>

                                    <div>
                                        <label class="form-label fw-semibold text-muted text-uppercase mb-1" style="font-size: 11px;">On Implicit Criteria Ratings (Interpersonal & Values)</label>
                                        <p class="text-dark mb-0 fs-6"><?= !empty($evaluation->implicit_reason) ? nl2br(htmlspecialchars($evaluation->implicit_reason)) : '<em class="text-muted">No additional comments provided for implicit ratings.</em>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page level JS scripts -->
<script>
    $(window).on('load', function() {
        // -------------------------------------------------------------
        // 1. Initialize Overall Radial Chart
        // -------------------------------------------------------------
        var overallVal = <?= ($overall_avg / 5) * 100 ?>;
        var overallColor = '#696cff'; // Default purple
        if (<?= $overall_avg ?> >= 4.5) overallColor = '#71dd37'; // Green
        else if (<?= $overall_avg ?> >= 3.5) overallColor = '#696cff'; // Blue/purple
        else if (<?= $overall_avg ?> >= 2.5) overallColor = '#03c3ec'; // Info
        else if (<?= $overall_avg ?> >= 1.5) overallColor = '#ffab00'; // Warning
        else overallColor = '#ff3e1d'; // Danger

        var radialOptions = {
            chart: {
                height: 220,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    hollow: {
                        size: '70%',
                    },
                    track: {
                        background: '#e7e7e8',
                        strokeWidth: '97%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 10,
                            fontSize: '2rem',
                            fontWeight: '700',
                            color: '#566a7f',
                            formatter: function(val) {
                                return '<?= number_format($overall_avg, 2) ?>';
                            }
                        }
                    }
                }
            },
            fill: {
                colors: [overallColor]
            },
            stroke: {
                lineCap: 'round'
            },
            series: [overallVal]
        };

        var radialChart = new ApexCharts(document.querySelector("#overallRadialChart"), radialOptions);
        radialChart.render();

        // -------------------------------------------------------------
        // 2. Initialize Bar/Column Chart for all 29 Questions
        // -------------------------------------------------------------
        var explicitScores = [];
        var implicitScores = [];
        var xCategories = [];

        // Push Explicit scores (Q1 - Q15)
        <?php for ($i = 1; $i <= 15; $i++) {
            $field = 'explicit_' . $i;
            echo "explicitScores.push({x: 'Q$i', y: " . ($evaluation->$field ?? 0) . "});\n";
        } ?>

        // Push Implicit scores (Q16 - Q29)
        <?php for ($i = 16; $i <= 29; $i++) {
            $field = 'implicit_' . $i;
            echo "implicitScores.push({x: 'Q$i', y: " . ($evaluation->$field ?? 0) . "});\n";
        } ?>

        var barOptions = {
            series: [{
                    name: 'Explicit Criteria (Q1-Q15)',
                    data: explicitScores,
                    color: '#696cff' // purple
                },
                {
                    name: 'Implicit Criteria (Q16-Q29)',
                    data: implicitScores,
                    color: '#03c3ec' // cyan
                }
            ],
            chart: {
                type: 'bar',
                height: 330,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    borderRadius: 4
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [
                    <?php for ($i = 1; $i <= 29; $i++) echo "'Q$i',"; ?>
                ],
                labels: {
                    style: {
                        colors: '#a1acb8',
                        fontSize: '11px'
                    }
                }
            },
            yaxis: {
                min: 0,
                max: 5,
                tickAmount: 5,
                title: {
                    text: 'Rating Score (1 - 5)',
                    style: {
                        color: '#566a7f',
                        fontWeight: 500
                    }
                },
                labels: {
                    style: {
                        colors: '#a1acb8'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val, {
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        // Map index to full question text
                        var descriptions = <?= json_encode($question_labels) ?>;
                        var qNum = dataPointIndex + 1;
                        return "<strong>Score: " + val + " / 5</strong><br/><small style='display:inline-block;max-width:250px;white-space:normal;'>" + descriptions[qNum] + "</small>";
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                labels: {
                    colors: '#566a7f'
                }
            }
        };

        var barChart = new ApexCharts(document.querySelector("#ratingsProfileChart"), barOptions);
        barChart.render();
    });
</script>