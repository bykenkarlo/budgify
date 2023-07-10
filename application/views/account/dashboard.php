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

                        <div class="row mb-5" >
                        
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <div class="">
                                            <h2 class="title-tbl">Actual Income and Expenses</h2>
                                        </div>
                                        <table class="table table-centered table-borderless mb-0">
                                            <thead class="table-primary">
                                                <tr class="cf-tr">
                                                    <th>Date</th>
                                                    <th>Category</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cash_flow_tbl">
                                                <tr>
                                                    <td>tes</td>
                                                    <td>test</td>
                                                    <td>test</td>
                                                    <td>tes</td>
                                                    <td>
                                                        <i class="uil uil-pen me-1"></i>
                                                        <i class="uil uil-trash"></i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-start" id="cf_count"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-end" id="cf_pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- add cash flow -->
                            <div id="add_cashflow" class="add-cashflow">
                                <i class="uil uil-plus text-primary"></i>
                            </div>

                        </div>
                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                        

                        <!-- Modals -->
                        <div class="modal fade margin-top-10 modal" id="_client_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="modal-title">
                                                <h3 class="text-left text-capitalize"> <i class="uil-plus"></i> Add Cash Flow Record</h3>
                                            </div>
                                            <form action="" id="add_cashflow_form">
                                                <div class="row">
                                                    <div class="mt-2 col-lg-12 ">
                                                        <div class="form-floating">
                                                            <input  type="text" name="date" class="form-control" id="amount" required/>
                                                            <label for="amount">Amount</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input data-provide="datepicker" value="<?=date('m/d/Y')?>" type="text" name="date" class="form-control text-upppercase" id="date" required/>
                                                            <label for="client_name">Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-6 ">
                                                        <div class="form-floating">
                                                            <input type="text" name="pet_name" class="form-control text-upppercase" id="pet_name"/>
                                                            <label for="pet_name">Category</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-lg-12 ">
                                                        <div class="form-floating mb-2">
                                                            <textarea type="text" name="remarks" class="form-control" id="report_remarks" style="height:100px;"></textarea>
                                                            <label for="remarks">Description</label>
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
