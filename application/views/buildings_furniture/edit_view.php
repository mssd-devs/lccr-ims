<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Report</a>
            </li>
            <li class="breadcrumb-item active">Building & Furniture</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("BuildingsFurnitureController/updateBuildingFurniture") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php foreach ($LoadBuildingFurniture->result() as $buildings) : ?>
                    <input type="hidden" name="ID" value="<?= $buildings->ID; ?>">
                    <div class="card-body">
                        <h5 class="card-title">Add Building & Furniture</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <h5>Number of Academic Classroom:</h5>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="USEBYSTUDENT" name="USEBYSTUDENT" placeholder="Use by Student" value="<?= $buildings->USEBYSTUDENT; ?>" required />
                                    <label for="USEBYSTUDENT">Use by Student<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="USEBYFACULTY" name="USEBYFACULTY" placeholder="Use by Faculty" value="<?= $buildings->USEBYFACULTY; ?>" required />
                                    <label for="USEBYFACULTY">Use by Faculty<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="CLASSROOMSUBTOTAL" name="FT_PASSED" placeholder="Passed" required />
                                <label for="CLASSROOMSUBTOTAL">Sub-Total<span class="text-danger">*</span></label>
                            </div>
                        </div> -->
                        </div>
                        <br>
                        <div class="row">
                            <h5>Number of Academic Classroom (Use by Student):</h5>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="WITHTOILET" name="WITHTOILET" placeholder="With Toilet" value="<?= $buildings->WITHTOILET; ?>" required />
                                    <label for="WITHTOILET">With Toilet<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="WITHOUTTOILET" name="WITHOUTTOILET" placeholder="Without Toilet" value="<?= $buildings->WITHOUTTOILET; ?>" required />
                                    <label for="WITHOUTTOILET">Without Toilet<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="COMMONTOILET" name="COMMONTOILET" placeholder="Common Toilet" value="<?= $buildings->COMMONTOILET; ?>" required />
                                    <label for="COMMONTOILET">Common Toilet<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <h5>Number of Academic Classroom (Conditions)::</h5>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="BUILDINGGOOD" name="BUILDINGGOOD" placeholder="Good" value="<?= $buildings->BUILDINGGOOD; ?>" required />
                                    <label for="BUILDINGGOOD">Good<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="BUILDINGMINOR" name="BUILDINGMINOR" placeholder="Minor Repair" value="<?= $buildings->BUILDINGMINOR; ?>" required />
                                    <label for="BUILDINGMINOR">Minor Repair<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="BUILDINGMAJOR" name="BUILDINGMAJOR" placeholder="Major Repair" value="<?= $buildings->BUILDINGMAJOR; ?>" required />
                                    <label for="BUILDINGMAJOR">Major Repair<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <!-- <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="REPAIRSUBTOTAL" name="REPAIRSUBTOTAL" placeholder="Sub-Total" readonly />
                                <label for="REPAIRSUBTOTAL">Sub-Total<span class="text-danger">*</span></label>
                            </div>
                        </div> -->
                        </div>
                        <div class="row">
                            <h5>Academic Classroom:</h5>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="DEMOLITION" name="DEMOLITION" placeholder="For Demolition" value="<?= $buildings->DEMOLITION; ?>" required />
                                    <label for="DEMOLITION">For Demolition<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="CONSTRUCTION" name="CONSTRUCTION" placeholder="On-Going Contruction" value="<?= $buildings->CONSTRUCTION; ?>" required />
                                    <label for="CONSTRUCTION">On-Going Construction<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="MAKESHIFT" name="MAKESHIFT" placeholder="Total Number of Makeshift" value="<?= $buildings->MAKESHIFT; ?>" required />
                                    <label for="MAKESHIFT">Total Number of Makeshift(Institution/PTA Funds)<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>