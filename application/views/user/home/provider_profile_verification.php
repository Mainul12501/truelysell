<div class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('user/home/provider_sidemenu');?>
			<div class="col-xl-9 col-md-8">
				<form id="payout_settings" action="<?php echo base_url()?>user/dashboard/update_payout_settings" method="POST" enctype="multipart/form-data">
					<div class="widget">
						<h4 class="widget-title">Profile Verification</h4>
                            <div class="row">
                                <div class="col-md-12">
                                   <div class="prov-verify-list">
                                        <div class="verify-blk">
                                            <div class="left-blk">
                                               <div class="icon-blk">
                                                    <i class="uil uil-phone-volume"></i>
                                               </div> 
                                               <div class="info-blk">
                                                    <h4>Phone Number Verification</h4>
                                                    <p>Not yet verified</p>
                                               </div>
                                            </div>
                                            <div class="right-blk">
                                               <a href="javascript:;" class="close-btn" data-toggle="tooltip" title="Not Verified" data-placement="left">
                                                    <i class="fas fa-times-circle"></i>
                                               </a> 
                                                <div class="action-blk">
                                                    <a href="javascript:;" class="btn btn-change" data-toggle="modal" data-target="#verifyMob">Change</a>
                                                    <a href="javascript:;" class="btn btn-delete">Delete</a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="verify-blk">
                                            <div class="left-blk">
                                               <div class="icon-blk">
                                                    <i class="uil uil-envelopes"></i>
                                               </div> 
                                               <div class="info-blk">
                                                    <h4>Email Verification</h4>
                                                    <p>Not yet verified</p>
                                               </div>
                                            </div>
                                            <div class="right-blk">
                                               <a href="javascript:;" class="close-btn" data-toggle="tooltip" title="Not Verified" data-placement="left">
                                                    <i class="fas fa-times-circle"></i>
                                               </a> 
                                                <div class="action-blk">
                                                    <a href="javascriEmailpt:;" class="btn btn-change" data-toggle="modal" data-target="#verifyEmail">Change</a>
                                                    <a href="javascript:;" class="btn btn-delete">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="verify-blk">
                                            <div class="left-blk">
                                               <div class="icon-blk">
                                                    <i class="uil uil-document-info"></i>
                                               </div> 
                                               <div class="info-blk">
                                                    <h4>Document Verification</h4>
                                                    <p>Not yet verified</p>
                                               </div>
                                            </div>
                                            <div class="right-blk">
                                               <a href="javascript:;" class="close-btn" data-toggle="tooltip" title="Not Verified" data-placement="left">
                                                    <i class="fas fa-times-circle"></i>
                                               </a> 
                                                <div class="action-blk">
                                                    <a href="javascript:;" class="btn btn-change" data-toggle="modal" data-target="#verifyDoc">Change</a>
                                                    <a href="javascript:;" class="btn btn-delete">Delete</a>
                                                </div>
                                            </div>
                                        </div>                                        
                                   </div>     
                                </div>
                            </div>
						</div>
					</form>
				</div>
			</div>
		</div>
   </div>
</div>



<div class="modal" id="verifyMob">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <h5 class="modal-title">Verify Your Phone Number</h5>
            <p>You will receive a 4 digit code to verify next</p>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group mb-0">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="Enter phone number">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#verifyMobOTP">Continue</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifyMobOTP">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <h5 class="modal-title">Enter OTP</h5>
            <p>Code is sent to +1 23456789</p>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <div class="form-group flex-input">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="0">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="0">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="0">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="0">
        </div>
        <p class="timecount-blk text-success">00:23</p>
        <p class="mb-0">Don’t receive code? <span class="text-danger">Resend Code</span></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#verifySuccess">Verify</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifySuccess">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <i class="uil uil-check-circle success-icon"></i>
            <h5 class="modal-title">Success</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Your phone number has been successfully verified</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-primary">Go to Dashboard</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifyEmail">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <h5 class="modal-title">Verify Your Email Address</h5>
            <p>Check your inbox for an verification link</p>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group mb-2">
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="Enter email address">
        </div>
        <p class="mb-0">Didn't Receive verification email? Please check your spam folder or try to send the email</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#verifyEmailSuccess">Continue</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifyEmailSuccess">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <i class="uil uil-check-circle success-icon"></i>
            <h5 class="modal-title">Success</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Your Email address has been successfully verified</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-primary">Go to Dashboard</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifyDoc">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <h5 class="modal-title">Verify Your Identity</h5>
            <p>Upload document</p>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group mb-2">
            <label>Document Name</label>
            <input class="form-control" type="text" name="enter-phno" id="enter-phno" value="" placeholder="Enter email address">
        </div>
        <div class="uploaded-doc-blk mb-3">
            <div class="info-left">
                <img src="<?php echo $base_url ?>assets/img/icons/file-pdf.svg" alt="">
                adharcard.pdf
            </div>
            <div class="info-right">
                <a href="javascript:;" class="text-danger">
                    <i class="uil uil-trash-alt"></i>
                </a>
            </div>
        </div>
        <p class="text-success"><i class="uil uil-check-circle success-icon mr-1"></i>Document uploaded successfully</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#verifyDocSuccess">Continue</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="verifyDocSuccess">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0 header-center-blk">
        <div>
            <i class="uil uil-check-circle success-icon"></i>
            <h5 class="modal-title">Success</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <p>Document is sent for approval for the admin once approved you will notified.</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-primary">Go to Dashboard</button>
      </div>

    </div>
  </div>
</div>
