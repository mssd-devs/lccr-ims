<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Buildings & Furniture</a>
            </li>
            <li class="breadcrumb-item active">Views</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Buildings & Furniture</h5>
                    <!-- <small class="text-muted">List of board passers by program, year, and month.</small> -->
                </div>

                <a class="btn btn-primary btn-sm float-end d-inline-flex align-items-center"
                    href="<?= base_url('ims/buildingsfurniture/create'); ?>" id="button-addon2">
                    <i class="ri-add-circle-line me-1"></i> Add Buildings & Furniture
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2">No.</th>
                                <th colspan="3">Number of Academic Classroom</th>
                                <th colspan="3">Number of Academic Classroom (Use by Student)</th>
                                <th colspan="4">Number of Academic Classroom (Conditions)</th>
                                <th colspan="2">Academic Classroom</th>
                                <th rowspan="2">Total Number of Makeshift (Institution/PTA Funds)</th>
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <th>Use by Student</th>
                                <th>Use by Faculty</th>
                                <th>Sub-Total</th>
                                <th>With Toilet</th>
                                <th>W/O Toilet</th>
                                <th>Common Toilet</th>
                                <th>Good</th>
                                <th>Minor Repair</th>
                                <th>Major Repair</th>
                                <th>Sub-Total</th>
                                <th>For Demolition</th>
                                <th>On-Going Construction</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php foreach ($LoadBuildingFurniture->result() as $building) : ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $building->USEBYSTUDENT; ?></td>
                                    <td><?= $building->USEBYFACULTY; ?></td>
                                    <td><?= $building->CLASSROOMSUBTOTAL; ?></td>
                                    <td><?= $building->WITHTOILET; ?></td>
                                    <td><?= $building->WITHOUTTOILET; ?></td>
                                    <td><?= $building->COMMONTOILET; ?></td>
                                    <td><?= $building->BUILDINGGOOD; ?></td>
                                    <td><?= $building->BUILDINGMINOR; ?></td>
                                    <td><?= $building->BUILDINGMAJOR; ?></td>
                                    <td><?= $building->REPAIRSUBTOTAL; ?></td>
                                    <td><?= $building->DEMOLITION; ?></td>
                                    <td><?= $building->CONSTRUCTION; ?></td>
                                    <td><?= $building->MAKESHIFT; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url("ims/buildingsfurniture/edit/" . $building->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
                                                <a class="dropdown-item btnDelete" href="javascript:void(0);" data-id="<?= $building->ID; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>
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
                                    no: $row.find('td').eq(0).text().trim(),
                                    usebystudent: $row.find('td').eq(1).text().trim(),
                                    usebyfaculty: $row.find('td').eq(2).text().trim(),
                                    classroomsubtotal: $row.find('td').eq(3).text().trim(),
                                    withtoilet: $row.find('td').eq(4).text().trim(),
                                    withouttoilet: $row.find('td').eq(5).text().trim(),
                                    commontoilet: $row.find('td').eq(6).text().trim(),
                                    buildinggood: $row.find('td').eq(7).text().trim(),
                                    buildingminor: $row.find('td').eq(8).text().trim(),
                                    buildingmajor: $row.find('td').eq(9).text().trim(),
                                    repairsubtotal: $row.find('td').eq(10).text().trim(),
                                    demolition: $row.find('td').eq(11).text().trim(),
                                    construction: $row.find('td').eq(12).text().trim(),
                                    makeshift: $row.find('td').eq(13).text().trim()
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
                                action: "<?= base_url('ims/buildingsfurniture/generateexcel'); ?>",
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
        <form class="modal-content" action="<?= base_url("BuildingsFurnitureController/deleteBuildingFurniture"); ?>" method="POST">
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