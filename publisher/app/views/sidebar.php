
<?php 
$sidebar = array(
    array('首页','/','index'),
    array('项目','/projects/index','projects'),
    array('服务器','/servers/index','servers'),
    array('权限分配','/admin/index','roles'),
    array('登出','/site/logout','logout'),
);
?>
<nav class="uk-panel uk-panel-box">
    <ul class="uk-nav uk-nav-side">
    <?php foreach($sidebar as $row):?>
        <li<?php if($row[2] == $currpage):?> class="uk-active"<?php endif; ?>><a href="<?php echo $row[1];?>"><?php echo $row[0];?></a></li>
    <?php endforeach;?>
    <ul>
</nav>