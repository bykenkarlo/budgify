<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=($title == 'index') ? $siteSetting['website_name'] .' - URL Shortener, Short URLs & Free Custom Link Shortener' : $title." | ".$siteSetting['website_name'] ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= ($title == 'index') ? $siteSetting['description'].' link management software, QR Code features, link shortener' : $description.' , link shortener' ?>"/>
        <meta name="keywords" content=""/>
        <meta name="theme-color" content="#064595" />
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="<?=$siteSetting['website_name']?>">

        <!-- App link -->
        <link rel="apple-touch-icon" href="" crossorigin="anonymous">
        <link rel="shortcut icon" href="<?=base_url('assets/images/logo/favicon.webp');?>">
        <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">
        <link rel="canonical" href="<?=$canonical_url;?>">
        
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link href="<?=base_url()?>assets/css/all.css?v=<?=filemtime('assets/css/all.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/mdi.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <?=($state  == 'new_blog' || $state == 'edit_blog') ? '<link href="'.base_url().'assets/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/css/croppie.css" rel="stylesheet" type="text/css" />':''?>
        
        <?=($state  == 'boarding') ? '<link href="'.base_url().'assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />':''?>

        <?=($state  == 'orders') ? '<link href="'.base_url().'assets/css/daterangepicker.css" rel="stylesheet" type="text/css" /> ':''?>

        
        <link href="<?=base_url()?>assets/css/styles.css?v=<?=filemtime('assets/css/styles.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/default.css?v=<?=filemtime('assets/css/default.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/theme.css?v=<?=filemtime('assets/css/theme.css')?>" rel="stylesheet" type="text/css" />
        <?=($state  == 'new_blog' || $state == 'edit_blog') ? '<link href="'.base_url().'assets/css/blog.css?v='.filemtime('assets/css/theme.css').'?>" rel="stylesheet" type="text/css" />':''?>

    </head>

    <body data-layout="detached" >
    <div class="position-relative">
		<div class="custom-alert-box" id="_custom_alert" hidden="hidden"></div>	
	</div>
    <!-- Begin page -->