<script>
    $(document).ready(function() {
        let cardColor, headingColor, labelColor, borderColor, legendColor;
        if (isDarkStyle) {
            cardColor = config.colors_dark.cardColor;
            headingColor = config.colors_dark.headingColor;
            labelColor = config.colors_dark.textMuted;
            legendColor = config.colors_dark.bodyColor;
            borderColor = config.colors_dark.borderColor;
        } else {
            cardColor = config.colors.cardColor;
            headingColor = config.colors.headingColor;
            labelColor = config.colors.textMuted;
            legendColor = config.colors.bodyColor;
            borderColor = config.colors.borderColor;
        }

        $("#FTR_AY, #FTR_SEM, #FTR_PROGRAM, #FTR_YL").on("change", function() {
            FilterDashboardHeader();
            chart_enrollment_by_sexandyearlevel();
            chart_pwd_statistics();
            chart_employee_status();
            chart_grades_performance();
            program_with_enrollment();
        });


        function FilterDashboardHeader() {
            const csrfName = $('.txt_csrfname').attr('name');
            const payload = {
                FTR_AY: $('#FTR_AY').val(),
                FTR_SEM: $('#FTR_SEM').val(),
                FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                FTR_YL: $('#FTR_YL').val(),

            };
            payload[csrfName] = $('.txt_csrfname').val(); // Add CSRF token

            $.ajax({
                url: "<?= base_url('DashboardController/FilterDashboardHeader') ?>",
                method: "POST",
                dataType: 'json',
                data: payload,
                success: function(result) {
                    // Update CSRF token
                    $('.txt_csrfname').val(result.token);

                    const parse = v => parseFloat((v || '0').replace(/,/g, ''));
                    const format = n => n.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    });

                    // Update the dashboard header with the result
                    let enrolled_male = result.output.total_enrolled_male
                    let enrolled_female = result.output.total_enrolled_female
                    let enrolled_students = result.output.total_enrolled_students
                    let enrolled_students_pending = result.output.total_enrolled_students_pending
                    let enrolled_students_active = result.output.total_enrolled_students_active
                    let total_student_profile = result.output.total_student_profile
                    let total_student_profile_saved = result.output.total_student_profle_saved
                    let total_student_profile_draft = result.output.total_student_profle_draft
                    let total_employee_profile = result.output.total_employee_profile
                    let total_employee_profile_teaching = result.output.total_employee_profile_teaching
                    let total_employee_profile_nonteaching = result.output.total_employee_profile_nonteaching
                    let total_programs = result.output.total_programs
                    let total_programs_active = result.output.total_programs_active
                    let total_programs_inactive = result.output.total_programs_inactive
                    let total_pwd_visual_impairment = result.output.total_pwd_visual_impairment
                    let total_pwd_hearing_loss = result.output.total_pwd_hearing_loss
                    let total_pwd_orthopedic_disability = result.output.total_pwd_orthopedic_disability
                    let total_pwd_learning_disability = result.output.total_pwd_learning_disability
                    let total_pwd_psychosocial_disability = result.output.total_pwd_psychosocial_disability
                    let total_pwd_mental_disability = result.output.total_pwd_mental_disability
                    let total_pwd_chronic_illness = result.output.total_pwd_chronic_illness

                    $("#number-enrolled-male").text(enrolled_male);
                    $("#number-enrolled-female").text(enrolled_female);
                    $("#number-enrolled-students").text(enrolled_students);
                    $("#number-enrolled-students-pending").text(enrolled_students_pending);
                    $("#number-enrolled-students-active").text(enrolled_students_active);
                    $("#number-student-profile").text(total_student_profile);
                    $("#number-student-profile-saved").text(total_student_profile_saved);
                    $("#number-student-profile-draft").text(total_student_profile_draft);
                    $("#number-employee-profile").text(total_employee_profile);
                    $("#number-employee-profile-teaching").text(total_employee_profile_teaching);
                    $("#number-employee-profile-nonteaching").text(total_employee_profile_nonteaching);
                    $("#number-programs").text(total_programs);
                    $("#number-programs-active").text(total_programs_active);
                    $("#number-programs-inactive").text(total_programs_inactive);
                    $("#number-visual-impairment").text(total_pwd_visual_impairment);
                    $("#number-hearing-loss").text(total_pwd_hearing_loss);
                    $("#number-orthopedic-disability").text(total_pwd_orthopedic_disability);
                    $("#number-learning-disability").text(total_pwd_learning_disability);
                    $("#number-psychosocial-disability").text(total_pwd_psychosocial_disability);
                    $("#number-mental-disability").text(total_pwd_mental_disability);
                    $("#number-chronic-illness").text(total_pwd_chronic_illness);
                },
                error: function(jqXHR, errorType, error) {
                    alert('An error occurred while loading dashboard data.');
                    console.error(errorType, error);
                }
            });
        }

        function program_with_enrollment() {
            $.ajax({
                url: "<?= base_url('DashboardController/program_with_enrollment') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    FTR_AY: $('#FTR_AY').val(),
                    FTR_SEM: $('#FTR_SEM').val(),
                    FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                    FTR_YL: $('#FTR_YL').val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(response) {
                    $('.txt_csrfname').val(response.token); // update token
                    $('#program_with_enrollment-table').DataTable().clear().destroy();
                    $("#program_with_enrollment").html(response.output);
                    $('#program_with_enrollment-table').DataTable(); // reinitialize
                },
                error: function() {
                    alert("Failed to load.");
                }
            });
        }

        function chart_enrollment_by_sexandyearlevel() {
            $.ajax({
                url: "<?= base_url('DashboardController/chart_enrollment_by_sexandyearlevel') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    FTR_AY: $('#FTR_AY').val(),
                    FTR_SEM: $('#FTR_SEM').val(),
                    FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                    FTR_YL: $('#FTR_YL').val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    const data = response.output;

                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Destroy previous chart if it exists
                    if (window.enrollmentChart instanceof ApexCharts) {
                        window.enrollmentChart.destroy();
                    }

                    // Prepare and render chart
                    const options = {
                        series: [{
                            name: 'Male',
                            data: [
                                parseInt(data.firstyear_male) || 0,
                                parseInt(data.secondyear_male) || 0,
                                parseInt(data.thirdyear_male) || 0,
                                parseInt(data.fourthyeart_male) || 0
                            ]
                        }, {
                            name: 'Female',
                            data: [
                                parseInt(data.firstyear_female) || 0,
                                parseInt(data.secondyear_female) || 0,
                                parseInt(data.thirdyear_female) || 0,
                                parseInt(data.fourthyeart_female) || 0
                            ]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: ['1st Year', '2nd Year', '3rd Year', '4th Year']
                        },
                        yaxis: {
                            title: {
                                text: 'Student Count'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "Total " + val;
                                }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#enrollment_chart"), options);
                    chart.render();

                    // Save chart globally for reuse
                    window.enrollmentChart = chart;
                },
                error: function() {
                    alert("Failed to load enrollment chart.");
                }
            });
        }

        function chart_grades_performance() {
            $.ajax({
                url: "<?= base_url('DashboardController/chart_grades_performance') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    FTR_AY: $('#FTR_AY').val(),
                    FTR_SEM: $('#FTR_SEM').val(),
                    FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                    FTR_YL: $('#FTR_YL').val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    const data = response.output;

                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Destroy previous chart if it exists
                    if (window.gradeperformanceChart instanceof ApexCharts) {
                        window.gradeperformanceChart.destroy();
                    }

                    // Prepare and render chart
                    const options = {
                        series: [{
                            name: 'Passed',
                            data: [
                                parseInt(data.totalfirstpassed) || 0,
                                parseInt(data.totalsecondpassed) || 0,
                                parseInt(data.totalthirdpassed) || 0,
                                parseInt(data.totalfourthpassed) || 0
                            ]
                        }, {
                            name: 'Failed',
                            data: [
                                parseInt(data.totalfirstfailed) || 0,
                                parseInt(data.totalsecondfailed) || 0,
                                parseInt(data.totalthirdfailed) || 0,
                                parseInt(data.totalfourthfailed) || 0
                            ]
                        }, {
                            name: 'Incomplete',
                            data: [
                                parseInt(data.totalfirstinc) || 0,
                                parseInt(data.totalsecondinc) || 0,
                                parseInt(data.totalthirdinc) || 0,
                                parseInt(data.totalfourthinc) || 0
                            ]
                        }, {
                            name: 'Drop out',
                            data: [
                                parseInt(data.totalfirstdrp) || 0,
                                parseInt(data.totalseconddrp) || 0,
                                parseInt(data.totalthirddrp) || 0,
                                parseInt(data.totalfourthdrp) || 0
                            ]
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: ['1st Year', '2nd Year', '3rd Year', '4th Year']
                        },
                        yaxis: {
                            title: {
                                text: ''
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "Total " + val;
                                }
                            }
                        }
                    };


                    const chart = new ApexCharts(document.querySelector("#grade_performance_chart"), options);
                    chart.render();

                    // Save chart globally for reuse
                    window.gradeperformanceChart = chart;
                },
                error: function() {
                    alert("Failed to load enrollment chart.");
                }
            });
        }

        function chart_pwd_statistics() {
            $.ajax({
                url: "<?= base_url('DashboardController/chart_pwd_statistics') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    FTR_AY: $('#FTR_AY').val(),
                    FTR_SEM: $('#FTR_SEM').val(),
                    FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                    FTR_YL: $('#FTR_YL').val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    const data = response.output;
                    const total_pwd_yes = parseInt(data.total_pwd_yes) || 0;
                    const total_pwd_no = parseInt(data.total_pwd_no) || 0;

                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Destroy previous chart if it exists
                    if (window.pwdChart instanceof ApexCharts) {
                        window.pwdChart.destroy();
                    }

                    // Prepare and render chart
                    const options = {
                        series: [total_pwd_yes, total_pwd_no],
                        chart: {
                            height: 400,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '22px',
                                    },
                                    value: {
                                        fontSize: '20px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function(w) {
                                            return total_pwd_yes + total_pwd_no;
                                        }
                                    }
                                }
                            }
                        },
                        labels: ['Yes', 'No'],
                        legend: {
                            show: true,
                            position: 'bottom',
                            labels: {
                                colors: ['#000']
                            }
                        }
                    };


                    const chart = new ApexCharts(document.querySelector("#pwd_statistic_chart"), options);
                    chart.render();

                    // Save chart globally for reuse
                    window.pwdChart = chart;
                },
                error: function() {
                    alert("Failed to load pwd statistics chart.");
                }
            });
        }

        function chart_employee_status() {
            $.ajax({
                url: "<?= base_url('DashboardController/chart_employee_status') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    FTR_AY: $('#FTR_AY').val(),
                    FTR_SEM: $('#FTR_SEM').val(),
                    FTR_PROGRAM: $('#FTR_PROGRAM').val(),
                    FTR_YL: $('#FTR_YL').val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    const data = response.output;
                    const total_teaching = parseInt(data.total_teaching) || 0;
                    const total_non_teaching = parseInt(data.total_non_teaching) || 0;

                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Destroy previous chart if it exists
                    if (window.employeestatusChart instanceof ApexCharts) {
                        window.employeestatusChart.destroy();
                    }

                    // Prepare and render chart
                    const options = {
                        series: [total_teaching, total_non_teaching],
                        chart: {
                            height: 400,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '22px',
                                    },
                                    value: {
                                        fontSize: '20px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function(w) {
                                            return total_teaching + total_non_teaching;
                                        }
                                    }
                                }
                            }
                        },
                        labels: ['Teaching', 'Non-Teaching'],
                        legend: {
                            show: true,
                            position: 'bottom',
                            labels: {
                                colors: ['#000']
                            }
                        }
                    };


                    const chart = new ApexCharts(document.querySelector("#employee_status_chart"), options);
                    chart.render();

                    // Save chart globally for reuse
                    window.employeestatusChart = chart;
                },
                error: function() {
                    alert("Failed to load employee status chart.");
                }
            });
        }

        function chart_enrollment_trends() {
            $.ajax({
                url: "<?= base_url('DashboardController/chart_enrollment_trends') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    const data = response.output;

                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Destroy previous chart if it exists
                    if (window.enrollmenttrendsChart instanceof ApexCharts) {
                        window.enrollmenttrendsChart.destroy();
                    }

                    const enrollmentData = [
                        parseInt(data.totalpreviousenroll4) || 0,
                        parseInt(data.totalpreviousenroll3) || 0,
                        parseInt(data.totalpreviousenroll2) || 0,
                        parseInt(data.totalpreviousenroll) || 0,
                        parseInt(data.totalcurrentenroll) || 0
                    ];

                    // Get current year
                    const currentYear = new Date().getFullYear();
                    const categories = [
                        (currentYear - 4) + '-' + (currentYear - 3),
                        (currentYear - 3) + '-' + (currentYear - 2),
                        (currentYear - 2) + '-' + (currentYear - 1),
                        (currentYear - 1) + '-' + currentYear,
                        currentYear + '-' + (currentYear + 1)
                    ];


                    // Prepare and render chart
                    const options = {
                        series: [{
                            name: "Enrolment",
                            data: enrollmentData
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        title: {
                            text: 'Trends by Academic Year',
                            align: 'left'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'],
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: categories
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return Math.round(value); // Ensures whole number labels
                                }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#enrollment_trends_chart"), options);
                    chart.render();

                    // Save chart globally for reuse
                    window.enrollmenttrendsChart = chart;
                },
                error: function() {
                    alert("Failed to load employee status chart.");
                }
            });
        }

        function updateAcademicYearBadge() {
            let ay = $('#FTR_AY').val();
            let text = ay ? ay + '-' + (parseInt(ay) + 1) : 'ALL';

            $('#display-academic-year-trans').text(text);
            $('#display-academic-year-grades').text(text);
            $('#display-academic-year-status').text(text);
            $('#display-academic-year-pwd').text(text);
            $('#display-academic-year-pwd2').text(text);
            $('#display-academic-year').text(text);
            $('#display-academic-year-female').text(text);
            $('#display-academic-year-male').text(text);
        }

        FilterDashboardHeader();
        chart_enrollment_by_sexandyearlevel();
        chart_pwd_statistics();
        chart_employee_status();
        chart_grades_performance();
        chart_enrollment_trends();
        program_with_enrollment();
        updateAcademicYearBadge();

        $('#FTR_AY').change(function() {
            updateAcademicYearBadge();
        });

    });
</script>