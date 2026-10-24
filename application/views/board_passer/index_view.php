<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Board Passer</a>
            </li>
            <li class="breadcrumb-item active">Views</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Board Passer</h5>
                    <small class="text-muted">List of board passers by program, year, and month.</small>
                </div>

                <a class="btn btn-primary btn-sm float-end d-inline-flex align-items-center"
                    href="<?= base_url('ims/boardpasser/create'); ?>" id="button-addon2">
                    <i class="ri-add-circle-line me-1"></i> Add Board Passer
                </a>
            </div>
            <div class="card-body">
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-dark mb-2">
                            <i class="ri-information-line me-2" style="color: #ff9f43;"></i>Important Notes
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li><span style="color: green;"><strong>Green</strong></span> = Passed</li>
                            <li><span style="color: red;"><strong>Red</strong></span> = Failed</li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th colspan="4" class="text-center">First Timer</th>
                                <th colspan="4" class="text-center">Repeater</th>
                                <th colspan="4" class="text-center">Overall Performance</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <th colspan="3"></th>
                                <th class="text-center">Passed</th>
                                <th class="text-center">Failed</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">%</th>

                                <th class="text-center">Passed</th>
                                <th class="text-center">Failed</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">%</th>

                                <th class="text-center">Passed</th>
                                <th class="text-center">Failed</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">%</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($LoadBoardPasser->result() as $boardpasser) : ?>

                                <?php
                                // Show major only if it exists
                                $major = !empty($boardpasser->MAJOR)
                                    ? "<small><b>({$boardpasser->MAJOR})</b></small>"
                                    : '';
                                ?>

                                <tr>
                                    <td>
                                        <?= $boardpasser->PROGRAM; ?> <?= $major; ?>
                                    </td>
                                    <td><?= $boardpasser->YEAR; ?></td>
                                    <td><?= $boardpasser->MONTH; ?></td>
                                    <!-- First Timer -->
                                    <td class="text-center"><span style="color: green;"><?= $boardpasser->FT_PASSED; ?></span></td>
                                    <td class="text-center"><span style="color: red;"><?= $boardpasser->FT_FAILED; ?></span></td>
                                    <td class="text-center"><?= ($boardpasser->FT_PASSED + $boardpasser->FT_FAILED); ?></td>
                                    <td class="text-center"><span style="color: black; font-weight: bold;"><?= $boardpasser->FT_TOTALPERCENT; ?></span></td>
                                    <!-- Repeater -->
                                    <td class="text-center"><span style="color: green;"><?= $boardpasser->RT_PASSED; ?></span></td>
                                    <td class="text-center"><span style="color: red;"><?= $boardpasser->RT_FAILED; ?></span></td>
                                    <td class="text-center"><?= ($boardpasser->RT_PASSED + $boardpasser->RT_FAILED); ?></td>
                                    <td class="text-center"><span style="color: black; font-weight: bold;"><?= $boardpasser->RT_TOTALPERCENT; ?></span></td>
                                    <!-- Overall Performance -->
                                    <td class="text-center"><span style="color: green;"><?= $boardpasser->OP_PASSED; ?></span></td>
                                    <td class="text-center"><span style="color: red;"><?= $boardpasser->OP_FAILED; ?></span></td>
                                    <td class="text-center"><?= ($boardpasser->OP_PASSED + $boardpasser->OP_FAILED); ?></td>
                                    <td class="text-center"><span style="color: black; font-weight: bold;"><?= $boardpasser->OP_GRANDTOTALPERCENT; ?></span></td>
                                    <!-- Action -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url("ims/boardpasser/edit/" . $boardpasser->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
                                                <a class="dropdown-item btnDelete" href="javascript:void(0);" data-id="<?= $boardpasser->ID; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <button type="submit" class="btn btn-outline-success btn-sm" id="btnGenerateExcelSelected">
                        <i class="ri-file-excel-2-line"></i> Generate Excel (for HEMIS Report)
                    </button>
                    <script>
                        $(document).on("click", "#btnGenerateExcelSelected", function() {
                            const tableData = [];
                            $("#dataTable tbody tr").each(function() {
                                const $row = $(this);
                                const rowData = {
                                    program: $row.find('td').eq(0).text().trim(),
                                    year: $row.find('td').eq(1).text().trim(),
                                    month: $row.find('td').eq(2).text().trim(),
                                    ft_passed: $row.find('td').eq(3).text().trim(),
                                    ft_failed: $row.find('td').eq(4).text().trim(),
                                    ft_total: $row.find('td').eq(5).text().trim(),
                                    ft_percent: $row.find('td').eq(6).text().trim(),
                                    rt_passed: $row.find('td').eq(7).text().trim(),
                                    rt_failed: $row.find('td').eq(8).text().trim(),
                                    rt_total: $row.find('td').eq(9).text().trim(),
                                    rt_percent: $row.find('td').eq(10).text().trim(),
                                    op_passed: $row.find('td').eq(11).text().trim(),
                                    op_failed: $row.find('td').eq(12).text().trim(),
                                    op_total: $row.find('td').eq(13).text().trim(),
                                    op_percent: $row.find('td').eq(14).text().trim()
                                };
                                tableData.push(rowData);
                            });

                            if (tableData.length === 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Data',
                                    text: 'No table data available to generate Excel.'
                                });
                                return;
                            }

                            // Submit via POST form
                            const csrfName = $('.txt_csrfname').attr('name');
                            const csrfValue = $('.txt_csrfname').val();

                            const form = $('<form>', {
                                action: "<?= base_url('ims/boardpasser/generateexcel'); ?>",
                                method: 'POST'
                            }).append(
                                $('<input>', {
                                    type: 'hidden',
                                    name: 'table_data',
                                    value: JSON.stringify(tableData)
                                }),
                                $('<input>', {
                                    type: 'hidden',
                                    name: csrfName,
                                    value: csrfValue
                                })
                            );
                            $('body').append(form);
                            form.submit();
                            form.remove();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url("BoardPasserController/deleteBoardPasser"); ?>" method="POST">
            <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <h4 class="modal-title" id="backDropModalTitle">Are you sure?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You won't be able to revert this!
                <input type="hidden" name="ID" id="ID">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- / Content -->
<script>
    $(document).ready(function() {

        $(document).on("click", ".btnDelete", function() {
            $("#ID").val($(this).data("id"));
        });
    });
</script>