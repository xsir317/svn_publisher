
<?php 
$sidebar = array(
    //显示名称、URL、菜单项、图标、管理员显示
    array('首页','/','index','uk-icon-home',false),
    array('项目','/projects/index','projects','uk-icon-gear',false),
    array('用户管理','/users/index','users','uk-icon-male',true),
    array('修改密码','/users/password','pwd','uk-icon-asterisk',false),
    array('权限分配','/admin/index','roles','uk-icon-users',false),
    array('登出','/logout','logout','uk-icon-sign-out',false),
);
?>
<nav class="uk-panel uk-panel-box">
    <ul class="uk-nav uk-nav-side">
    <?php foreach($sidebar as $row):?>
        <?php if($row[4] && !Auth::user()->is_superadmin) continue;?>
        <li<?php if($row[2] == $currpage):?> class="uk-active"<?php endif; ?>><a href="<?php echo $row[1];?>"><i class="<?php echo $row[3]?>"></i>&nbsp;&nbsp;<?php echo $row[0];?></a></li>
    <?php endforeach;?>
    <ul>
</nav>