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
                                    <h4 class="page-title"><?=$title?></h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->
                        <div class="mb-5" >
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl-6">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="dropdown float-end">
                                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="uil uil-cog"></i>
                                                        </a>
                                                    </div>

                                                    <div class="">
                                                        <h2 class="tbl-title">Accounts</h2>
                                                    </div>
                                                    <div class="d-flex align-items-start" id="">
                                                        <div id="account_list">
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="dropdown float-end">
                                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="mdi mdi-dots-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="javascript:void(0);" class="dropdown-item">Last 7 days</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Last 30 days</a>
                                                            <a href="javascript:void(0);" class="dropdown-item">Last 3 Months</a>
                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <h2 class="tbl-title">Finance Tracker <span class="small text-muted">Last 30 days</span></h2>
                                                    </div>
                                                    <div class="">
                                                        <div class="row">
                                                            <!-- <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="card text-white bg-success-gradient overflow-hidden br-10">
                                                                    <div class="card-body dashboard-card">
                                                                        <h5 class="text-white fw-normal mt-0">Savings</h5>
                                                                        <div class="toll-free-box text-center">
                                                                            <h4> <i class="uil uil-wallet"></i><span id="savings">0.00</span></h4>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div> -->
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="card text-white bg-success-gradient overflow-hidden br-10">
                                                                    <div class="card-body dashboard-card">
                                                                        <h5 class="text-white fw-normal mt-0">Total Income</h5>
                                                                        <div class="toll-free-box text-center">
                                                                            <h4> <i class="uil uil-wallet"></i><span id="balance">0.00</span></h4>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-12">
                                                                <div class="card text-white bg-warning-gradient overflow-hidden br-10">
                                                                    <div class="card-body dashboard-card">
                                                                        <h5 class="text-white fw-normal mt-0">Total Expense</h5>
                                                                        <div class="toll-free-box text-center">
                                                                            <h4> <i class="uil uil-money-insert"></i><span id="expense">0.00</span></h4>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="p-2">
                                                                <h2 class="tbl-title">Expense Statistics</h2>
                                                            </div>
                                                            
                                                            <div class="p-2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="mb-2 col-lg-12">
                                                        <canvas id="expense_structure" class="apex-charts mt-3">
                                                            
                                                        </canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 col-xl-6">
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                        <div class="card">
                                            <div class="card-body table-responsive">
                                                <div class="d-flex justify-content-between">
                                                    <div class="p-2">
                                                        <h2 class="tbl-title">Records</h2>
                                                    </div>

                                                    <div class="p-2 mt-1">
                                                        <div class="">
                                                            <button class="btn btn-outline-primary btn-sm rounded"><i class="uil uil-filter"></i> Filter</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-centered table-hover mb-0 font-12">
                                                    <tbody id="cash_flow_tbl">
                                                        <tr class="cursor-pointer">
                                                            <td width="20" class="placeholder-glow"><div class="avatar-sm"><span class="avatar-title bg-primary rounded-circle"><i class="uil-ellipsis-h"></i></span></div></td>
                                                            <td>
                                                                <div class="placeholder-glow">
                                                                    <span class="placeholder col-4"></span><br>
                                                                    <span class="placeholder col-10"></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="placeholder-glow">
                                                                    <span class="placeholder col-10"></span><br>
                                                                    <span class="placeholder col-6"></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="cursor-pointer">
                                                            <td width="20" class="placeholder-glow"><div class="avatar-sm"><span class="avatar-title bg-primary rounded-circle"><i class="uil-ellipsis-h"></i></span></div></td>
                                                            <td>
                                                                <div class="placeholder-glow">
                                                                    <span class="placeholder col-4"></span><br>
                                                                    <span class="placeholder col-10"></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="placeholder-glow">
                                                                    <span class="placeholder col-10"></span><br>
                                                                    <span class="placeholder col-6"></span>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- <div class="card shadow-none mb-0" aria-hidden="true">
                                                            <div class="card-body row">
                                                                <div class="col-4 col-md-2 col-lg-2 ">
                                                                    <div class="avatar-sm placeholder-glow">
                                                                        <span class="avatar-title placeholder mt-1 bg-primary rounded-circle"> <i class="uil-ellipsis-h"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-8 col-md-6 col-lg-6">
                                                                    <div class="card-title placeholder-glow">
                                                                        <span class="placeholder col-6"></span><br>
                                                                        <span class="placeholder col-8"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-4 col-lg-4">
                                                                    <div class="card-text placeholder-glow">
                                                                        <span class="placeholder col-12"></span><br>
                                                                        <span class="placeholder col-6"></span>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> -->
                                                    </tbody>
                                                </table>
                                                <div class="row mb-4">
                                                    <div class="col-lg-6">
                                                        <div class="mt-2 float-start" id="cf_count"></div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mt-2  float-end" id="cf_pagination"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            <!-- add cash flow -->
                            <?php
                            if(empty($user_data['accounts']['account_id'])){ ?>
                            <div onclick="newAccount()" class="add-cashflow">
                                <i class="uil uil-plus"></i>
                            </div>
                            <?php } else { ?>
                            <div id="add_cashflow" class="add-cashflow" onclick="addCashflow()">
                                <i class="uil uil-plus"></i>
                            </div>
                            <?php } ?>
                            
                            

                        </div>
                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                        

                        <!-- Modals -->
                        <div class="modal fade margin-top-10 modal" id="add_account_modal"  role="dialog" aria-labelledby="" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="modal-title">
                                                <h3 class="text-left text-capitalize"> <i class="uil-plus-circle"></i> New Account</h3>
                                            </div>
                                            <form action="" id="add_account_form">
                                                <div class="row">
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select account_type" id="account_type" name="type" required>
                                                            </select>
                                                            <label for="type">Account Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input  type="text" name="account_name" class="form-control" id="account_name" required/>
                                                            <label for="account_name">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input  type="text" name="amount" class="form-control" id="account_amount" required/>
                                                            <label for="amount">Amount</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select currency" id="currency" name="currency" required>
                                                                <option value="PHP">PHP</option>
                                                                <option value="USD">USD</option>
                                                                <option value="EUR">EUR</option>
                                                            </select>
                                                            <label for="type">Currency</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                 <div class="text-end mb-2 mt-4">
                                                    <button class="btn btn-default br-25 btn-lg padding-right-20 padding-left-20" type="button" id="close_create_acct_btn">Cancel</button>
                                                    <button class="btn btn-primary br-25 btn-lg padding-right-20 padding-left-20" type="submit" id="create_account_btn">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade margin-top-10 modal" id="_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="modal-title">
                                                <h3 class="text-left text-capitalize"> <i class="uil-plus"></i> Add Record</h3>
                                            </div>
                                            <form action="" id="add_cashflow_form">
                                                <div class="row">
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select cf-input add-account-select" id="add_account_select" name="account_id" required>
                                                                <option disbled selected>Choose</option>
                                                            </select>
                                                            <label for="type">Account</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="type" name="type" required>
                                                                <option disbled selected>Choose</option>
                                                                <option value="expense">Expense</option>
                                                                <option value="income">Income</option>
                                                            </select>
                                                            <label for="type">Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input  type="text" name="amount" class="form-control cf-input" id="amount" required/>
                                                            <label for="amount">Amount</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input data-provide="datepicker" value="<?=date('m/d/Y')?>" type="text" name="date" class="form-control text-upppercase" id="date" required/>
                                                            <label for="date">Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <select class="select2 form-control category cf-input" data-toggle="select2"  name="category" id="category" required>
                                                        </select>
                                                    </div>
                                                    <div class="mt-2 col-lg-12 ">
                                                        <div class="form-floating mb-2">
                                                            <textarea type="text" name="description" class="form-control cf-input" id="description" style="height:100px;" required></textarea>
                                                            <label for="description">Description</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                 <div class="text-end mb-2 mt-4">
                                                    <button class="btn btn-default br-25 btn-lg padding-right-20 padding-left-20" type="button" id="close_cashflow_btn">Cancel</button>
                                                    <button class="btn btn-primary br-25 btn-lg padding-right-20 padding-left-20" type="submit" id="save_cashflow_btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade margin-top-10 modal" id="edit_record_modal"  role="dialog" aria-labelledby="" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="modal-title">
                                                <h3 class="text-left text-capitalize"> <i class="uil-pen"></i> Edit Record</h3>
                                            </div>
                                            <form action="" id="update_cashflow_form">
                                                <input  type="hidden" name="id" id="edit_id" />
                                               <input type="hidden" name="amount"  id="edit_amount" />
                                                <div class="row">
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select cf-input add-account-select" id="add_account_select" name="account_id" required readonly>
                                                                <option disabled selected>Choose</option>
                                                            </select>
                                                            <label for="type">Account</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="edit_type" name="type" required>
                                                                <option disabled selected>Choose</option>
                                                                <option value="expense">Expense</option>
                                                                <option value="income">Income</option>
                                                            </select>
                                                            <label for="type">Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input type="text" name="amount2" class="form-control" id="edit_amount2" required/>
                                                            <label for="edit_amount2">Amount</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input data-provide="datepicker" value="<?=date('m/d/Y')?>" type="text" name="date" class="form-control text-upppercase" id="edit_date" required/>
                                                            <label for="date">Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <select class="select2 form-control category" data-toggle="select2"  name="category" id="edit_category" required>
                                                        </select>
                                                    </div>
                                                    <div class="mt-2 col-lg-12 ">
                                                        <div class="form-floating mb-2">
                                                            <textarea type="text" name="description" class="form-control" id="edit_description" style="height:100px;" required></textarea>
                                                            <label for="description">Description</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                 <div class="text-end mb-2 mt-4">
                                                    <button class="btn btn-default br-25 btn-lg padding-right-20 padding-left-20 mt-1" type="button" id="close_cashflow_btn2">Cancel</button>
                                                    <button class="btn btn-dark br-25 btn-lg padding-right-20 padding-left-20 mt-1" type="button" onclick="comfirmRemoveCashflow()" data-id="" id="remove_cashflow_btn">Remove</button>
                                                    <button class="btn btn-primary br-25 btn-lg padding-right-20 padding-left-20 mt-1" type="submit" id="update_cashflow_btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
