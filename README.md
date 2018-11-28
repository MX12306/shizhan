# shizhan

#### 项目介绍
灵盾网络空间安全竞赛答题平台 - 使用ThinkPHP5.0+Bootstrap3编写,此平台用于模拟网络空间安全赛项的第一阶段。
#### 项目截图
前端界面
![输入图片说明](https://images.gitee.com/uploads/images/2018/1128/213216_1d8cf9ae_1270405.png "屏幕截图.png")

后端界面
![输入图片说明](https://images.gitee.com/uploads/images/2018/1128/213310_3488efbf_1270405.png "屏幕截图.png")
![输入图片说明](https://images.gitee.com/uploads/images/2018/1128/213326_c470b257_1270405.png "屏幕截图.png")
#### 安装教程
1.环境要求:PHP5.5+
          mysql5.5+

2.将数据库导入到mysql服务器上,然后修改程序的配置文件
    修改\application\database.php
    // 服务器地址
    'hostname'        => 'localhost',
    // 数据库名
    'database'        => 'dbname',
    // 用户名
    'username'        => 'username',
    // 密码
    'password'        => 'password',
    // 端口
    'hostport'        => '3306',

3.将网站的运行目录指定到 “public” 注意目录防跨哦！！

4.配置重写规则 （列举Nginx重写方式）

    在nginx配置文件的  location / {下添加以下内容
            if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?s=/$1  last;
                break;
            }
    其它WEB容器详见:https://www.kancloud.cn/manual/thinkphp5/177576
#### 使用说明
1.系统默认预留账号 admin/admin
2.密码使用明文存储以及代码简单没做过多处理,请在内网环境搭建,尽量不要放在公网环境
3.剩下的功能慢慢研究咯~~~
#### 如果你有兴趣继续完善该平台那就完善吧！记得发我一份哦~~
#### 欢迎加入灵盾网的群 - 688282009