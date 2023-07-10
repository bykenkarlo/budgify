                
                <div class="content-page">
                    <div class="content">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $siteSetting['website_name']; ?></a></li>
                                            <li class="breadcrumb-item active"><?=$title?></li>
                                        </ol>
                                    </div>
                                    <!-- <h4 class="page-title"><?=$title?></h4> -->
                                    <div class="margin-top-15 page-title">
                                        <button type="button" class="btn rounded btn-secondary mb-2" onclick="backPage()"><i class="uil-history-alt"></i> Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                    <div class="row mb-2">
                                        <div class="col-lg-12">
                                            <h2 class="font-20"><img src="<?=base_url('assets/images/other/account-settings.png')?>" alt="<?=$title?>" width="50px" draggable="false" class="me-1"> <?=$title?></h2>
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                           
                                        </div>
                                        <div class="col-lg-5 mt-2">
                                            
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            
                                        </div>

                                        <div class="mt-3 col-lg-6">
                                            <form action="" id="change_password_form">
                                                <div class="mt-2">
                                                    <h3>Change Password</h3>
                                                </div>
                                                <input type="hidden" id="csrf_token" name="<?=$csrf_data['name'];?>" value="<?=$csrf_data['hash'];?>" />
                                                <div class="form-floating mb-2">
                                                    <input type="password" name="password" class="form-control" id="password" required/>
                                                    <label for="password">Password</label>
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" required/>
                                                    <label for="confirm_password">Confirm Password</label>
                                                </div>
                                                <div class=" mb-2">
                                                    <span class="small cursor-pointer" id="show_password">Show Password</span>
                                                    <span class="small cursor-pointer" hidden="hidden" id="hide_password">Hide Password</span>
                                                </div>
                                                <div class="">
                                                    <button class="btn btn-primary rounded" button="submit" id="update_pass_btn">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
