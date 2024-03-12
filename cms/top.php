<?php
function creatSet($title, $menuType){
	$ryder_now =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$addList = $menuType."_list.php";
	$list_class = ($ryder_now == $addList) ? 'submenu current' : 'submenu';
	echo "<a href='".$addList."' class='".$list_class."'><img src='../cms/image/table.gif' width='16' height='16' border='0' align='absbottom'>".$title."設定</a>";
}
function creatList($title, $menuType){
	$ryder_now =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$addList = $menuType."_list.php";
	$list_class = ($ryder_now == $addList) ? 'submenu current' : 'submenu';
	echo "<a href='".$addList."' class='".$list_class."'><img src='../cms/image/table.gif' width='16' height='16' border='0' align='absbottom'>".$title."列表</a>";
}
function creatAdd($title, $menuType){
	$ryder_now =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$addTxt = $menuType."_add.php";
	$add_class = ($ryder_now == $addTxt) ? 'submenu current' : 'submenu';
	echo "<a href='".$addTxt."' class='".$add_class."'><img src='../cms/image/add.png' width='16' height='16' border='0' align='absbottom'>新增".$title."</a>";
}
function creatAll($title, $menuType){
	$ryder_now =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$addList = $menuType."_list.php";
	$addTxt = $menuType."_add.php";
	$list_class = ($ryder_now == $addList) ? 'submenu current' : 'submenu';
	$add_class = ($ryder_now == $addTxt) ? 'submenu current' : 'submenu';
	echo "<a href='".$addList."' class='".$list_class."'><img src='../cms/image/table.gif' width='16' height='16' border='0' align='absbottom'>".$title."列表</a><a href='".$addTxt."' class='".$add_class."'><img src='../cms/image/add.png' width='16' height='16' border='0' align='absbottom'>新增".$title."</a>";
}
function creatTableTop(){
	echo "<table class='ryder-menu-area' width='100%' height='25' border='0' align='center' cellpadding='3' cellspacing='0' bgcolor='#E4E4E4' ><tr><td align='left'>";
}
function creatTablBottom(){
	echo "</td></tr></table>";
}
?>
<script src="js/menu.js"></script>
<div id="cmsMenu">
	<ul>
		<?php if($row_RecLevelAuthority['a_2']=='1'){ ?>
		<li id="main_menu_2" class="main_menu <?php if ($menu_is=='news'): ?>main_menu_now<?php endif ?>">
			<a href="news_list.php"><div>最新消息</div></a>
		</li>
		<?php } ?>

		<?php if($row_RecLevelAuthority['a_3']=='1'){ ?>
		<!-- <li id="main_menu_3" class="main_menu <?php if ($menu_is=='media'): ?>main_menu_now<?php endif ?>">
			<a href="media_list.php"><div>媒體報導</div></a>
		</li> -->
		<?php } ?>

		<?php if($row_RecLevelAuthority['a_4']=='1'){ ?>
		<!-- <li id="main_menu_4" class="main_menu <?php if ($menu_is=='news'): ?>main_menu_now<?php endif ?>">
			<a href="news_list.php"><div>最新消息</div></a>
		</li> -->
		<?php } ?>

		<?php if($row_RecLevelAuthority['a_5']=='1'){ ?>
		<!-- <li id="main_menu_5" class="main_menu <?php if ($menu_is=='news'): ?>main_menu_now<?php endif ?>">
			<a href="news_list.php"><div>最新消息</div></a>
		</li> -->
		<?php } ?>

   	<?php if($row_RecLevelAuthority['a_6']=='1'){ ?>
   	<!-- <li id="main_menu_6" class="main_menu <?php if ($menu_is=='news'): ?>main_menu_now<?php endif ?>">
   		<a href="news_list.php"><div>最新消息</div></a>
   	</li> -->
   	<?php } ?>

   	<?php if($row_RecLevelAuthority['a_7']=='1'){?>
   	<!-- <li id="main_menu_7" class="main_menu <?php if ($menu_is=='news'): ?>main_menu_now<?php endif ?>">
   		<a href="news_list.php"><div>最新消息</div></a>
   	</li> -->
   	<?php } ?>

   	<?php if($row_RecLevelAuthority['a_9']=='1'){ ?>
   	<!-- <li id="main_menu_9" class="main_menu <?php if ($menu_is=='contact'): ?>main_menu_now<?php endif ?>">
   		<a href="contact_list.php"><div>聯絡我們</div></a>
   	</li> -->
   	<?php } ?>

   	<?php if($row_RecLevelAuthority['a_10']=='1'){ ?>
   	<!-- <li id="main_menu_10" class="main_menu <?php if ($menu_is=='keywords'): ?>main_menu_now<?php endif ?>">
   		<a href="keywords_list.php"><div>關鍵字SEO</div></a>
   	</li> -->
   	<?php } ?>

   	<?php if($row_RecLevelAuthority['a_1']=='1'){ ?>
    <!-- <li id="main_menu_1" class="main_menu <?php if ($menu_is=='authority'): ?>main_menu_now<?php endif ?>">
    	<a href="authority_list.php"><div>權限管理</div></a>
    </li> -->
    <?php } ?>
  </ul>
</div>
<?php
if($menu_is=="news"){

	creatTableTop();
	creatAll('最新消息', 'news');
	if($row_RecLevelAuthority['a_2']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="media"){

	creatTableTop();
	creatAll('media', 'media');
	echo '<br>';
	creatAll('media2', 'media2');
	if($row_RecLevelAuthority['a_3']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="store"){

	creatTableTop();
	creatAll('商店', 'store');
	creatAll('商店', 'storeC');
	if($row_RecLevelAuthority['a_4']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="menu"){

	creatTableTop();
	creatAll('菜單', 'menu');
	creatAll('菜單', 'menuC');
	if($row_RecLevelAuthority['a_5']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="menu"){

	creatTableTop();
	creatAll('菜單', 'menu');
	creatAll('菜單', 'menuC');
	if($row_RecLevelAuthority['a_6']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="menu"){

	creatTableTop();
	creatAll('菜單', 'menu');
	creatAll('菜單', 'menuC');
	if($row_RecLevelAuthority['a_7']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="contact"){

	creatTableTop();
	creatList('聯絡我們', 'contact');
	if($row_RecLevelAuthority['a_9']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="keywords"){

	creatTableTop();
	creatList('關鍵字SEO', 'keywords');
	if($row_RecLevelAuthority['a_10']=='0'){header("Location:first.php");}
	creatTablBottom();

}else if($menu_is=="authority"){

	creatTableTop();
	creatAll('管理員', 'authority');
	creatAll('權限管理群組', 'authorityC');
	if($row_RecLevelAuthority['a_1']=='0'){header("Location:first.php");}
	creatTablBottom();

}
?>

<div style="clear:both; height:20px;"></div>