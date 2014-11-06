
<?php 
$sidebar = array(
    array('首页','/','index'),
    array('项目','/projects/index','projects'),
    array('服务器','/servers/index','servers'),
    array('权限分配','/admin/index','roles'),
    array('登出','/site/logout','logout'),
);
?>
<ul>
<?php foreach($sidebar as $row):?>
    <li<?php if($row[2] == $currpage):?> class="active"<?php endif; ?>><a href="<?php echo $row[1];?>"><?php echo $row[0];?></a></li>
<?php endforeach;?>
<ul>