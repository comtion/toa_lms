<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/Product">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>มูลนิธิหัวใจแห่งประเทศไทย ในพระบรมราชูปถัมภ์</title>

<meta name="description" content="มูลนิธิหัวใจแห่งประเทศไทย ในพระบรมราชูปถัมภ์" />
<meta name="keywords" content="มูลนิธิหัวใจ,มูลนิธิหัวใจแห่งประเทศไทย, ในพระบรมราชูปถัมภ์" />
<!-- Facebook+ -->
<?php if( isset( $details ) ){ ?>
  <?php
    $title = iconv_substr( $details[0]['cp_titlehead'], 0, 100, "UTF-8")."..." ;
    $desc = str_replace("<br>", "", $details[0]['cp_titletext'] );
    $desc = str_replace("<span>","",$desc);
    $desc = str_replace("</span>","",$desc);
   ?>
  <meta property="og:title" content="<?php echo $title; ?>">
  <meta property="og:image:width" content="600">
  <meta property="og:image:height" content="315">
  <meta property="og:image" content="<?php echo base_url().'uploads/'.$details[0]['cp_titleimg']; ?>">
  <meta property="og:description" content="<?php echo trim(iconv_substr( $desc, 0, 290, "UTF-8")."..."," "); ?>">
  <meta property="og:url" content="<?php echo base_url().'category/details/'.$page.'/'.$details[0]['cpid']; ?>">
  <meta property="og:type" content="website" />
<?php }else{ ?>
  <meta property="og:title" content="มูลนิธิหัวใจแห่งประเทศไทย ในพระบรมราชูปถัมภ์">
  <meta property="og:image" content="<?php echo base_url(); ?>assets/img/skin/share.jpg">
  <meta property="og:image:width" content="600">
  <meta property="og:image:height" content="315">
  <meta property="og:description" content="มูลนิธิหัวใจแห่งประเทศไทย ในพระบรมราชูปถัมภ์">
  <meta property="og:url" content="<?php echo base_url(); ?>">
  <meta property="og:type" content="website" />
<?php } ?>


<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/skin/favicon.png" type="image/x-icon"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css" />
<!--<link type="text/css" rel="stylesheet" href="assets/css/scrollbar.min.css" />-->
