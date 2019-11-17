## 计忆论坛在Linux云服务器的安装

### 准备 LAMP 环境
LAMP 是 Linux、Apache、MySQL 和 PHP 的缩写，是 Discuz 论坛系统依赖的基础运行环境。我们先来准备 LAMP 环境

#### 安装 MySQL
使用 apt-get 安装 MySQL：

`apt-get install mysql-server -y`
安装完成后，启动 MySQL 服务：

`service mysqld restart`
将 MySQL 设置为开机自动启动：

#### 安装 Apache 组件

使用 apt-get 安装 Apache 组件：

`apt-get install httpd -y`
安装之后，启动 httpd 进程：

`service httpd start`
把 httpd 也设置成开机自动启动：

`chkconfig httpd on`

#### 安装PHP

使用 apt-get 安装 PHP：

`apt-get install php php-fpm php-mysql -y`
安装之后，启动 PHP-FPM 进程：

`service php-fpm start`
启动之后，可以使用下面的命令查看 PHP-FPM 进程监听哪个端口

`netstat -nlpt | grep php-fpm`
把 PHP-FPM 也设置成开机自动启动：

`chkconfig php-fpm on`

### 安装计忆论坛

#### 上传源码

将计忆论坛源代码利用SCP指令上传至云服务器

 `scp F:\GitHub\ComBBS.zip root@211.68.46.235:/var/www/html` 

详见[参考](https://zam90.github.io/2019/10/28/Windows与Linux服务器间快速上传、下载文件（SCP指令）)

#### 赋予读写权限
赋予 /var/www/html 目录及其子目录赋予权限

`chmod -R 777 /var/www/html`
重启 Apache

`service httpd restart`

#### 安装计忆论坛

在浏览器中输入`http://211.68.46.235/ComBBS`会自动跳转到安装界面，按提示安装即可

#### 安装GD图片支持库

 计忆论坛需要GD图片支持库才能实现对图片的处理，输入

`apt-get install php-gd` 

安装GD图片支持库

详见[参考](https://zam90.github.io/2019/10/30/Ubuntu上安装GD图片支持库)