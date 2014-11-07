
<?php 
$sidebar = array(
    array('首页','/','index','uk-icon-home'),
    array('项目','/projects/index','projects','uk-icon-gear'),
    array('服务器','/servers/index','servers','uk-icon-laptop'),
    array('权限分配','/admin/index','roles','uk-icon-users'),
    array('登出','/site/logout','logout','uk-icon-sign-out'),
);
?>
<nav class="uk-panel uk-panel-box">
    <ul class="uk-nav uk-nav-side">
    <?php foreach($sidebar as $row):?>
        <li<?php if($row[2] == $currpage):?> class="uk-active"<?php endif; ?>><a href="<?php echo $row[1];?>"><i class="<?php echo $row[3]?>"></i>&nbsp;&nbsp;<?php echo $row[0];?></a></li>
    <?php endforeach;?>
    <ul>
</nav>