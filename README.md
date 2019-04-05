# shizhan

#### 项目介绍
灵盾网络空间安全竞赛答题平台 - 使用ThinkPHP5.0+Bootstrap3编写,此平台用于模拟网络空间安全赛项的第一阶段。
### 演示站点

> test.ld80.cn
#### 项目截图
前端界面
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144406_ee65b732_1270405.png "屏幕截图.png")
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144453_b7c796a3_1270405.png "屏幕截图.png")
后端界面
![输入图片说明](https://gitee.com/uploads/images/2019/0405/144627_df6e2b5b_1270405.png "屏幕截图.png")
#### 安装教程
1.环境要求:PHP5.6以上
          mysql 5.5

2.将网站的运行目录指定到 “public”下，注意目录防跨哦！！

3.配置重写规则 （列举Nginx重写方式）
 apache服务器已存在.htaccess 只要确保服务器加载了mod_rewrite.so模块即可
如果是nginx服务器 需要添加以下代码到配置文件
    在nginx配置文件的  location / {下添加以下内容

```
            if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?s=/$1  last;
                break;
            }
```

    其它WEB容器详见:https://www.kancloud.cn/manual/thinkphp5/177576
4.打开网站,根据安装指引 填写数据库信息,管理员信息即可。

### 平台功能
 **前台部分** 
    1.基本的登录注册功能
    2.答题功能
    3.动态排行榜功能
    4.个人记录和成绩查询功能  
 **后台部分** 
    1.平台配置
    2.题目管理
    3.用户管理
3.剩下的功能慢慢研究咯~~~

 **

### 这也是平台最后一个功能 以后估计也不会怎么更新了** 
#### 如果你有兴趣继续完善该平台那就完善吧！记得发我一份哦~~
#### 作者QQ - 1834833515
#### 欢迎加入灵盾网的群 - 688282009