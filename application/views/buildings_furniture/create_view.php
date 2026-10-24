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
            <form action="<?= base_url("BuildingsFurnitureController/saveBuildingFurniture") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="card-body">
                    <h5 class="card-title">Add Building & Furniture</h5>
                    <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                    <div class="row">
                        <h5>Number of Academic Classroom:</h5>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="USEBYSTUDENT" name="USEBYSTUDENT" placeholder="Use by Student" required />
                                <label for="USEBYSTUDENT">Use by Student<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="USEBYFACULTY" name="USEBYFACULTY" placeholder="Use by Faculty" required />
                                <label for="USEBYFACULTY">Use by Faculty<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="CLASSROOMSUBTOTAL" name="CLASSROOMSUBTOTAL" placeholder="Sub-Total" readonly />
                                <label for="CLASSROOMSUBTOTAL">Sub-Total<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <h5>Number of Academic Classroom (Use by Student):</h5>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="WITHTOILET" name="WITHTOILET" placeholder="With Toilet" required />
                                <label for="WITHTOILET">With Toilet<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="WITHOUTTOILET" name="WITHOUTTOILET" placeholder="Without Toilet" required />
                                <label for="WITHOUTTOILET">Without Toilet<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="COMMONTOILET" name="COMMONTOILET" placeholder="Common Toilet" required />
                                <label for="COMMONTOILET">Common Toilet<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <h5>Number of Academic Classroom (Conditions)::</h5>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="BUILDINGGOOD" name="BUILDINGGOOD" placeholder="Good" required />
                                <label for="BUILDINGGOOD">Good<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="BUILDINGMINOR" name="BUILDINGMINOR" placeholder="Minor Repair" required />
                                <label for="BUILDINGMINOR">Minor Repair<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="BUILDINGMAJOR" name="BUILDINGMAJOR" placeholder="Major Repair" required />
                                <label for="BUILDINGMAJOR">Major Repair<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="REPAIRSUBTOTAL" name="REPAIRSUBTOTAL" placeholder="Sub-Total (Minor + Major)" readonly />
                                <label for="REPAIRSUBTOTAL">Sub-Total (Minor + Major)<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Academic Classroom:</h5>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="DEMOLITION" name="DEMOLITION" placeholder="For Demolition" required />
                                <label for="DEMOLITION">For Demolition<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="CONSTRUCTION" name="CONSTRUCTION" placeholder="On-Going Contruction" required />
                                <label for="CONSTRUCTION">On-Going Construction<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" class="form-control" id="MAKESHIFT" name="MAKESHIFT" placeholder="Total Number of Makeshift" required />
                                <label for="MAKESHIFT">Total Number of Makeshift(Institution/PTA Funds)<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('USEBYSTUDENT').addEventListener('input', function() {
        updateClassroomSubtotal();
    });

    document.getElementById('USEBYFACULTY').addEventListener('input', function() {
        updateClassroomSubtotal();
    });

    function updateClassroomSubtotal() {
        const useBystudent = parseInt(document.getElementById('USEBYSTUDENT').value) || 0;
        const useByFaculty = parseInt(document.getElementById('USEBYFACULTY').value) || 0;
        const total = useBystudent + useByFaculty;
        document.getElementById('CLASSROOMSUBTOTAL').value = total;
    }


    document.getElementById('BUILDINGMINOR').addEventListener('input', function() {
        updateBuildingSubtotal();
    });
    document.getElementById('BUILDINGMAJOR').addEventListener('input', function() {
        updateBuildingSubtotal();
    });


    function updateBuildingSubtotal() {
        const buildingMinor = parseInt(document.getElementById('BUILDINGMINOR').value) || 0;
        const buildingMajor = parseInt(document.getElementById('BUILDINGMAJOR').value) || 0;
        const total = buildingMinor + buildingMajor;
        document.getElementById('REPAIRSUBTOTAL').value = total;
    }
</script>