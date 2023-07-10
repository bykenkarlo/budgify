                
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
                                            <h2 class="font-20"><img src="<?=base_url('assets/images/other/user-management.png')?>" alt="<?=$title?>" width="50px" draggable="false" class="me-1"> <?=$title?></h2>
                                        </div>

                                        <div class="col-lg-5 mt-2">
                                           <form class=" gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_user_form">
                                            <div class="col-auto">
                                                <label for="_keyword" class="visually-hidden">Search</label>
                                                <input type="search" class="form-control" name="search" id="_search" placeholder="Name, username,">
                                            </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-7 mt-2">
                                            <div class="mt-xl-0 text-end">
                                                <button type="button" class="btn rounded btn-primary mb-2" id="_add_new_user"><i class="uil-user-plus"></i> Add New User</button>
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="refreshUsersList()"><i class="uil-redo"></i> Refresh</button>
                                            </div>
                                        </div>  
                                    </div>
                                        <h1 class="card-title mb-3"></h1>
                                        <div class="">
                                        <table class="table table-hover mb-0 font-12">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="_loan_check_all" class="form-check-input cursor-pointer" id="_loan_check_all">
                                                        <label class="form-check-label" for="_loan_check_all">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Active</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_user_tbl">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="_user_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="_user_count"></div>
                                            </div>
                                        </div>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
                        <div id="_add_new_user_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content br-10">
                                    <div class="modal-body container-fluid">
                                        <form id="add_new_user_form">
                                            <div class=" row">
                                                <div class="modal-title">
                                                    <h3 class="text-left text-capitalize fw-400 margin-top-10"> <i class="uil uil-user-plus"></i> Add New User</h3>
                                                </div>
                                                <input type="hidden" id="csrf_token" name="<?=$csrf_data['name'];?>" value="<?=$csrf_data['hash'];?>" />
                                                <div class="mb-2 mt-3 col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="text" name="username" class="form-control" id="username" required/>
                                                        <label for="username">Username</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="text" name="name" class="form-control" id="name" required/>
                                                        <label for="name">Name</label>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-lg-12 mb-2">
                                                    <select class="form-select" id="_select_role" name="user_type" style="height: 55px !important;" aria-label="Select Role" required="">
                                                        <option value="" disabled="" selected>Select Role</option>
                                                        <option value="veterinarian">Veterinarian</option>
                                                        <option value="assistant">Assistant</option>
                                                        <option value="cashier">Cashier</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6 mb-2">
                                                    <div class="form-floating">
                                                        <input type="text" name="email_address" class="form-control email_address" id="email_address"/>
                                                        <label for="email_address">Email Addres</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="mobile_number" class="form-control commission" id="mobile_number"   />
                                                        <label for="mobile_number">Mobile Number</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-2">
                                                    <div class="">
                                                        <small>Default Password: 123456</small>
                                                    </div>
                                                </div>

                                                <div class="mb-2 col-lg-12 mt-3 ">
                                                    <div class="text-end mb-2">
                                                        <button type="submit" class="btn rounded btn-lg font-17 btn-primary me-1" id="save_user_details">Save Details</button>
                                                        <button type="button" class="btn rounded btn-lg font-17 btn-light" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="modal fade margin-top-10" id="_edit_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="_add_user_modal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form id="_edit_user_form" class="">
                                    <div class="modal-body container-fluid">
                                        <div class="">
                                            <div class="container">
                                                <h3 class="text-left" style="font-weight: 300; color: #3c3c3d;" class="text-capitalize margin-top-40"> <i class="uil uil-edit-alt"></i> Edit User</h3>
                                                <div class="margin-bottom-30 margin-top-20">
                                                    <div id="_edit_user_form_div" class="margin-top-20">
                                                        <div class="user-wrapper">

                                                            
                                                            <div class="form-floating mb-2">
                                                                <select class="form-select text-capitalize" id="_edit_user_type" name="user_type"  aria-label="Select User Type">
                                                                    <option value="" disabled="" selected>Select Role</option>
                                                                    <option value="veterinarian">Veterinarian</option>
                                                                    <option value="assistant">Assistant</option>
                                                                    <option value="cashier">Cashier</option>
                                                                    <option value="admin">Admin</option>
                                                                </select>
                                                                <label for="_edit_user_type">Select User Type</label>
                                                            </div>

                                                            <div class="form-floating mb-2">
                                                                <input type="text" name="name" class="form-control" id="_edit_name" required/>
                                                                <label for="_edit_name">Name</label>
                                                            </div>

                                                            <div class="form-floating mb-2">
                                                                <input type="text" name="username" class="form-control" id="_edit_username" required/>
                                                                <label for="_username">Username</label>
                                                            </div>

                                                            <div class="form-floating mb-2">
                                                                <input type="email" name="email_address" class="form-control" id="_edit_email" />
                                                                <label for="_email">Email Address</label>
                                                            </div>
                                                            <div class="form-floating mb-2">
                                                                <input type="number" name="mobile_number" class="form-control" id="_edit_mobile_number" />
                                                                <label for="_mobile_number">Mobile Number</label>
                                                            </div>

                                                            <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>" />
                                                            <input type="hidden" name="user_id" id="_user_id" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="text-end mb-2 mt-2">
                                            <button class="btn btn-primary c-white rounded" id="_submit_user_update_btn"  type="submit">Update</button>
                                            <button class="btn btn-secondary rounded" data-bs-dismiss="modal" type="button" id="_close_user_update_btn">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
