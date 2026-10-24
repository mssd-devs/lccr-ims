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
            chart_billing_breakdown();
            fee_collection_program();
            recent_transactions();
            loadVoucherBreakdown();
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
                url: "<?= base_url('FinDasController/FilterDashboardHeader') ?>",
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

                    let billed = parse(result.output.total_amount_billed);
                    let paid = parse(result.output.total_payments_received);
                    let total_discount_voucher = parse(result.output.total_discount_voucher);
                    let balance = billed - (paid + total_discount_voucher);
                    let paid_students = parse(result.output.total_paid_students);
                    let balance_students = result.output.total_with_balance_students

                    $("#total-amount-billed").text(format(billed));
                    $("#total-payments-received").text(format(paid));
                    $("#total-outstanding-balances").text(format(balance));
                    $("#total-discount-payment").text(format(total_discount_voucher));
                    $("#number-fully-paid-students").text(paid_students);
                    $("#number-students-with-balance").text(balance_students);
                },
                error: function(jqXHR, errorType, error) {
                    alert('An error occurred while loading dashboard data.');
                    console.error(errorType, error);
                }
            });
        }



        function chart_billing_breakdown() {
            $.ajax({
                url: "<?= base_url('FinDasController/chart_billing_breakdown') ?>",
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
                    if (window.billingChart instanceof ApexCharts) {
                        window.billingChart.destroy();
                    }

                    // Prepare and render chart
                    const options = {
                        series: [
                            parseInt(data.total_paid_students) || 0,
                            parseInt(data.total_installment_students) || 0,
                            parseInt(data.total_unpaid_students) || 0
                        ],
                        chart: {
                            width: 380,
                            type: 'pie'
                        },
                        labels: ['Fully Paid', 'Partially Paid', 'Unpaid'],

                        colors: ['#28a745', '#ffc107', '#dc3545'], // Bootstrap: Green, Yellow, Red
                        legend: {
                            labels: {
                                colors: legendColor,
                                useSeriesColors: false
                            },
                        },

                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    const chart = new ApexCharts(document.querySelector("#billing_breakdown_chart"),
                        options);
                    chart.render();

                    // Save chart globally for reuse
                    window.billingChart = chart;
                },
                error: function() {
                    alert("Failed to load billing breakdown chart.");
                }
            });
        }



        function fee_collection_program() {
            $.ajax({
                url: "<?= base_url('FinDasController/fee_collection_program') ?>",
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
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    $("#fee_collection_program").html(response.output);
                },
                error: function() {
                    alert("Failed to load.");
                }
            });
        }


        function recent_transactions() {
            $.ajax({
                url: "<?= base_url('FinDasController/recent_transactions') ?>",
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
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    $('#recent_transactions_table').DataTable().clear().destroy();
                    $("#recent_transactions").html(response.output);
                    reinitializeRecentTransactionsTable();
                },
                error: function() {
                    alert("Failed to load.");
                }
            });
        }

        function reinitializeRecentTransactionsTable() {
            if ($('#recent_transactions_table').length) {
                $('#recent_transactions_table').DataTable({
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
                    order: [0, 'desc'],
                    pageLength: 3,
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
            }
        }


        function loadVoucherBreakdown() {
            $.ajax({
                url: "<?= base_url('FinDasController/chart_voucher_breakdown'); ?>",
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
                    const categories = [];
                    const studentCounts = [];
                    const totalDiscounts = [];
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);
                    $.each(response.output, function(i, row) {
                        categories.push(row.D_DESC);
                        studentCounts.push(parseInt(row.total_student_availed));
                        totalDiscounts.push(parseFloat(row.total_discount));
                    });

                    const options = {
                        series: [{
                                name: "Students Availed",
                                type: 'column',
                                data: studentCounts
                            },
                            {
                                name: "Total Discount (₱)",
                                type: 'line',
                                data: totalDiscounts
                            }
                        ],
                        chart: {
                            height: 350,
                            type: 'line',
                            stacked: false
                        },
                        stroke: {
                            width: [0, 4]
                        },

                        dataLabels: {
                            enabled: true,
                            enabledOnSeries: [0, 1] // Only show data labels on the line
                        },
                        labels: categories,
                        xaxis: {
                            type: 'category'
                        },
                        yaxis: [{
                                title: {
                                    text: 'Students Availed',
                                }
                            },
                            {
                                opposite: true,
                                title: {
                                    text: 'Total Discount (₱)'
                                }
                            }
                        ],
                        legend: {
                            labels: {
                                colors: legendColor,
                                useSeriesColors: false
                            },
                        },
                        tooltip: {
                            shared: true,
                            intersect: false
                        }
                    };

                    $("#voucher_breakdown_chart").html('');
                    var chart = new ApexCharts(document.querySelector("#voucher_breakdown_chart"),
                        options);
                    chart.render();
                }
            });
        }
        FilterDashboardHeader();
        chart_billing_breakdown();
        fee_collection_program();
        recent_transactions();
        loadVoucherBreakdown();

    });
</script>