        
						<div id="loader" class="loader-div" hidden>
							<div class="loader-wrapper">
								<img src="<?=base_url('assets/images/other/loader.gif')?>" width="120" heigth="120">
							</div>
						</div>
						<div id="_account_backdrop"></div>
						<!-- Footer Start -->
						<footer class="footer">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6">
									<?=date('Y')?> &copy; <?=$siteSetting['website_name']?>   
								</div>
								<div class="col-md-6">
									<div class="footer-links d-none d-md-block footer-link-by">
										Developed by: <a href="<?=$siteSetting['developer_site']?>"><?=$siteSetting['developer']?></a>
									</div>
								</div>
							</div>
							</div>
						</footer>
					<!-- end Footer -->
					</div> 
				<!-- content-page -->
				</div> 
			<!-- end page-->
			</div>

			<script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
			<script src="<?=base_url('assets/js/vendor/select2.min.js')?>"></script>
			<script>
				var base_url = "<?=base_url();?>";
				var _state = <?=($state) ? '"'.$state.'"' : ''?>;
			</script>

			<?php if($state == 'dashboard') { ?><script>
			$('.select2').select2({
                dropdownParent: $('#_pos_modal .modal-content')
            });
			</script><?php } ?>
			<?php if($state == 'product_list') { ?><script>
			$('.product-category-select2').select2({
                dropdownParent: $('#add_product_modal .modal-content')
            });

			$('#edit_product_category_select2').select2({
                dropdownParent: $('#edit_product_modal .modal-content')
            });
			</script><?php } ?>
			
			<script src="<?=base_url()?>assets/js/_web_package.min.js"></script>
			<script src="<?=base_url()?>assets/js/_webapp.js?v=<?=filemtime('assets/js/_webapp.js')?>"></script>
			<script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>
			<script src="<?=base_url()?>assets/js/auth/_csrf.js?v=<?=filemtime('assets/js/auth/_csrf.js')?>"></script>

			<?= ($state == 'users_list' || $state == 'settings') ? '<script src="'.base_url().'assets/js/auth/_account.js?v='.filemtime('assets/js/auth/_account.js').'"></script>' : '' ?>

			<?= ($state == 'dashboard') ? '<script src="'.base_url().'assets/js/vendor/Chart.bundle.min.js"></script>
			<script src="'.base_url().'assets/js/auth/_statistics.js?v='.filemtime('assets/js/auth/_statistics.js').'"></script>
			<script src="'.base_url().'assets/js/auth/_user.js?v='.filemtime('assets/js/auth/_user.js').'"></script>
			<script src="'.base_url().'assets/js/vendor/bootstrap-datepicker.min.js"></script>' : '' ?>

			<?= ($state == 'reports') ? '<script src="'.base_url().'assets/js/auth/_reports.js?v='.filemtime('assets/js/auth/_reports.js').'"></script>
			<script src="'.base_url().'assets/js/vendor/moment.min.js"></script>
			<script src="'.base_url().'assets/js/vendor/daterangepicker.min.js"></script>' : '' ?>

			<?= ($state == 'activity_logs') ? '<script src="'.base_url().'assets/js/auth/_activity_logs.js?v='.filemtime('assets/js/auth/_activity_logs.js').'"></script>
			<script src="'.base_url().'assets/js/vendor/moment.min.js"></script>
			<script src="'.base_url().'assets/js/vendor/daterangepicker.min.js"></script>' : '' ?>

			<?php if($state == 'reports' || $state=='activity_logs') { ?><script>
			$(function() {
                $('#_select_date').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                });
            });
			</script><?php } ?>

			<?php if($state == 'view_order' || $state == 'reports') { ?><script>
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
			</script><?php } ?>
			
			<?php if($state == 'reports') { ?><script>
			$(function() {
                $('#_select_date_client_rep').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                });
            });
			</script><?php } ?>
			<?php if($state == 'dashboard') { ?><script>
			$('#date').datepicker();	
			</script><?php } ?>
			<?= ($state == 'product_list') ? '<script src="'.base_url().'assets/js/auth/_product.js"></script>' : '' ?>
			<script src="<?=base_url()?>assets/js/_access.js?v=<?=filemtime('assets/js/_access.js')?>"></script>
	</body>
</html>