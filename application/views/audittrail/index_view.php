<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Audit Trail</a>
            </li>
            <li class="breadcrumb-item active">Views</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">

            <div class="card-body">
                <h4>Audit Trail</h4>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action Taken</th>
                                <th>IP Address</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($LoadAudit->result() as $r) {
                            ?>
                                <tr>
                                    <td><?= $r->AT_NAME; ?></td>
                                    <td><?= $r->AT_ACTION; ?></td>
                                    <td><?= htmlspecialchars(!empty($r->AT_IP) ? $r->AT_IP : 'N/A'); ?></td>
                                    <td><?= $r->AT_DATE; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>