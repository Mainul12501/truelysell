<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Verification Requests</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="status-toggle mb-3 d-flex">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 service_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Document type</th>
                                        <th>Document Name</th>
                                        <th>Download</th>
                                        <th>Reject Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language"data-toggle="modal" data-target="#rejReason" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td class="wrap-style">
                                            Just For Another Testing Purpose
                                        </td>
                                        <td><span class="badge badge-danger">Rejected</span></td>
                                    </tr>  
                                    <tr>
                                        <td>2</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td><span class="badge badge-success">Verified</span></td>
                                    </tr>            
                                    <tr>
                                        <td>3</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td>
                                            <select class="form-control form-width">
                                                <option value="">Select Status</option>
                                                <option value="2">Verified</option>
                                                <option value="3">Rejected</option>
                                            </select>
                                        </td>
                                    </tr>       
                                    <tr>
                                        <td>4</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td><span class="badge badge-success">Verified</span></td>
                                    </tr>            
                                    <tr>
                                        <td>5</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td>
                                            <select class="form-control form-width">
                                                <option value="">Select Status</option>
                                                <option value="2">Verified</option>
                                                <option value="3">Rejected</option>
                                            </select>
                                        </td>
                                    </tr>    
                                    <tr>
                                        <td>6</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td><span class="badge badge-success">Verified</span></td>
                                    </tr>            
                                    <tr>
                                        <td>7</td>
                                        <td>Adrrian</td>
                                        <td>Passport</td>
                                        <td><a href="javascript:;" class="link-style">passport.pdf</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm mr-2 export_language" title="Export to csv">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td><p class="">-</p></td>
                                        <td>
                                            <select class="form-control form-width">
                                                <option value="">Select Status</option>
                                                <option value="2">Verified</option>
                                                <option value="3">Rejected</option>
                                            </select>
                                        </td>
                                    </tr>         
                                </tbody>
                            </table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="rejReason">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Reject Reason</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
            <textarea class="form-control" rows="5" type="text" name="rej-reason" id="rej-reason" required="" placeholder="Enter Reason"></textarea>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary w-100">Submit</button>
      </div>

    </div>
  </div>
</div>