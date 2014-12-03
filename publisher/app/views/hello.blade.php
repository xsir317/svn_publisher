@extends('layouts.master')
@section('title')
欢迎！ @parent @stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'index'))
@stop

@section('content')
<article class="uk-article">
    <h1 class="uk-article-title">欢迎使用代码发布系统</h1>
    <p>本系统暂时只支持SVN，以后将逐步支持GIT。您可在“项目”菜单中找到自己要发布的项目，通过页面浏览项目的SVN历史纪录，选择要发布的版本和要发布的服务器，系统将把您选择的代码版本发布到指定服务器。</p>
    <p>权限由超级管理员管理，请向超级管理员联系获取您所在项目的权限。请注意，获得权限之后，您将对您的项目负责。</p>
    <h3>一般配置、使用说明</h3>
    <p>
        <h3>项目配置选项说明</h3>
        <section>
            <ul class="uk-list">
                <li>项目id： 每个项目有唯一的ID。</li>
                <li>项目名：项目通常的名称。请填写汉字或英文，确保准确，不要有歧义、误解或与其他项目混淆。</li>
                <li>项目管理员：项目负责人，如线上出现bug可能会首先联系此人。</li>
                <li>版本管理工具：目前请统一选择SVN，未来会支持GIT。</li>
                <li>源码地址：要发布的项目的SVN地址，请确认这是要发布的项目的跟目录。</li>
                <li>账号密码：请提供SVN读权限的账户，以及相应密码，确保系统可以成功获取项目代码。</li>
                <li>当前版本：当前本系统checkout的代码版本。</li>
                <li>同步时忽略：在源码目录中，但是不想发布到线上的文件。比如.svn文件夹、config文件、缓存目录内容等。（请使用相对路径）</li>
                <li>备注：关于项目的任何备注信息。</li>
                <li><strong>请注意，修改源码地址会导致发布服务器上check的代码完全清除并重新checkout，可能会消耗一些时间。</strong></li>
            </ul>
        </section>
        <h3>服务器配置选项说明</h3>
        <section>
            <ul class="uk-list">
                <li>服务器id： 每个服务器有唯一的ID。</li>
                <li>服务器名称：服务器名称，例如“XX项目测试环境”</li>
                <li>所属项目：请选择此服务器属于哪个项目</li>
                <li>服务器ip：请和运维确认好服务器和本发布系统的网络关系，确认填写内网还是外网IP。</li>
                <li>rsync模块名：rsync配置的模块名</li>
            </ul>
        </section>
        <h3>rsync服务器端配置说明</h3>
        <section>
            rsync配置要确认好服务器和本发布系统的网络关系，确认填写内网还是外网IP。<br />
            一个典型的rsync配置文件如下
            <pre>
uid = root
gid = root
port = 873
pid file = /tmp/rsyncd.pid
lock file = /tmp/rsync.lock
log file = /tmp/rsyncd.log

[xingyuntest]
path = /usr/local/nginx/html/xingyuntest
read only = false
host allow = 127.0.0.1,192.168.83.244
host deny = *
            </pre>
            本系统暂时只依赖指定IP安全性，不支持Rsync端指定帐号密码，所以请务必限制IP白名单。<br />
            更详细的配置请搜索rsync配置相关文章，<a href="http://www.cnblogs.com/mchina/p/2829944.html" target="_blank">例</a>。
        </section>
        <h3>发布操作</h3>
        <section></section>
    </p>
</article>
@stop