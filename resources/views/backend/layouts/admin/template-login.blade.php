<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no"/>
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>EAKKARNYANG GROUP</title>
		<meta name="author" content="codepixer">
		<meta name="description" content="">
		<meta name="keywords" content="">
		@include("/backend/layouts/css")
	</head>
	<body>
		@yield("content")
		@include("/backend/layouts/js")
	</body>
</html>