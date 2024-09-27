<!-- Begin page -->
<!-- removeNotificationModal -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- sidebar laod form include file -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Requested Vendors List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="vendorRequestedList" class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SR No.</th>
                                            <th>Contact No</th>
                                            <th>Registration Document</th>
                                            <th>Account No</th>
                                            <th>Account Holder Name</th>
                                            <th>Bank Name</th>
                                            <th>Bank Branch</th>
                                            <th>FSSAI Licence Document</th>
                                            <th>Requested On</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->


        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Velzon.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by 2 Brothers
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>

<!-- JAVASCRIPT -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>
<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Dashboard init -->
<script src="assets/js/pages/dashboard-Ongyi.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(function() {
        getRequestedVendor();
    });

    function getRequestedVendor() {
        debugger;
        var obj = new Object();
        obj.Module = "Vendor";
        obj.Page_key = "getRequestedVendor";
        var json = new Object();
        obj.JSON = json;
        TransportCall(obj);
    }

    function onSuccess(rc) {
        if (rc.return_code) {
            switch (rc.Page_key) {
                case "getRequestedVendor":
                    loaddata(rc.return_data);
                    break;
                default:
                    notify("warning", rc.Page_key);
            }
        } else {
            notify("warning", rc.return_data);
        }
    }

    function loaddata(data) {
        $('#vendorRequestedList tbody').empty();

        $.each(data, function(index, item) {
            var row = $('<tr>');
            row.append($('<td>').text(index + 1)); // SR No.
            row.append($('<td>').text(item.ContactNo)); // Contact No

            // Construct URLs for documents
            var registrationDocUrl = 'file?type=vendorrccfile&name=' + encodeURIComponent(item.Registration_Document.split('/').pop());
            var fssaiDocUrl = 'file?type=vendordriverlicence&name=' + encodeURIComponent(item.FSSAILicenceDocument.split('/').pop());

            row.append($('<td>').html('<a href="' + registrationDocUrl + '" target="_blank"><i class="bx bxs-file-pdf" style="color:red;font-size: 1.5em;"></i></a>')); // Registration Document
            row.append($('<td>').text(item.AccountNo)); // Account No
            row.append($('<td>').text(item.AccountHolderName)); // Account Holder Name
            row.append($('<td>').text(item.BankName)); // Bank Name
            row.append($('<td>').text(item.BankBranch)); // Bank Branch
            row.append($('<td>').html('<a href="' + fssaiDocUrl + '" target="_blank"><i class="bx bxs-file-pdf" style="color:red; font-size: 1.5em;"></i></a>')); // FSSAI Licence Document
            row.append($('<td>').text(new Date(item.CreatedDateTime).toLocaleString())); // Requested On
            row.append($('<td>').text('Pending')); // Status
            row.append($('<td>').html(`
            <div class="dropdown d-inline-block">
                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-fill align-middle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                    <li>
                        <a class="dropdown-item remove-item-btn">
                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>
        `)); // Action Buttons

            $('#vendorRequestedList tbody').append(row);
        });

        $('#vendorRequestedList').DataTable({
            responsive: true
        });
    }


    function onError() {

    }
</script>
</body>


</html>