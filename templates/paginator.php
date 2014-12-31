<?php
/**
* Snippet Name: Pagination for WordPress and Bootstrap
* Snippet URL: http://www.wpcustoms.net/snippets/pagination-for-wordpress-and-bootstrap/
*/
// usage:
if ($wp_query->max_num_pages > 1) :
wpc_pagination();
endif;



function wpc_pagination($pages = '', $range = 2)
{
$showitems = ($range * 2)+1;
global $paged;
if( empty($paged)) $paged = 1;
if($pages == '')
{
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages)
{
$pages = 1;
}
}

if(1 != $pages)
{
echo '<ul class="pagination pagination-lg text-center">';
	if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo '<li><a href="'.get_pagenum_link(1).'">FIRST</a></li>';
	if($paged > 1 && $showitems < $pages) echo '<li><a href="' .get_pagenum_link($paged - 1). '" rel="prev">previous</a></li>';

	for ($i=1; $i <= $pages; $i++)
	{
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	{
	echo ($paged == $i)? '<li class="active"><a href="#">'. $i .'</a></li>':'<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
	}
	}

	if ($paged < $pages && $showitems < $pages) echo '<li><a href="'.get_pagenum_link($paged + 1).'" rel="next">next</a></li>';
	if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo '<li><a href="'.get_pagenum_link($pages).'">LAST</a></li>';
	echo '</ul>';
}
} 