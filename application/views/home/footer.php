        
		<div class="" id="_menu_backdrop"></div>
		
		<div id="loader" class="loader-div" hidden>
            <div class="loader-wrapper">
                <img src="<?=base_url('assets/images/other/loader.gif')?>" width="120" heigth="120">
            </div>
        </div>

		<div class="footer-div padding-bottom-50 pt-3">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						
					</div>

					<div class="col-lg-6">
			         
					</div>
					
					<div class="col-lg-6">
		            	
					</div>
					<div class="col-lg-3">
						
					</div>	

					<div class="col-lg-3">
						<ul class="no-list-style ml-n-3 footer-text">
							<!-- <li><a class="cursor-pointer" onclick="_accessPage('qr-code-generator')"></a></li> -->
						</ul>
					</div>	

				</div>
				<div class="mt-3 text-center footer-text font-13 ">
					&copy; <?=date('Y')?>. <?=$siteSetting['website_name']?> All rights reserved.
				</div>
			</div>
		</div>
		<!-- bundle -->

		<!-- <div id="_tos_privacy_consent" hidden="hidden">
		    This website uses cookies. By continuing to use this website you are giving consent to cookies being used. Visit our <a target="_blank" class="text-kwartz" rel="noopener" href="<?=base_url('terms')?>">Terms and Conditions</a> and <a target="_blank" rel="noopener" class="text-kwartz" href="<?=base_url('privacy')?>">Privacy Policy</a>. <button class="btn btn-kwartz c-white btn-agree-tos-privacy rounded" id="_agreed_tos_privacy">I Agree</button>
		</div> -->

								
		<script>
			var base_url = "<?=base_url();?>";
			var _state = <?=($state) ? '"'.$state.'"' : ''?>;
			<?= ($url_param !== '') ? "var _url_param = '".$url_param."';" : ''?>
			
		</script>
	    <script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
		<script src="<?=base_url()?>assets/js/_web_package.min.js"></script>
		<script src="<?=base_url()?>assets/js/_webapp.js?v=<?=filemtime('assets/js/_webapp.js')?>"></script>
		<script src="<?=base_url()?>assets/js/clipboard.min.js"></script>
		<script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>
		<script src="<?=base_url()?>assets/js/auth/_csrf.js?v=<?=filemtime('assets/js/auth/_csrf.js')?>"></script>
		
		<?php if ($state == 'statistics' || $state == 'account_dashboard') {?><script src="<?=base_url()?>assets/js/vendor/qr_code_styling.js"></script>
		<script src="<?=base_url()?>assets/js/vendor/croppie.js"></script>
		<script src="<?=base_url()?>assets/js/vendor/Chart.bundle.min.js"></script>
		<script src="<?=base_url()?>assets/js/vendor/moment.min.js"></script>
		<script src="<?=base_url()?>assets/js/vendor/daterangepicker.min.js"></script> <?php } ?>

		<?= ($state == 'statistics' || $state == 'account_dashboard') ? "
		<script>
		$('#_select_date').daterangepicker();
		</script>
		" : ''?>
		<?= ($state == 'account_dashboard') ? "
		<script>
		var skey = '".$this->session->secret_key."';
		</script>
		" : ''?>
		<?php if ($state == 'login') {?><script src="<?=base_url()?>assets/js/auth/_login.js"></script>
		<script src="<?=base_url()?>assets/js/vendor/croppie.js"></script><?php } ?>
		<script src="<?=base_url()?>assets/js/_access.js?v=<?=filemtime('assets/js/_access.js')?>"></script>
		
		<?php if ($state == 'statistics') {?><script>var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });</script>
		<?php } ?>
	</body>
</html>