<?php
$url       = isset($url)       ? $url       : '#';
$linkClass = isset($linkClass) ? $linkClass : 'btn btn-xs btn-success';
$iconClass = isset($iconClass) ? $iconClass : 'fa fa-fw fa-power-off';
$linkTitle = isset($linkTitle) ? $linkClass : trans('core::actions.enable');
$disabled  = isset($disabled)  ? $disabled  : false;
?>
@include('core::admin._includes.actions._icon-link', compact('url', 'linkClass', 'linkTitle', 'iconClass'))
