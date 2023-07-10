                
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
                                            <h2 class="font-20"><img src="<?=base_url('assets/images/other/pet-shop.png')?>" alt="<?=$title?>" width="50px" draggable="false" class="me-1"> <?=$title?></h2>
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                           <form class="gy-2 gx-2 justify-content-xl-start" id="_search_form">
                                                <div class="col-auto">
                                                    <label for="_keyword" class="visually-hidden">Search</label>
                                                    <input type="search" class="form-control" name="search" id="_search" placeholder="User, activity...">
                                                </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-5 mt-2">
                                            <div for="_select_date" class="d-flex align-items-center">
                                                <label for="_select_date" class="form-label me-2">Date</label>
                                                <input value="<?=date('m/01/Y')?> - <?=date('m/t/Y')?>" type="text" class="form-control date me-2" id="_select_date" data-toggle="date-picker" data-cancel-class="btn-light">
                                                <button class="btn btn-primary c-white btn-md rounded" id="_sort_by_date">Sort</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-2">
                                            <div class="text-end">
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="refreshActivityLogs()"><i class="uil-redo"></i> Refresh</button>
                                            </div>
                                        </div>
                                    </div>

                                        <h1 class="card-title mb-3"></h1>
                                        <div class="">
                                        <table class="table table-hover mb-0 font-12">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Message Log</th>
                                                    <th>Browser</th>
                                                    <th>Platform</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_logs_tbl">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="_log_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="_log_count"></div>
                                            </div>
                                        </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>


                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
